<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BankName;
use App\Models\CommandCatch;
use App\Models\Company;
use App\Models\ReceiptCatch;
use App\Models\SubCompany;
use App\Models\SubSubCompany;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\PartialPayment;
use App\Models\PaymentOrder;
use App\Models\ReceiptOrder;
use App\Models\ReceiptCommand;
use Illuminate\Support\Facades\DB;

class CatchReceiptController extends Controller
{

    public function ReceiptOrder() {

        $receipt = ReceiptOrder::orderBy('id', 'DESC')->get();
        $payments = PartialPayment::orderBy('id', 'DESC')->get();
        return view('receipt.receipt_order', compact('payments', 'receipt'));
    }

    public function ReceiptAdd($id) {

        $payment = PartialPayment::find($id);
        return view('receipt.add_receipt', compact('payment'));
    }

    public function ReceiptStore(Request $request) {

        $payments_id = $request->id;

        $request->validate([
            'date' => 'required',
            'benefit' => 'required',
            'currency_type' => 'required',
            'just' => 'required',
            'bank_name' => 'required',
            'check_number' => 'required',
            'iban_number' => 'required',

        ],[
            'date.required' => 'التاريخ مطلوب',
            'benefit.required' => 'المستفيد مطلوب',
            'currency_type.required' => 'نوع العملة مطلوب',
            'just.required' => 'فقط مطلوب',
            'bank_name.required' => 'البنك المسحوب عليه مطلوب',
            'check_number.required' => 'رقم الشيك مطلوب',
            'iban_number.required' => 'رقم الايبان مطلوب',
        ]);

        ReceiptOrder::insert([
            'date' => $request->date,
            'payment_id' => $request->payment_id,
            'company_name' => $request->company_name,
            'benefit' => $request->benefit,
            'currency_type' => $request->currency_type,
            'just' => $request->just,
            'bank_name' => $request->bank_name,
            'check_number' => $request->check_number,
            'iban_number' => $request->iban_number,
            'price' => $request->price,
            'project_name' => $request->project_name,
            'project_number' => $request->project_number,
            'purchase_name' => $request->purchase_name,
            'financial_provision' => $request->financial_provision,
            'number' => $request->number,
            'created_at' => Carbon::now(),
        ]);
        DB::table('partial_payments')
            ->where('id', $payments_id)
            ->update(['status_id' => 3]);

        $request->session()->flash('status', 'تم اضافة سند صرف بنجاح');
        return redirect('/receipt/order');
    }

    public function PrintReceipt($id) {

        $receipt = ReceiptOrder::findOrFail($id);
        return view('print.receipt.print_receipt', compact('receipt'));
    }

    public function AccountReceipt() {
        $receipt = ReceiptOrder::all();
        return view('receipt.approved.account_receipt', compact('receipt'));
    }

    public function AccountReceiptEdit($id) {

        $receipt = ReceiptOrder::findOrFail($id);
        return view('receipt.edit.account_edit', compact('receipt'));
    }

    public function AccountReceiptUpdate(Request $request, $id) {

        // Set cURL options
        $url = 'https://ahsibli.com/wp-admin/admin-ajax.php?action=date_numbers_1';
        $data = 'number='.$request->price;

        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'authority: ahsibli.com',
                'accept: */*',
                'accept-language: en-US,en;q=0.9,ar;q=0.8',
                'content-type: application/x-www-form-urlencoded; charset=UTF-8',
                'cookie: _gid=GA1.2.1200696489.1685273984; _gat_gtag_UA_166450035_1=1; _ga_ZSCB2L9KV5=GS1.1.1685273984.1.0.1685273984.0.0.0; _ga=GA1.1.554570941.1685273984; __gads=ID=5f01af1de5c542fc-22db0e9221e000e8:T=1685273984:RT=1685273984:S=ALNI_MYwwhfNBetLRtXSGsPPMr4LZdkrEA; __gpi=UID=00000c364d77d5ca:T=1685273984:RT=1685273984:S=ALNI_MZ7D_ac8H9HvpAIArSyXiZTznxl0Q',
                'origin: https://ahsibli.com',
                'referer: https://ahsibli.com/tool/number-to-words/',
                'sec-ch-ua: "Chromium";v="113", "Not-A.Brand";v="24"',
                'sec-ch-ua-mobile: ?0',
                'sec-ch-ua-platform: "Linux"',
                'sec-fetch-dest: empty',
                'sec-fetch-mode: cors',
                'sec-fetch-site: same-origin',
                'user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36',
                'x-requested-with: XMLHttpRequest'
            )
        );

// Initialize cURL session
        $curl = curl_init();
        curl_setopt_array($curl, $options);

// Execute the request
        $response = curl_exec($curl);

// Close the cURL session
        curl_close($curl);

