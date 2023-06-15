<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\BankName;
use App\Models\Company;
use App\Models\multiPurchase;
use App\Models\PaymentOrder;
use App\Models\ReceiptOrder;
use App\Models\SubCompany;
use App\Models\SubSubCompany;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Purchase;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    public function ManagerView() {

        $payments = Payment::orderBy('id', 'DESC')->get();
        return view('manager.manager_view', compact('payments'));
    }

    public function ManagerEdit($id) {

        $payment = Payment::find($id);
        return view('manager.manager_edit', compact('payment'));
    }

    public function ManagerUpdate(Request $request, $id) {

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
            'number_order' => 'required',
            'date' => 'required',
            'gentlemen' => 'required',
            'supplier_name' => 'required',
            'price' => 'required',
            'price_name' => 'required',
            'due_date' => 'required',
            'financial_provision' => 'required',
            'number' => 'required',
            'bank_name' => 'required',
        ],[
            'number_order.required' => 'رقم اصدار طلب دفعة مطلوب',
            'date.required' => 'التاريخ  مطلوب',
            'gentlemen.required' => 'اسم السادة مطلوب',
            'supplier_name.required' => 'اسم المورد مطلوب',
            'price.required' => 'المبلغ مطلوب',
            'price_name.required' => 'المبلغ كتابة مطلوب',
            'due_date.required' => 'التاريخ المستحق للدفعة مطلوب',
            'financial_provision.required' => 'المخصص المالي مطلوب',
            'number.required' => 'الرقم مطلوب',
            'bank_name.required' => 'البنك المسحوب عليه مطلوب',
        ]);
        Payment::findOrFail($id)->update([
            'number_order' => $request->number_order,
            'date' => $request->date,
            'project_name' => $request->project_name,
            'project_number' => $request->project_number,
            'order_purchase_id' => $request->order_purchase_id,
            'gentlemen' => $request->gentlemen,
            'supplier_name' => $request->supplier_name,
            'price' => $request->price,
            'price_name' => $result,
            'due_date' => $request->due_date,
            'purchase_name' => $request->purchase_name,
            'financial_provision' => $request->financial_provision,
            'number' => $request->number,
            'bank_name' => $request->bank_name,
            'created_at' => Carbon::now(),
        ]);
        $request->session()->flash('status', 'تم تعديل اصدار طلب دفعة بنجاح');
        return redirect('/manager');
    }

    public function ManagerSure($id) {

        DB::table('payments')
            ->where('id', $id)
            ->update(['status_id' => 7]);
        return redirect()->back();

    }

    public function ManagerEye($id) {

        $payment = Payment::find($id);
        return view('manager.manager_eye', compact('payment'));
    }

    public function EyeUpdate(Request $request) {

        return redirect('/manager');
    }

    public function ManagerReceipt() {
        $receipt = ReceiptOrder::all();
        return view('receipt.approved.manager_receipt', compact('receipt'));
    }

    public function ManagerReceiptEdit($id) {

        $receipt = ReceiptOrder::findOrFail($id);
        return view('receipt.edit.manager_edit', compact('receipt'));
    }

    public function ManagerReceiptUpdate(Request $request, $id) {
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
        return redirect('/manager/receipt');
    }

    public function ManagerReceiptSure($id) {
        DB::table('receipt_orders')
            ->where('id', $id)
            ->update(['status_id' => 7]);
        return redirect()->back();
    }

    public function ManagerCommandView() {

        $paymentOrder = PaymentOrder::orderBy('id', 'DESC')->get();
        return view('manager.manager_command', compact('paymentOrder'));
    }

    public function ManagerCommandEdit($id) {

        $companies = Company::all();
        $paymentOrder = PaymentOrder::find($id);
        $subcompanies = SubCompany::all();
        $subsubcompanies = SubSubCompany::all();
        $banks = BankName::all();
        return view('manager.manager_command_edit', compact('paymentOrder',
            'companies', 'subcompanies', 'subsubcompanies', 'banks'));
    }

    public function ManagerCommandUpdate(Request $request , $id) {
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
        return redirect('/manager/command');
    }

    public function ManagerCommandSure($id) {

        DB::table('payment_orders')
            ->where('id', $id)
            ->update(['status_id' => 7]);
        Session()->flash('status', 'تم تأكيد الطلب بنجاح');
        return redirect()->back();
    }

    // Manager Material Function

    public function ManagerMaterialView() {

        $purchases = Purchase::orderBy('id', 'DESC')->get();
        return view('manager.material_view', compact('purchases'));
    }

    public function MaterialEdit($id) {

        $companies = Company::all();
        $subcompanies = SubCompany::all();
        $subsubcompanies = SubSubCompany::all();
        $multi_purchase = multiPurchase::where('purchase_id', $id)->get();
        $purchases = Purchase::findOrFail($id);
        return view('manager.material_edit', compact('purchases',
            'companies', 'subcompanies', 'subsubcompanies', 'multi_purchase'));
    }

    public function MaterialUpdate(Request $request, $id) {

        $request->validate([
            'company_id' => 'required',
            'subcompany_id' => 'required',
            'subsubcompany_id' => 'required',
            'teacher_name' => 'required',
            'date' => 'required',
            'purchase_name' => 'required',
        ],[
            'company_id.required' => 'اسم الشركة مطلوب',
            'subcompany_id.required' => 'اسم الفرع مطلوب',
            'subsubcompany_id.required' => 'اسم المشروع مطلوب',
            'teacher_name.required' => 'اسم الاستاذ مطلوب',
            'date.required' => 'التاريخ مطلوب',
            'purchase_name.required' => 'البيان مطلوب',
        ]);

        Purchase::findOrFail($id)->update([
            'company_id' => $request->company_id,
            'subcompany_id' => $request->subcompany_id,
            'subsubcompany_id' => $request->subsubcompany_id,
            'teacher_name' => $request->teacher_name,
            'financial_provision' => $request->financial_provision,
            'number' => $request->number,
            'date' => $request->date,
            'created_at' => Carbon::now(),
        ]);

        $multiIds = $request->input('multi');
        $purchaseNames = $request->input('purchase_name');
        $quantities = $request->input('quantity');
        $units = $request->input('unit');
        $modelNumbers = $request->input('model_number');
        foreach ($multiIds as $key => $multiId) {
            $data = [
                'purchase_name' => $purchaseNames[$key],
                'quantity' => $quantities[$key],
                'unit' => $units[$key],
                'model_number' => $modelNumbers[$key],
            ];
            multiPurchase::where('id', $multiId)->update($data);
        }

        $request->session()->flash('status', 'تم تعديل طلب مواد بنجاح');
        return redirect('/manager/material');
    }

    public function MaterialSure($id) {

        DB::table('purchases')
            ->where('id', $id)
            ->update(['status_id' => 7]);
        Session()->flash('status', 'تم تاكيد طلب مواد بنجاح');
        return redirect()->back();
    }

    public function MaterialReject($id) {

        DB::table('purchases')
            ->where('id', $id)
            ->update(['status_id' => 2]);
        Session()->flash('status', 'تم رفض طلب مواد بنجاح');
        return redirect()->back();
    }

    // End Manager Material Function

}
