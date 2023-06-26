<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Backend\InvoicesController;
use App\Http\Controllers\Backend\PurchasesController;
use App\Http\Controllers\Backend\PurchaseOrderController;
use App\Http\Controllers\Backend\PaymentController;
use App\Http\Controllers\Backend\PaymentOrderController;
use App\Http\Controllers\Backend\CatchReceiptController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Company\SubCompanyController;
use App\Http\Controllers\Company\SubSubCompanyController;
use App\Http\Controllers\Company\AccountantController;
use App\Http\Controllers\Company\ManagerController;
use App\Http\Controllers\Company\ManagerPurchaseController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\Backend\CommandCatchController;
use App\Http\Controllers\Backend\ReceiptCatchController;
use App\Http\Controllers\Backend\AccountCatchController;
use App\Http\Controllers\Backend\FinanceCatchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

// All Dashboard View Route
Route::get('/dashboard', [DashboardController::class, 'Dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard/view/{id}', [DashboardController::class, 'DashboardView'])->name('dashboard.view');

// End All Dashboard View Route
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::resource('invoices', InvoicesController::class);

// All Material Order route
Route::resource('purchases', PurchasesController::class);
Route::get('/purchase/getPurchaseByCompany/{id}', [PurchasesController::class, 'getPurchaseByCompany']);
Route::get('/add/order', [PurchasesController::class, 'AddOrder'])->name('add.order');
Route::get('/purchases/delete/{id}', [PurchasesController::class, 'PurchaseDelete'])->name('purchase.delete');
Route::get('/print/purchase/{id}', [PurchasesController::class, 'PrintPurchase'])->name('print.purchase');
Route::get('/print/manager/purchase/{id}', [PurchasesController::class, 'PrintManagerPurchase'])->name('print.manager.purchase');

// End All Material Order route


// All Purchase Order Route
Route::resource('purchase/order', PurchaseOrderController::class);
Route::get('/purchase/order/getPurchaseOrderByCompany/{id}', [PurchaseOrderController::class, 'getPurchaseOrderByCompany']);
Route::get('/add/purchase/{id}', [PurchaseOrderController::class, 'AddPurchase'])->name('add.purchase');
Route::get('/purchase/order/edit/{id}', [PurchaseOrderController::class, 'PurchaseOrderEdit'])->name('purchases.order.edit');
Route::post('/purchase/order/update/{id}', [PurchaseOrderController::class, 'PurchaseOrderUpdate'])->name('purchases.order.update');
Route::get('/order/delete/{id}', [PurchaseOrderController::class, 'OrderDelete'])->name('order.delete');
Route::get('/print/order/purchase/{id}', [PurchaseOrderController::class, 'PrintOrderPurchase'])
    ->name('print.orderpurchase');
Route::get('/print/manager/order/{id}', [PurchaseOrderController::class, 'PrintManagerOrder'])
    ->name('print.manager.orderpurchase');
// End All Purchases Order route


// All Payment Route
Route::resource('payment', PaymentController::class)->middleware(['auth', 'verified']);
Route::get('/payment/getPaymentByCompany/{id}', [PaymentController::class, 'getPaymentByCompany']);
Route::get('/add/payment/{id}', [PaymentController::class, 'AddPayment'])->name('add.payment');
Route::get('/payment/purchase/edit/{id}', [PaymentController::class, 'PaymentPurchaseEdit'])
    ->name('payment.purchase.edit');
Route::post('/payment/purchase/update/{id}', [PaymentController::class, 'PaymentPurchaseUpdate'])
    ->name('payment.purchase.update');
Route::get('/print/payment/{id}', [PaymentController::class, 'PrintPayment'])->name('print.payment');
Route::get('/print/manager/payment/{id}', [PaymentController::class, 'PrintManagerPayment'])->name('print.manager.payment');

Route::get('/add/partial/payment/{id}', [PaymentController::class, 'AddPartialPayment'])->name('add.partial.payment');
Route::post('/partial/payment/store', [PaymentController::class, 'PartialPaymentStore'])
    ->name('partial.payment.store');

Route::get('/batch/payment/{id}', [PaymentController::class, 'BatchPayment'])
    ->name('batch.payment');
// End All Payment Order Route


// All Payment Order Route
Route::resource('command/pay', PaymentOrderController::class);
Route::get('/payment/order/getPaymentOrderByCompany/{id}', [PaymentOrderController::class, 'getPaymentOrderByCompany']);
Route::get('/add/command', [PaymentOrderController::class, 'PaymentOrder'])->name('add.command');
Route::post('/command/store', [PaymentOrderController::class, 'CommandStore'])->name('command.store');
Route::get('/print/command/{id}', [PaymentOrderController::class, 'PrintCommand'])->name('print.command');
// End All Payment Order Route

// All Receipt Order Route
Route::get('receipt/order/{id}', [CatchReceiptController::class, 'ReceiptOrder']);
Route::get('/add/receipt/{id}', [CatchReceiptController::class, 'ReceiptAdd'])->name('add.receipt');
Route::post('/receipt/store', [CatchReceiptController::class, 'ReceiptStore'])->name('receipt.store');


Route::get('receipt/command/{id}', [CatchReceiptController::class, 'ReceiptCommand']);
Route::get('/add/receipt/command/{id}', [CatchReceiptController::class, 'AddReceiptCommand'])->name('add.receipt.command');
Route::post('/receipt/command/store', [CatchReceiptController::class, 'ReceiptCommandStore'])->name('receipt.command.store');
Route::get('/print/receipt/command/{id}', [CatchReceiptController::class, 'PrintReceiptCommand'])->name('print.receipt.command');
// End All Receipt Order Route

// All Catch Receipt Route
Route::get('catch/receipt/{id}', [CatchReceiptController::class, 'CatchReceipt']);
Route::get('/print/receipt/{id}', [CatchReceiptController::class, 'PrintReceipt'])->name('print.receipt');
Route::get('/account/receipt/{id}', [CatchReceiptController::class, 'AccountReceipt']);
Route::get('/account/receipt/edit/{id}', [CatchReceiptController::class, 'AccountReceiptEdit'])
    ->name('account.receipt.edit');
Route::post('/account/receipt/update/{id}', [CatchReceiptController::class, 'AccountReceiptUpdate'])
    ->name('account.receipt.update');
Route::get('/sure/account/receipt/{id}', [CatchReceiptController::class, 'SureAccountSure'])->name('sure.account.receipt');

// End Catch Receipt Route

// All Accountant route
Route::get('accountant/{id}', [AccountantController::class, 'AccountantView']);
Route::get('/payment/edit/{id}', [AccountantController::class, 'PaymentEdit'])->name('payment.edit');
Route::post('/account/update/{id}', [AccountantController::class, 'AccountUpdate'])->name('account.update');
Route::get('/account/sure/{id}', [AccountantController::class, 'AccountSure'])->name('account.sure');
Route::get('/account/eye/{id}', [AccountantController::class, 'AccountEye'])->name('account.eye');
Route::post('/account/eye/update/{id}', [AccountantController::class, 'AccountEyeUpdate'])->name('accounteye.update');
// end Accountant Route

// All Account Catch
Route::get('account/catch/{id}', [AccountCatchController::class, 'AccountCatchView']);
Route::get('add/account/catch',  [AccountCatchController::class, 'AddAccountCatch'])->name('add.account.catch');
Route::post('/account/catch/store', [AccountCatchController::class, 'AccountCatchStore'])
    ->name('account.catch.store');
Route::post('/accountant/catch/update/{id}', [AccountCatchController::class, 'AccountantCatchUpdate'])
    ->name('accountant.catch.update');

Route::get('/accountant/catch/edit/{id}', [AccountCatchController::class, 'AccountantCatchEdit'])->name('accountant.catch.edit');
Route::get('add/safe/catch',  [AccountCatchController::class, 'AddSafeCatch'])->name('add.safe.catch');
Route::post('/safe/catch/store', [AccountCatchController::class, 'SafeCatchStore'])->name('safe.catch.store');

// end Account Catch

// All Finance Route
Route::get('finance/{id}', [AccountantController::class, 'FinanceView']);
Route::get('/finance/sure/{id}', [AccountantController::class, 'FinanceSure'])->name('finance.sure');
Route::get('/finance/edit/{id}', [AccountantController::class, 'FinanceEdit'])->name('finance.edit');
Route::post('/finance/update/{id}', [AccountantController::class, 'FinanceUpdate'])->name('finance.update');
Route::get('/finance/eye/{id}', [AccountantController::class, 'FinanceEye'])->name('finance.eye');
Route::post('/finance/eye/update', [AccountantController::class, 'FinanceEyeUpdate'])->name('financeye.update');


Route::get('/finance/receipt/{id}', [CatchReceiptController::class, 'FinanceReceipt']);
Route::get('/finance/receipt/edit/{id}', [CatchReceiptController::class, 'FinanceReceiptEdit'])
    ->name('finance.receipt.edit');
Route::post('/finance/receipt/update/{id}', [CatchReceiptController::class, 'FinanceReceiptUpdate'])
    ->name('finance.receipt.update');
Route::get('/sure/finance/receipt/{id}', [CatchReceiptController::class, 'FinanceAccountSure'])->name('sure.finance.receipt');

Route::get('finance/command/{id}', [AccountantController::class, 'FinanceCommandView']);

Route::get('/command/sure/{id}', [AccountantController::class, 'FinanceCommandSure'])->name('command.sure');
Route::get('/command/edit/{id}', [AccountantController::class, 'FinanceCommandEdit'])->name('command.edit');
Route::post('/command/update/{id}', [AccountantController::class, 'FinanceCommandUpdate'])->name('command.update');

// End All Finance Route

// All manager Route
Route::get('/manager/receipt/{id}', [ManagerController::class, 'ManagerReceipt']);
Route::get('/manager/receipt/edit/{id}', [ManagerController::class, 'ManagerReceiptEdit'])
    ->name('manager.receipt.edit');
Route::post('/manager/receipt/update/{id}', [ManagerController::class, 'ManagerReceiptUpdate'])
    ->name('manager.receipt.update');
Route::get('/sure/manager/receipt/{id}', [ManagerController::class, 'ManagerReceiptSure'])->name('sure.manager.receipt');

Route::get('manager/command/{id}', [ManagerController::class, 'ManagerCommandView']);
Route::get('manager/command/edit/{id}', [ManagerController::class, 'ManagerCommandEdit'])->name('manager.command.edit');
Route::post('/manager/command/update/{id}', [ManagerController::class, 'ManagerCommandUpdate'])->name('manager.command.update');
Route::get('/manager/command/sure/{id}', [ManagerController::class, 'ManagerCommandSure'])->name('manager.command.sure');
Route::get('/manager/eye/{id}', [ManagerController::class, 'ManagerEye'])->name('manager.eye');
Route::post('/eye/update', [ManagerController::class, 'EyeUpdate'])->name('eye.update');
// End manager Route

// All Manager Material Route
Route::get('manager/material/{id}', [ManagerController::class, 'ManagerMaterialView']);
Route::get('/material/edit/{id}', [ManagerController::class, 'MaterialEdit'])->name('material.edit');
Route::post('/material/update/{id}', [ManagerController::class, 'MaterialUpdate'])->name('material.update');
Route::get('/material/sure/{id}', [ManagerController::class, 'MaterialSure'])->name('material.sure');
Route::get('/material/reject/{id}', [ManagerController::class, 'MaterialReject'])->name('material.reject');
// End manager Material Route

// All Manager Purchase Route
Route::get('manager/purchase/{id}', [ManagerPurchaseController::class, 'ManagerPurchaseView']);
Route::get('/manger/purchase/edit/{id}', [ManagerPurchaseController::class, 'ManagerPurchaseEdit'])->name('manager.purchase.edit');
Route::post('/manger/purchase/update/{id}', [ManagerPurchaseController::class, 'ManagerPurchaseUpdate'])->name('manager.purchase.update');
Route::get('/purchase/sure/{id}', [ManagerPurchaseController::class, 'PurchaseSure'])->name('purchase.sure');
Route::get('/purchase/reject/{id}', [ManagerPurchaseController::class, 'PurchaseReject'])->name('purchase.reject');
// End All Manager Purchase Route

// All Manager Payment Route
Route::get('manager/payment/{id}', [ManagerPurchaseController::class, 'ManagerPaymentView']);
Route::get('/manger/payment/edit/{id}', [ManagerPurchaseController::class, 'ManagerPaymentEdit'])
    ->name('manager.payment.edit');
Route::post('/manger/payment/update/{id}', [ManagerPurchaseController::class, 'ManagerPaymentUpdate'])
    ->name('manager.payment.update');
Route::get('/manager/payment/reject/{id}', [ManagerPurchaseController::class, 'ManagerPaymentReject'])->name('manager.payment.reject');
Route::get('/manager/payment/sure/{id}', [ManagerPurchaseController::class, 'ManagerPaymentSure'])->name('manager.payment.sure');

// End All Manager Payment Route

// All Account Catch Route
Route::get('command/catch/{id}', [CommandCatchController::class, 'CommandCatchView']);

Route::get('/add/command/catch',[CommandCatchController::class, 'AddCommandCatch'])->name('add.command.catch');
Route::post('/catch/store', [CommandCatchController::class, 'CatchStore'])->name('catch.store');
Route::get('/print/catch/{id}', [CommandCatchController::class, 'PrintCatch'])
    ->name('print.catch');
Route::get('/command/catch/edit/{id}', [CommandCatchController::class, 'CommandCatchEdit'])
    ->name('command.catch.edit');
Route::post('/catch/update/{id}', [CommandCatchController::class, 'CatchUpdate'])
    ->name('catch.update');

Route::get('safe/command/catch/{id}', [CommandCatchController::class, 'SafeCommandCatchView']);
// end account catch route

// All Finance Catch Route
Route::get('finance/catch/{id}', [FinanceCatchController::class, 'FinanceCatchView']);

Route::get('/financial/catch/edit/{id}', [FinanceCatchController::class, 'FinancialCatchEdit'])
    ->name('financial.catch.edit');
Route::post('/financial/catch/update/{id}', [FinanceCatchController::class, 'FinancialCatchUpdate'])
    ->name('financial.catch.store');
Route::get('/financial/catch/sure/{id}', [FinanceCatchController::class, 'FinancialCatchSure'])->name('financial.catch.sure');
Route::get('/print/financial/{id}', [FinanceCatchController::class, 'PrintFinancial'])
    ->name('print.financial');

Route::get('finance/command/catch/{id}', [CommandCatchController::class, 'FinanceCommandCatchView']);

Route::get('/finance/command/sure/{id}', [CommandCatchController::class, 'FinanceCommandSure'])
    ->name('finance.command.sure');
Route::get('/finance/catch/edit/{id}', [CommandCatchController::class, 'FinanceCatchEdit'])
    ->name('finance.catch.edit');
Route::post('/finance/catch/update/{id}', [CommandCatchController::class, 'FinanceCatchUpdate'])
    ->name('finance.catch.update');
// end finance catch route

// All Manager catch route
Route::get('manager/catch/{id}', [FinanceCatchController::class, 'ManagerCatchView']);
Route::get('/managerial/catch/edit/{id}', [FinanceCatchController::class, 'managerialCatchEdit'])
    ->name('managerial.catch.edit');
Route::post('/managerial/catch/update/{id}', [FinanceCatchController::class, 'managerialCatchUpdate'])
    ->name('managerial.catch.update');
Route::get('/managerial/catch/sure/{id}', [FinanceCatchController::class, 'managerialCatchSure'])
    ->name('managerial.catch.sure');

Route::get('manager/command/catch/{id}', [CommandCatchController::class, 'ManagerCommandCatchView']);
Route::get('/manager/catch/sure/{id}', [CommandCatchController::class, 'ManagerCatchSure'])
    ->name('manager.catch.sure');
Route::get('/manager/catch/edit/{id}', [CommandCatchController::class, 'ManagerCatchEdit'])
    ->name('manager.catch.edit');
Route::post('/manager/catch/update/{id}', [CommandCatchController::class, 'ManagerCatchUpdate'])
    ->name('manager.catch.update');
// end manager catch route

// All Receipt Catch Route
Route::get('/add/receipt/catch/{id}', [ReceiptCatchController::class, 'AddReceiptCatch'])->name('add.receipt.catch');
Route::post('/receipt/catch/store', [ReceiptCatchController::class, 'ReceiptCatchStore'])->name('receipt.catch.store');
Route::get('/print/receipt/catch/{id}', [ReceiptCatchController::class, 'PrintReceiptCatch'])
    ->name('print.receipt.catch');

// End Receipt Catch Route

// All Company Route
Route::get('company', [CompanyController::class, 'CompanyView']);
Route::post('/company/add',[CompanyController::class, 'CompanyStore'])->name('company.add');
Route::get('/company/edit/{id}',[CompanyController::class, 'CompanyEdit'])->name('company.edit');
Route::post('/company/update/{id}',[CompanyController::class, 'CompanyUpdate'])->name('company.update');
Route::get('/company/delete/{id}',[CompanyController::class, 'CompanyDelete'])->name('company.delete');

Route::get('bank', [CompanyController::class, 'BankView']);
Route::post('/bank/add',[CompanyController::class, 'BankStore'])->name('bank.add');
Route::get('/bank/edit/{id}',[CompanyController::class, 'BankEdit'])->name('bank.edit');
Route::post('/bank/update/{id}',[CompanyController::class, 'BankUpdate'])->name('bank.update');
Route::get('/bank/delete/{id}',[CompanyController::class, 'BankDelete'])->name('bank.delete');
// End Company Route

// All Sub Company Route
Route::get('subCompany', [SubCompanyController::class, 'SubCompanyView']);
Route::post('/subcompany/add',[SubCompanyController::class, 'SubCompanyStore'])->name('subcompany.add');
Route::get('/subcompany/edit/{id}',[SubCompanyController::class, 'SubCompanyEdit'])->name('subcompany.edit');
Route::post('/subcompany/update/{id}',[SubCompanyController::class, 'SubCompanyUpdate'])->name('subcompany.update');
Route::get('/subcompany/delete/{id}',[SubCompanyController::class, 'SubCompanyDelete'])->name('subcompany.delete');
// End All Sub Company Route

// All Sub Sub Company Route
Route::get('subSubCompany', [SubSubCompanyController::class, 'SubSubCompanyView']);
Route::post('/subsubcompany/add',[SubSubCompanyController::class, 'SubSubCompanyStore'])->name('subsubcompany.add');
Route::get('/subsubcompany/edit/{id}',[SubSubCompanyController::class, 'SubSubCompanyEdit'])->name('subsubcompany.edit');
Route::post('/subsubcompany/update/{id}',[SubSubCompanyController::class, 'SubSubCompanyUpdate'])->name('subsubcompany.update');
Route::get('/subsubcompany/delete/{id}',[SubSubCompanyController::class, 'SubSubCompanyDelete'])->name('subsubcompany.delete');

Route::get('/company/subcompany/ajax/{company_id}',[SubSubCompanyController::class, 'GetSubCompany']);
Route::get('/company/sub-subcompany/ajax/{subcompany_id}',[SubSubCompanyController::class, 'GetSubSubCompany']);
// End All Sub Sub Company Route

Route::group(['middleware' => ['auth']], function() {

    Route::resource('roles',RoleController::class);

    Route::resource('users', UserController::class);

});

Route::get('/{page}', 'App\Http\Controllers\AdminController@index');
