<?php

namespace App\Http\Controllers;

use App\Models\CommandCatch;
use App\Models\PartialPayment;
use App\Models\PaymentOrder;
use App\Models\Purchase;
use App\Models\PurchaseOrder;
use App\Models\ReceiptCatch;
use App\Models\ReceiptCommand;
use App\Models\ReceiptOrder;
use Illuminate\Http\Request;
use App\Models\Company;

class DashboardController extends Controller
{
    public function Dashboard() {

        $company = Company::all();
        return view('dashboard' , compact('company'));
    }

    public function DashboardView($id) {

        $material = Purchase::where('company_id', $id)->count();
        $purchase = PurchaseOrder::where('company_id', $id)->sum('total_vat');
        $payment = PartialPayment::where('company_id', $id)->sum('batch_payment');
        $catch = ReceiptCatch::where('company_id', $id)->sum('price');
        $paymentCommand = PaymentOrder::where('company_id', $id)->sum('price');
        $catchCommand = CommandCatch::where('company_id', $id)->sum('price');
        $receipt = ReceiptOrder::where('company_id', $id)->sum('price');
        $receiptCommand = ReceiptCommand::where('company_id', $id)->sum('price');
        $company = Company::find($id);
        return view('index', compact('company', 'material', 'purchase', 'payment'
        , 'catch', 'paymentCommand', 'catchCommand', 'receipt', 'receiptCommand'));

    }


}
