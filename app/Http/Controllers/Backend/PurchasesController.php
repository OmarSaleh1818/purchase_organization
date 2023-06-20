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
        $purchases = Purchase::orderBy('id', 'DESC')->get();
        return view('purchases.purchase', compact('purchases'));
    }

    public function getPurchaseByCompany($id) {
        $purchases = Purchase::where('company_id', $id)->orderBy('id', 'DESC')->get();
        $html ='';
        if($purchases) {
            $html .= '';
            foreach($purchases as $key => $purchase){
                $html .= '
                         <tr>
                            <td>'.($key + 1).'</td>
                            <td>'.$purchase['subcompany']['subcompany_name'].'</td>
                            <td>'.$purchase['subsubcompany']['subsubcompany_name'].'</td>
                            <td>'.$purchase->financial_provision.'</td>
                            <td>'.$purchase->teacher_name.'</td>
                            <td>'.$purchase->date.'</td>
                            <td>'.$purchase->number.'</td>
                            <td>'.$purchase->applicant.'</td>
                            <td>';
                if ($purchase->status_id == 1) {
                    $html .= '<a href="'.route('print.purchase', $purchase->id).'" class="btn btn-secondary" title="طباعة"><i class="fa fa-print"></i></a>';
                } else {
                    $html .= '<a href="'.route('print.manager.purchase', $purchase->id).'" class="btn btn-warning" title="طباعة"><i class="fa fa-print"></i></a>';
                }
                $html .= ' </td>
                            <td>';
                if ($purchase->status_id == 4) {
                    // Do something if status_id is 4
                } elseif ($purchase->status_id == 3) {
                    // Do something if status_id is 3
                } elseif ($purchase->status_id == 7) {
                    // Do something if status_id is 7
                } else {
                    $html .= '<a href="'.route('purchases.edit', $purchase->id).'" class="btn btn-info" title="تعديل الطلب"><i class="las la-pen"></i></a>
                  <a href="'.route('purchase.delete', $purchase->id).'" class="btn btn-danger" title="حذف الطلب" id="delete"><i class="fa fa-trash"></i></a>';
                }
                $html .= '  </td>
                            <td>';
                if ($purchase->status_id == 1) {
                    $html .= '<button class="btn btn-primary" disabled>تم الارسال</button>';
                } elseif ($purchase->status_id == 2) {
                    $html .= '<button class="btn btn-warning" disabled>تم رفض الطلب</button>';
                } elseif ($purchase->status_id == 7) {
                    $html .= '<button class="btn btn-secondary" disabled>تم موافقة المدير</button>';
                } elseif ($purchase->status_id == 3) {
                    $html .= '<button class="btn btn-success" disabled>تم طلب الشراء</button>';
                } elseif ($purchase->status_id == 4) {
                    $html .= '<button class="btn btn-danger" disabled>تم طلب اصدار دفعة</button>';
                }
                $html .= '  </td>
                        </tr>
                ';
            }
            return $html;
        }
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
