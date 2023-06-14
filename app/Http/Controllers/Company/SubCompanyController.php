<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\SubCompany;
use  App\Models\Company;

class SubCompanyController extends Controller
{

    public function SubCompanyView() {

        $companies = Company::all();
        $subcompany = SubCompany::all();
        return view('company.subcompany_view', compact('subcompany', 'companies'));
    }

    public function SubCompanyStore(Request $request) {

        $request->validate([
            'company_id' => 'required',
            'subcompany_name' => 'required',
        ],[
            'company_id.required' => 'اسم الشركة مطلوب',
            'subcompany_name.required' => 'اسم الفرع مطلوب',
        ]);
        SubCompany::insert([
            'company_id' => $request->company_id,
            'subcompany_name' => $request->subcompany_name,
            'created_at' => Carbon::now(),
        ]);
        $request->session()->flash('status', 'تم ادخال اسم الفرع بنجاح');
        return redirect()->back();
    }

    public function SubCompanyEdit($id) {

        $companies = Company::all();
        $subcompany = SubCompany::findOrFail($id);
        return view('company.subcompany_edit', compact('subcompany','companies'));
    }

    public function SubCompanyUpdate(Request $request, $id) {

        $request->validate([
            'company_id' => 'required',
            'subcompany_name' => 'required',
        ],[
            'company_id.required' => 'اسم الشركة مطلوب',
            'subcompany_name.required' => 'اسم الفرع مطلوب',
        ]);

        SubCompany::findOrFail($id)->update([
            'company_id' => $request->company_id,
            'subcompany_name' => $request->subcompany_name,
            'created_at' => Carbon::now(),
        ]);

        $request->session()->flash('status', 'تم تعديل اسم الفرع بنجاح');
        return redirect('/subCompany');
    }

    public function SubCompanyDelete($id) {

        SubCompany::findOrFail($id)->delete();
        Session()->flash('status', 'تم حذف الفرع بنجاح');
        return redirect('/subCompany');
    }


}
