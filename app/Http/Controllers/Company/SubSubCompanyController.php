<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\SubCompany;
use App\Models\Company;
use App\Models\SubSubCompany;

class SubSubCompanyController extends Controller
{

    public function SubSubCompanyView() {

        $companies = Company::all();
        $subcompanies = SubCompany::all();
        $subsubcompany = SubSubCompany::all();
        return view('company.subsubcompany_view', compact('companies', 'subcompanies', 'subsubcompany'));
    }

    public function GetSubCompany($company_id) {

        $subcomp = SubCompany::where('company_id', $company_id)->orderBy('subcompany_name', 'DESC')->get();
        return json_encode($subcomp);
    }

    public function GetSubSubCompany($subcompany_id) {

        $subsubcomp = SubSubCompany::where('subcompany_id', $subcompany_id)->orderBy('subsubcompany_name', 'DESC')->get();
        return json_encode($subsubcomp);
    }

    public function SubSubCompanyStore(Request $request) {

        $request->validate([
            'company_id' => 'required',
            'subcompany_id' => 'required',
            'subsubcompany_name' => 'required',
        ],[
            'company_id.required' => 'اسم الشركة مطلوب',
            'subcompany_id.required' => 'اسم الفرع مطلوب',
            'subsubcompany_name.required' => 'اسم الفرع مطلوب',
        ]);
        SubSubCompany::insert([
            'company_id' => $request->company_id,
            'subcompany_id' => $request->subcompany_id,
            'subsubcompany_name' => $request->subsubcompany_name,
            'created_at' => Carbon::now(),
        ]);
        $request->session()->flash('status', 'تم اضافة اسم المشروع بنجاح');
        return redirect()->back();
    }

    public function SubSubCompanyEdit($id) {

        $companies = Company::all();
        $subcompanies = SubCompany::all();
        $subsubcompany = SubSubCompany::findOrFail($id);
        return view('company.subsubcompany_edit', compact('subcompanies','companies', 'subsubcompany'));
    }

    public function SubSubCompanyUpdate(Request $request, $id) {

        $request->validate([
            'company_id' => 'required',
            'subcompany_id' => 'required',
            'subsubcompany_name' => 'required',
        ],[
            'company_id.required' => 'اسم الشركة مطلوب',
            'subcompany_id.required' => 'اسم الفرع مطلوب',
            'subsubcompany_name.required' => 'اسم الفرع مطلوب',
        ]);

        SubSubCompany::findOrFail($id)->update([
            'company_id' => $request->company_id,
            'subcompany_id' => $request->subcompany_id,
            'subsubcompany_name' => $request->subsubcompany_name,
            'created_at' => Carbon::now(),
        ]);

        $request->session()->flash('status', 'تم تعديل اسم المشروع بنجاح');
        return redirect('/subSubCompany');
    }

    public function SubSubCompanyDelete($id) {

        SubSubCompany::findOrFail($id)->delete();
        Session()->flash('status', 'تم حذف المشلروع بنجاح');
        return redirect('/subSubCompany');
    }


}