// Extract the desired result using regular expressions
        $pattern = '/<table class="resultable">.*?<tr><td>الرقم بالحروف<\/td><td>(.*?)<\/td><\/tr>/s';
        preg_match($pattern, $response, $matches);

        if (isset($matches[1])) {
            $result = $matches[1];
        } else {
            echo 'Error';
        }

        $request->validate([
            'date' => 'required',
            'benefit' => 'required',
            'price' => 'required',
            'currency_type' => 'required',
            'bank_name' => 'required',
            'check_number' => 'required',
            'iban_number' => 'required',
            'financial_provision' => 'required',
        ]);

        ReceiptOrder::findOrFail($id)->update([
            'date' => $request->date,
            'project_name' => $request->project_name,
            'project_number' => $request->project_number,
            'price' => $request->price,
            'currency_type' => $request->currency_type,
            'just' => $result,
            'benefit' => $request->benefit,
            'purchase_name' => $request->purchase_name,
            'financial_provision' => $request->financial_provision,
            'number' => $request->number,
            'bank_name' => $request->bank_name,
            'check_number' => $request->check_number,
            'iban_number' => $request->iban_number,
            'created_at' => Carbon::now(),
        ]);

        $request->session()->flash('status', 'تم حفظ  سند الصرف بنجاح');
        return redirect('/account/receipt');
    }

    public function SureAccountSure($id) {

        DB::table('receipt_orders')
            ->where('id', $id)
            ->update(['status_id' => 5]);
        return redirect()->back();
    }

    public function FinanceReceipt() {
        $receipt = ReceiptOrder::all();
        return view('receipt.approved.finance_receipt', compact('receipt'));
    }

    public function FinanceReceiptEdit($id) {
        $receipt = ReceiptOrder::findOrFail($id);
        return view('receipt.edit.finance_edit', compact('receipt'));
    }

    public function FinanceReceiptUpdate(Request $request, $id) {

        // Set cURL options
        $url = 'https://ahsibli.com/wp-admin/admin-ajax.php?action=date_numbers_1';
        $data = 'number='.$request->price;

        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'authority: ahsibli.com',
                'accept: */*',
                'accept-language: en-US,en;q=0.9,ar;q=0.8',
                'content-type: application/x-www-form-urlencoded; charset=UTF-8',
                'cookie: _gid=GA1.2.1200696489.1685273984; _gat_gtag_UA_166450035_1=1; _ga_ZSCB2L9KV5=GS1.1.1685273984.1.0.1685273984.0.0.0; _ga=GA1.1.554570941.1685273984; __gads=ID=5f01af1de5c542fc-22db0e9221e000e8:T=1685273984:RT=1685273984:S=ALNI_MYwwhfNBetLRtXSGsPPMr4LZdkrEA; __gpi=UID=00000c364d77d5ca:T=1685273984:RT=1685273984:S=ALNI_MZ7D_ac8H9HvpAIArSyXiZTznxl0Q',
                'origin: https://ahsibli.com',
                'referer: https://ahsibli.com/tool/number-to-words/',
                'sec-ch-ua: "Chromium";v="113", "Not-A.Brand";v="24"',
                'sec-ch-ua-mobile: ?0',
                'sec-ch-ua-platform: "Linux"',
                'sec-fetch-dest: empty',
                'sec-fetch-mode: cors',
                'sec-fetch-site: same-origin',
                'user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36',
                'x-requested-with: XMLHttpRequest'
            )
        );

// Initialize cURL session
        $curl = curl_init();
        curl_setopt_array($curl, $options);

// Execute the request
        $response = curl_exec($curl);

// Close the cURL session
        curl_close($curl);

