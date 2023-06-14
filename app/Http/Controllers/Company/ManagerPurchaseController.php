<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\multiPurchase;
use App\Models\MultiPurchaseOrder;
use App\Models\MultiPayment;
use App\Models\Payment;
use App\Models\PartialPayment;
use App\Models\PurchaseOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagerPurchaseController extends Controller
{

    public function ManagerPurchaseView() {

        $purchases = PurchaseOrder::orderBy('status_id', 'ASC')->orderBy('id', 'DESC')->get();
        return view('manager_purchase.purchase_view', compact( 'purchases'));
    }

    public function ManagerPurchaseEdit($id) {

        $purchases = PurchaseOrder::findOrFail($id);
        $multi_purchase = MultiPurchaseOrder::where('purchaseOrder_id', $id)->get();
        $multi_payment = MultiPayment::where('payment_id', $id)->get();
        return view('manager_purchase.purchase_edit', compact('purchases',
            'multi_purchase', 'multi_payment'));
    }

    public function ManagerPurchaseUpdate(Request $request, $id) {

        $request->validate([
            'gentlemen' => 'required',
            'professor_care' => 'required',
            'order_purchase_date' => 'required',
            'total' => 'required',
            'discount' => 'required',
            'total_discount' => 'required',
            'added_vat' => 'required',
            'total_vat' => 'required',
            'delivery_location' => 'required',
            'delivery_date' => 'required',
        ],[
            'gentlemen.required' => 'اسم السادة مطلوب',
            'professor_care.required' => 'عناية الاستاذ  مطلوب',
            'order_purchase_date.required' => 'تاريخ طلب الشراء مطلوب',
            'total.required' => 'المجموع مطلوب',
            'discount.required' => 'الخصم مطلوب',
            'total_discount.required' => 'الاجمالي بعد الخصم مطلوب',
            'added_vat.required' => 'الضريبة المضافة مطلوب',
            'total_vat.required' => 'الاجمالي بعد الضريبة مطلوب',
            'delivery_location.required' => 'موقع التسليم مطلوب',
            'delivery_date.required' => 'تاريخ التسليم مطلوب',
        ]);
            PurchaseOrder::findOrFail($id)->update([
                'gentlemen' => $request->gentlemen,
                'professor_care' => $request->professor_care,
                'order_purchase_number' => $request->order_material_id,
                'order_purchase_date' => $request->order_purchase_date,
                'order_material_id' => $request->order_material_id,
                'project_name' => $request->project_name,
                'project_number' => $request->project_number,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'subject' => $request->subject,
                'financial_provision' => $request->financial_provision,
                'number' => $request->number,
                'total' => $request->total,
                'discount' => $request->discount,
                'total_discount' => $request->total_discount,
                'added_vat' => $request->added_vat,
                'total_vat' => $request->total_vat,
                'delivery_location' => $request->delivery_location,
                'delivery_date' => $request->delivery_date,
                'description' => $request->description,
                'created_at' => Carbon::now(),
            ]);
        $multiIds = $request->input('payment');
        $payment_price = $request->input('payment_price');
        $payment_date = $request->input('payment_date');

// Remove deleted payment records
        $existingPaymentIds = MultiPayment::pluck('id')->toArray();
        $deletedPaymentIds = array_diff($existingPaymentIds, $multiIds);
        MultiPayment::whereIn('id', $deletedPaymentIds)->delete();

// Update existing payment records and create new ones
        foreach ($multiIds as $key => $multiId) {
            $data = [
                'payment_price' => $payment_price[$key],
                'payment_date' => $payment_date[$key],
            ];

            if ($data['payment_price'] !== null && $data['payment_date'] !== null) {
                if ($multiId != '') {
                    MultiPayment::where('id', $multiId)->update($data);
                } else {
                    // Retrieve the corresponding payment record
                    $payment = PurchaseOrder::find($id);
                    if ($payment) {
                        // Add the following line to set the payment_id for new records
                        $data['payment_id'] = $payment->id;

                        MultiPayment::create($data);
                    }
                }
            }
        }

        $multiIds = $request->input('multi');
        $purchaseNames = $request->input('purchase_name');
        $quantities = $request->input('quantity');
        $units = $request->input('unit');
        $modelNumbers = $request->input('model_number');
        $price = $request->input('price');
        $total_price = $request->input('total_price');
        foreach ($multiIds as $key => $multiId) {
            $data = [
                'purchase_name' => $purchaseNames[$key],
                'quantity' => $quantities[$key],
                'unit' => $units[$key],
                'model_number' => $modelNumbers[$key],
                'price' => $price[$key],
                'total_price' => $total_price[$key],
            ];
            MultiPurchaseOrder::where('id', $multiId)->update($data);
        }

        $request->session()->flash('status', 'تم حفظ طلب شراء بنجاح');
        return redirect('/manager/purchase');
    }

    public function PurchaseSure($id) {

        DB::table('purchase_orders')
            ->where('id', $id)
            ->update(['status_id' => 7]);
        Session()->flash('status', 'تم تاكيد طلب الشراء بنجاح');
        return redirect()->back();
    }

    public function PurchaseReject($id) {

        DB::table('purchase_orders')
            ->where('id', $id)
            ->update(['status_id' => 2]);
        Session()->flash('status', 'تم رفض طلب الشراء بنجاح');
        return redirect()->back();
    }

    // All Manager Payment Fanction

    public function ManagerPaymentView() {

        $partials = PartialPayment::orderBy('id', 'ASC')->get();
        return view('manager_purchase.payment_view', compact(  'partials'));
    }

    public function ManagerPaymentEdit($id) {

        $payment = PartialPayment::findOrFail($id);
        return view('manager_purchase.payment_edit', compact('payment'));
    }

    public function ManagerPaymentUpdate(Request $request, $id) {

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
            'batch_payment' => 'required',
            'due_date' => 'required',
            'financial_provision' => 'required',
            'number' => 'required',
            'bank_name' => 'required',
        ], [
            'date.required' => 'التاريخ  مطلوب',
            'gentlemen.required' => 'اسم السادة مطلوب',
            'supplier_name.required' => 'اسم المورد مطلوب',
            'batch_payment.required' => 'المبلغ مطلوب',
            'due_date.required' => 'التاريخ المستحق للدفعة مطلوب',
            'financial_provision.required' => 'المخصص المالي مطلوب',
            'number.required' => 'الرقم مطلوب',
            'bank_name.required' => 'البنك المسحوب عليه مطلوب',
        ]);

        PartialPayment::findOrFail($id)->update([
            'date' => $request->date,
            'project_name' => $request->project_name,
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
            'bank_name' => $request->bank_name,
            'created_at' => Carbon::now(),
        ]);

        $request->session()->flash('status', 'تم حفظ  اصدار طلب دفعة بنجاح');
        return redirect('/manager/payment');
    }

    public function ManagerPaymentReject($id) {

        DB::table('partial_payments')
            ->where('id', $id)
            ->update(['status_id' => 2]);
        Session()->flash('status', 'تم رفض الطلب بنجاح');
        return redirect()->back();
    }

    public function ManagerPaymentSure($id) {

        DB::table('partial_payments')
            ->where('id', $id)
            ->update(['status_id' => 7]);
        Session()->flash('status', 'تم تاكيد الطلب بنجاح');
        return redirect()->back();
    }



    // End


}
