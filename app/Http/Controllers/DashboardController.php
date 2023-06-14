<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class DashboardController extends Controller
{
    public function Dashboard() {

        $company = Company::all();
        return view('dashboard' , compact('company'));
    }

    public function DashboardView($id) {

        $company = Company::find($id);
        return view('index', compact('company'));

    }


}