// Extract the desired result using regular expressions
        $pattern = '/<table class="resultable">.*?<tr><td>الرقم بالحروف<\/td><td>(.*?)<\/td><\/tr>/s';
        preg_match($pattern, $response, $matches);

        if (isset($matches[1])) {
            $result = $matches[1];
        } else {
            echo 'Error';
        }

        $request->validate([
            'date' => 'required',
            'benefit' => 'required',
            'price' => 'required',
            'currency_type' => 'required',
            'bank_name' => 'required',
            'check_number' => 'required',
            'iban_number' => 'required',
            'financial_provision' => 'required',
        ]);

        ReceiptOrder::findOrFail($id)->update([
            'date' => $request->date,
            'project_name' => $request->project_name,
            'project_number' => $request->project_number,
            'price' => $request->price,
            'currency_type' => $request->currency_type,
            'just' => $result,
            'benefit' => $request->benefit,
            'purchase_name' => $request->purchase_name,
            'financial_provision' => $request->financial_provision,
            'number' => $request->number,
            'bank_name' => $request->bank_name,
            'check_number' => $request->check_number,
            'iban_number' => $request->iban_number,
            'created_at' => Carbon::now(),
        ]);

        $request->session()->flash('status', 'تم حفظ  سند الصرف بنجاح');
        return redirect('/finance/receipt');

    }

    public function FinanceAccountSure($id) {
        DB::table('receipt_orders')
            ->where('id', $id)
            ->update(['status_id' => 6]);
        return redirect()->back();
    }

    public function ReceiptCommand() {

        $command = ReceiptCommand::orderBy('id', 'DESC')->get();
        $commands = PaymentOrder::orderBy('id', 'DESC')->get();
        return view('receipt.receipt_command', compact('commands', 'command'));
    }

    public function AddReceiptCommand($id) {
        $companies = Company::all();
        $subcompanies = SubCompany::all();
        $subsubcompanies = SubSubCompany::all();
        $banks = BankName::all();
        $payments = PaymentOrder::find($id);
        return view('receipt.add_receipt_command', compact('payments', 'companies'
        , 'subcompanies', 'subsubcompanies', 'banks'));
    }

    public function CatchReceipt() {
        $receipt_catch = ReceiptCatch::orderBy('id', 'DESC')->get();
        $catch = CommandCatch::orderBy('id', 'DESC')->get();
        return view('receipt.catch_receipt', compact('catch', 'receipt_catch'));
    }

    public function ReceiptCommandStore(Request $request) {

        $payments_id = $request->id;

        // Set cURL options
        $url = 'https://ahsibli.com/wp-admin/admin-ajax.php?action=date_numbers_1';
        $data = 'number='.$request->price;

        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'authority: ahsibli.com',
                'accept: */*',
                'accept-language: en-US,en;q=0.9,ar;q=0.8',
                'content-type: application/x-www-form-urlencoded; charset=UTF-8',
                'cookie: _gid=GA1.2.1200696489.1685273984; _gat_gtag_UA_166450035_1=1; _ga_ZSCB2L9KV5=GS1.1.1685273984.1.0.1685273984.0.0.0; _ga=GA1.1.554570941.1685273984; __gads=ID=5f01af1de5c542fc-22db0e9221e000e8:T=1685273984:RT=1685273984:S=ALNI_MYwwhfNBetLRtXSGsPPMr4LZdkrEA; __gpi=UID=00000c364d77d5ca:T=1685273984:RT=1685273984:S=ALNI_MZ7D_ac8H9HvpAIArSyXiZTznxl0Q',
                'origin: https://ahsibli.com',
                'referer: https://ahsibli.com/tool/number-to-words/',
                'sec-ch-ua: "Chromium";v="113", "Not-A.Brand";v="24"',
                'sec-ch-ua-mobile: ?0',
                'sec-ch-ua-platform: "Linux"',
                'sec-fetch-dest: empty',
                'sec-fetch-mode: cors',
                'sec-fetch-site: same-origin',
                'user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36',
                'x-requested-with: XMLHttpRequest'
            )
        );

// Initialize cURL session
        $curl = curl_init();
        curl_setopt_array($curl, $options);

// Execute the request
        $response = curl_exec($curl);

// Close the cURL session
        curl_close($curl);

// Extract the desired result using regular expressions
        $pattern = '/<table class="resultable">.*?<tr><td>الرقم بالحروف<\/td><td>(.*?)<\/td><\/tr>/s';
        preg_match($pattern, $response, $matches);

        if (isset($matches[1])) {
            $result = $matches[1];
        } else {
            echo 'Error';
        }
        $request->validate([
            'date' => 'required',
            'benefit_name' => 'required',
            'price' => 'required',
            'currency_type' => 'required',
            'bank_id' => 'required',
        ],[
            'date.required' => 'التاريخ مطلوب',
            'benefit_name.required' => 'اسم المستفيد مطلوب',
            'price.required' => 'المبلغ مطلوب',
            'currency_type.required' => 'نوع العملة مطلوب',
            'bank_id.required' => 'البنك المسحوب عليه مطلوب',
        ]);

        ReceiptCommand::insert([
            'date' => $request->date,
            'company_id' => $request->company_id,
            'subcompany_id' => $request->subcompany_id,
            'subsubcompany_id' => $request->subsubcompany_id,
            'benefit_name' => $request->benefit_name,
            'price' => $request->price,
            'currency_type' => $request->currency_type,
            'just' => $result,
            'bank_id' => $request->bank_id,
            'check_number' => $request->check_number,
            'iban_id' => $request->iban_id,
            'purchase_name' => $request->purchase_name,
            'project_number' => $request->project_number,
            'financial_provision' => $request->financial_provision,
            'number_financial' => $request->number_financial,
            'created_at' => Carbon::now(),
        ]);

        DB::table('payment_orders')
            ->where('id', $payments_id)
            ->update(['status_id' => 3]);

        $request->session()->flash('status', 'تم ارسال امر سند صرف بنجاح');
        return redirect('/receipt/command');

    }

    public function PrintReceiptCommand($id) {

        $receipt = ReceiptCommand::findOrFail($id);
        return view('print.receipt.receipt_command', compact('receipt'));
    }


}
