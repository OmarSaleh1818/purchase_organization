<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\PurchaseOrder;
use App\Models\Purchase;
use App\Models\multiPurchase;
use App\Models\MultiPurchaseOrder;
use App\Models\MultiPayment;
use App\Models\SubCompany;
use App\Models\SubSubCompany;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchase = Purchase::orderBy('status_id', 'DESC')->orderBy('id', 'ASC')->get();
        $purchases = PurchaseOrder::all();
        return view('purchases.purchase_order', compact('purchases', 'purchase'));
    }

    public function AddPurchase($id) {

        $multi_purchase = multiPurchase::where('purchase_id', $id)->get();
        $purchase = Purchase::find($id);
        return view('purchases.add_purchase', compact('purchase', 'multi_purchase'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $purchase_id = $request->id;
        $request->validate([
            'professor_care' => 'required',
            'order_purchase_date' => 'required',
            'price' => 'required',
            'total' => 'required',
            'discount' => 'required',
            'total_discount' => 'required',
            'added_vat' => 'required',
            'total_vat' => 'required',
        ],[
            'professor_care.required' => 'عناية الاستاذ  مطلوب',
            'order_purchase_date.required' => 'تاريخ طلب الشراء مطلوب',
            'price.required' => 'السعر مطلوب',
            'total.required' => 'المجموع مطلوب',
            'discount.required' => 'الخصم مطلوب',
            'total_discount.required' => 'الاجمالي بعد الخصم مطلوب',
            'added_vat.required' => 'الضريبة المضافة مطلوب',
            'total_vat.required' => 'الاجمالي بعد الضريبة مطلوب',
        ]);
            $purchaseOrder_id = PurchaseOrder::insertGetId([
                'company_name' => $request->company_name,
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
            $payment_price = $request->payment_price;
            $payment_date = $request->payment_date;
            foreach ($payment_price as $index => $payment) {
                $s_payment = $payment;
                $s_date = $payment_date[$index];
                MultiPayment::insert([
                    'payment_id' =>$purchaseOrder_id ,
                    'payment_price' => $s_payment,
                    'payment_date' => $s_date
                ]);
            }

        $purchase_name = $request->purchase_name;
        $quantity = $request->quantity;
        $unit = $request->unit;
        $model_number = $request->model_number;
        $price = $request->price;
        $total_price = $request->total_price;
        foreach ($purchase_name as $index => $purchases) {
            $s_name = $purchases;
            $s_quantity = $quantity[$index];
            $s_unit = $unit[$index];
            $s_model_number = $model_number[$index];
            $s_price = $price[$index];
            $s_total = $total_price[$index];
            MultiPurchaseOrder::insert([
                'purchaseOrder_id' => $purchaseOrder_id,
                'purchase_name' => $s_name,
                'quantity' => $s_quantity,
                'unit' => $s_unit,
                'model_number' => $s_model_number,
                'price' => $s_price,
                'total_price' => $s_total
            ]);
        }
        DB::table('purchases')
            ->where('id', $purchase_id)
            ->update(['status_id' => 3]);

        $request->session()->flash('status', 'تم ارسال طلب شراء بنجاح');
        return redirect('/purchase/order');
    }

    public function PurchaseOrderEdit($id) {

        $companies = Company::all();
        $subcompanies = SubCompany::all();
        $subsubcompanies = SubSubCompany::all();
        $multi_purchase = multiPurchase::where('purchase_id', $id)->get();
        $purchases = Purchase::findOrFail($id);
        return view('purchases.purchase_order_edit', compact('purchases','companies',
            'subcompanies', 'subsubcompanies', 'multi_purchase'));
    }

    public function PurchaseOrderUpdate(Request $request, $id) {

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

        $request->session()->flash('status', 'تم حفظ طلب مواد بنجاح');
        return redirect('/purchase/order');
    }

    public function PrintOrderPurchase($id) {
        $purchase = Purchase::all();
        $purchases = PurchaseOrder::findOrFail($id);
        $multi_purchas = MultiPurchaseOrder::where('purchaseOrder_id', $id)->get();
        return view('print.purchase.print_purchase', compact('purchases','purchase', 'multi_purchas'));

    }

    public function PrintManagerOrder($id) {
        $purchase = Purchase::all();
        $purchases = PurchaseOrder::findOrFail($id);
        $multi_purchas = MultiPurchaseOrder::where('purchaseOrder_id', $id)->get();
        return view('print.purchase.manager_purchase', compact('purchases','purchase', 'multi_purchas'));

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $purchase = Purchase::all();
        $purchases = PurchaseOrder::findOrFail($id);

        return view('purchases.order_edit', compact('purchases', 'purchase'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'order_purchase_number' => 'required',
            'order_material_number' => 'required',
            'order_purchase_date' => 'required',
            'project_name' => 'required',
            'project_number' => 'required',
            'total' => 'required',
            'discount' => 'required',
            'total_discount' => 'required',
            'added_vat' => 'required',
            'total_vat' => 'required',
        ],[
            'professor_care.required' => 'عناية الاستاذ  مطلوب',
            'order_purchase_number.required' => 'رقم طلب الشراء مطلوب',
            'order_material_number.required' => 'رقم طلب المواد مطلوب',
            'order_purchase_date.required' => 'تاريخ طلب الشراء مطلوب',
            'project_name.required' => 'اسم المشروع مطلوب',
            'project_number.required' => 'رقم المشروع مطلوب',
            'total.required' => 'المجموع مطلوب',
            'discount.required' => 'الخصم مطلوب',
            'total_discount.required' => 'الاجمالي بعد الخصم مطلوب',
            'added_vat.required' => 'الضريبة المضافة مطلوب',
            'total_vat.required' => 'الاجمالي بعد الضريبة مطلوب',
        ]);

        PurchaseOrder::findOrFail($id)->update([
            'gentlemen' => $request->gentlemen,
            'professor_care' => $request->professor_care,
            'order_purchase_number' => $request->order_purchase_number,
            'order_material_number' => $request->order_material_number,
            'order_purchase_date' => $request->order_purchase_date,
            'address' => $request->address,
            'project_name' => $request->project_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'project_number' => $request->project_number,
            'subject' => $request->subject,
            'financial_provision' => $request->financial_provision,
            'number' => $request->number,
            'sequencing' => $request->sequencing,
            'purchase_name' => $request->purchase_name,
            'unit' => $request->unit,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'total' => $request->total,
            'discount' => $request->discount,
            'total_discount' => $request->total_discount,
            'added_vat' => $request->added_vat,
            'total_vat' => $request->total_vat,
            'delivery_location' => $request->delivery_location,
            'delivery_date' => $request->delivery_date,
            'created_at' => Carbon::now(),
        ]);

        $request->session()->flash('status', 'تم تعديل طلب شراء بنجاح');
        return redirect('/purchase/order');

    }

    public function OrderDelete($id) {

        PurchaseOrder::findOrFail($id)->delete();
        Session()->flash('status', 'تم حذف طلب شراء بنجاح');
        return redirect('/purchase/order');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
