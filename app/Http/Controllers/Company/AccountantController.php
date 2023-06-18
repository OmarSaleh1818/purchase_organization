<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\BankName;
use App\Models\Company;
use App\Models\SubCompany;
use App\Models\SubSubCompany;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\PartialPayment;
use App\Models\PaymentOrder;
use Illuminate\Support\Facades\DB;

class AccountantController extends Controller
{

    public function AccountantView() {

        $payment = PartialPayment::orderBy('id', 'DESC')->get();
        return view('accountant.account_view', compact('payment'));
    }

    public function PaymentEdit($id) {
        $companies = Company::all();
        $subcompanies = SubCompany::all();
        $subsubcompanies = SubSubCompany::all();
        $banks = BankName::all();
        $payment = PartialPayment::find($id);
        return view('accountant.payment_edit', compact('payment', 'companies'
        , 'subcompanies', 'subsubcompanies', 'banks'));
    }

    public function AccountUpdate(Request $request, $id) {

        $url = 'https://ahsibli.com/wp-admin/admin-ajax.php?action=date_numbers_1';
        $data = 'number='.$request->batch_payment;

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
            'gentlemen' => 'required',
            'supplier_name' => 'required',
            'batch_payment' => 'required',
            'due_date' => 'required',
            'financial_provision' => 'required',
            'number' => 'required',
        ], [
            'date.required' => 'التاريخ  مطلوب',
            'gentlemen.required' => 'اسم السادة مطلوب',
            'supplier_name.required' => 'اسم المورد مطلوب',
            'batch_payment.required' => 'المبلغ مطلوب',
            'due_date.required' => 'التاريخ المستحق للدفعة مطلوب',
            'financial_provision.required' => 'المخصص المالي مطلوب',
            'number.required' => 'الرقم مطلوب',
        ]);

        PartialPayment::findOrFail($id)->update([
            'date' => $request->date,
            'company_id' => $request->company_id,
            'subcompany_id' => $request->subcompany_id,
            'subsubcompany_id' => $request->subsubcompany_id,
            'project_number' => $request->project_number,
            'order_purchase_id' => $request->order_purchase_id,
            'gentlemen' => $request->gentlemen,
            'supplier_name' => $request->supplier_name,
            'batch_payment' => $request->batch_payment,
            'price_name' => $result,
            'due_date' => $request->due_date,
            'purchase_name' => $request->purchase_name,
            'financial_provision' => $request->financial_provision,
            'number' => $request->number,
            'bank_id' => $request->bank_id,
            'created_at' => Carbon::now(),
        ]);

        $request->session()->flash('status', 'تم حفظ طلب اصدار دفعة بنجاح');
        return redirect('/accountant');
    }

    public function AccountSure($id) {

        DB::table('partial_payments')
            ->where('id', $id)
            ->update(['status_id' => 5]);
        return redirect()->back();

    }

    public function AccountEye($id) {

        $payment = PartialPayment::find($id);
        return view('accountant.account_eye', compact('payment'));
    }

    public function AccountEyeUpdate(Request $request, $id) {
// Set cURL options
        $url = 'https://ahsibli.com/wp-admin/admin-ajax.php?action=date_numbers_1';
        $data = 'number='.$request->batch_payment;

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
            'gentlemen' => 'required',
            'supplier_name' => 'required',
            'due_date' => 'required',
            'financial_provision' => 'required',
            'number' => 'required',
            'bank_name' => 'required',
        ], [
            'date.required' => 'التاريخ  مطلوب',
            'gentlemen.required' => 'اسم السادة مطلوب',
            'supplier_name.required' => 'اسم المورد مطلوب',
            'due_date.required' => 'التاريخ المستحق للدفعة مطلوب',
            'financial_provision.required' => 'المخصص المالي مطلوب',
            'number.required' => 'الرقم مطلوب',
            'bank_name.required' => 'البنك المسحوب عليه مطلوب',
        ]);

        Payment::findOrFail($id)->update([
            'date' => $request->date,
            'company_id' => $request->company_id,
            'subcompany_id' => $request->subcompany_id,
            'subsubcompany_id' => $request->subsubcompany_id,
            'project_number' => $request->project_number,
            'order_purchase_id' => $request->order_purchase_id,
            'gentlemen' => $request->gentlemen,
            'supplier_name' => $request->supplier_name,
            'batch_payment' => $request->batch_payment,
            'price_name' => $result,
            'due_date' => $request->due_date,
            'purchase_name' => $request->purchase_name,
            'financial_provision' => $request->financial_provision,
            'number' => $request->number,
            'bank_id' => $request->bank_id,
            'created_at' => Carbon::now(),
        ]);

        $request->session()->flash('status', 'تم تعديل  اصدار طلب دفعة بنجاح');
        return redirect('/accountant');
    }

    public function FinanceView() {

        $payments = PartialPayment::orderBy('id', 'DESC')->get();
        return view('accountant.finance_view', compact('payments'));
    }

    public function FinanceSure($id) {

        DB::table('partial_payments')
            ->where('id', $id)
            ->update(['status_id' => 6]);
        return redirect()->back();

    }

    public function FinanceEdit($id) {
        $companies = Company::all();
        $subcompanies = SubCompany::all();
        $subsubcompanies = SubSubCompany::all();
        $banks = BankName::all();
        $payment = PartialPayment::find($id);
        return view('accountant.finance_edit', compact('payment', 'companies'
        , 'subsubcompanies', 'subcompanies', 'banks'));
    }

    public function FinanceUpdate(Request $request, $id) {


        $url = 'https://ahsibli.com/wp-admin/admin-ajax.php?action=date_numbers_1';
        $data = 'number='.$request->batch_payment;

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
            'gentlemen' => 'required',
            'supplier_name' => 'required',
            'batch_payment' => 'required',
            'due_date' => 'required',
            'financial_provision' => 'required',
            'number' => 'required',
        ], [
            'date.required' => 'التاريخ  مطلوب',
            'gentlemen.required' => 'اسم السادة مطلوب',
            'supplier_name.required' => 'اسم المورد مطلوب',
            'batch_payment.required' => 'المبلغ مطلوب',
            'due_date.required' => 'التاريخ المستحق للدفعة مطلوب',
            'financial_provision.required' => 'المخصص المالي مطلوب',
            'number.required' => 'الرقم مطلوب',
        ]);

        PartialPayment::findOrFail($id)->update([
            'date' => $request->date,
            'company_id' => $request->company_id,
            'subcompany_id' => $request->subcompany_id,
            'subsubcompany_id' => $request->subsubcompany_id,
            'project_number' => $request->project_number,
            'order_purchase_id' => $request->order_purchase_id,
            'gentlemen' => $request->gentlemen,
            'supplier_name' => $request->supplier_name,
            'batch_payment' => $request->batch_payment,
            'price_name' => $result,
            'due_date' => $request->due_date,
            'purchase_name' => $request->purchase_name,
            'financial_provision' => $request->financial_provision,
            'number' => $request->number,
            'bank_id' => $request->bank_id,
            'created_at' => Carbon::now(),
        ]);

        $request->session()->flash('status', 'تم حفظ اصدار طلب دفعة بنجاح');
        return redirect('/finance');
    }
    public function FinanceEye($id) {

        $payment = PartialPayment::find($id);
        return view('accountant.finance_eye', compact('payment'));
    }

    public function FinanceEyeUpdate(Request $request) {

        return redirect('/finance');
    }

    public function FinanceCommandView() {

        $paymentOrder = PaymentOrder::orderBy('id', 'DESC')->get();
        return view('accountant.finance_command', compact('paymentOrder'));
    }

    public function FinanceCommandSure($id) {

        DB::table('payment_orders')
            ->where('id', $id)
            ->update(['status_id' => 6]);
        return redirect()->back();
    }

    public function FinanceCommandEdit($id) {

        $companies = Company::all();
        $paymentOrder = PaymentOrder::find($id);
        $subcompanies = SubCompany::all();
        $subsubcompanies = SubSubCompany::all();
        $banks = BankName::all();
        return view('accountant.command_edit', compact('paymentOrder',
            'companies', 'subcompanies', 'subsubcompanies', 'banks'));
    }

    public function FinanceCommandUpdate(Request $request, $id) {
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
            'bank_name.required' => 'البنك المسحوب عليه مطلوب',
        ]);

        PaymentOrder::findOrFail($id)->update([
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

        $request->session()->flash('status', 'تم حفظ امر الدفع بنجاح');
        return redirect('/finance/command');
    }
}
