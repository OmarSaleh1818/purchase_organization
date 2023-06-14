<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\multiPurchase;
use Illuminate\Support\Facades\Auth;
use App\Models\SubCompany;
use App\Models\Company;
use App\Models\SubSubCompany;

class PurchasesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::orderBy('status_id', 'ASC')->orderBy('id', 'DESC')->get();
        return view('purchases.purchase', compact('purchases'));
    }

    public function AddOrder() {

        $companies = Company::all();
        $subcompanies = SubCompany::all();
        $subsubcompanies = SubSubCompany::all();
        return view('purchases.add_order', compact('companies', 'subcompanies', 'subsubcompanies'));
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

        $purchase_id = Purchase::insertGetId([
            'company_id' => $request->company_id,
            'subcompany_id' => $request->subcompany_id,
            'subsubcompany_id' => $request->subsubcompany_id,
            'teacher_name' => $request->teacher_name,
            'number' => $request->number,
            'financial_provision' => $request->financial_provision,
            'date' => $request->date,
            'applicant' => (Auth::user()->name),
            'created_by' => (Auth::user()->name),
            'created_at' => Carbon::now(),
        ]);
        $purchase_name = $request->purchase_name;
        $quantity = $request->quantity;
        $unit = $request->unit;
        $model_number = $request->model_number;
        foreach ($purchase_name as $index => $purchases) {
            $s_name = $purchases;
            $s_quantity = $quantity[$index];
            $s_unit = $unit[$index];
            $s_model_number = $model_number[$index];
            multiPurchase::insert([
                'purchase_id' => $purchase_id,
                'purchase_name' => $s_name,
                'quantity' => $s_quantity,
                'unit' => $s_unit,
                'model_number' => $s_model_number
            ]);
        }

        $request->session()->flash('status', 'تم ارسال طلب مواد بنجاح');
        return redirect('/purchases');

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
        $companies = Company::all();
        $subcompanies = SubCompany::all();
        $subsubcompanies = SubSubCompany::all();
        $multi_purchase = multiPurchase::where('purchase_id', $id)->get();
        $purchases = Purchase::findOrFail($id);
        return view('purchases.purchase_edit', compact('purchases',
            'companies', 'subcompanies', 'subsubcompanies', 'multi_purchase'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
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
            'created_by' => (Auth::user()->name),
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
        return redirect('/purchases');

    }

    public function PurchaseDelete($id) {

        Purchase::findOrFail($id)->delete();
        Session()->flash('status', 'تم حذف طلب مواد بنجاح');
        return redirect('/purchases');

    }

    public function PrintPurchase($id) {

        $companies = Company::all();
        $subcompanies = SubCompany::all();
        $subsubcompanies = SubSubCompany::all();
        $multi_purchase = multiPurchase::where('purchase_id', $id)->get();
        $purchases = Purchase::findOrFail($id);
        return view('print.material.print_material', compact('companies', 'subcompanies'
        , 'subsubcompanies', 'multi_purchase', 'purchases'));
    }

    public function PrintManagerPurchase($id) {

        $companies = Company::all();
        $subcompanies = SubCompany::all();
        $subsubcompanies = SubSubCompany::all();
        $multi_purchase = multiPurchase::where('purchase_id', $id)->get();
        $purchases = Purchase::findOrFail($id);
        return view('print.material.manager_material', compact('companies', 'subcompanies'
            , 'subsubcompanies', 'multi_purchase', 'purchases'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
