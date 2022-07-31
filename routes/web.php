<?php

use App\Http\Controllers\ApplicationSettingController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Master\MasterDataStatusController;
use App\Http\Controllers\Toko\BrandController;
use App\Http\Controllers\Toko\CategoryController;
use App\Http\Controllers\CompanyBalanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Toko\ProductController;
use App\Http\Controllers\Toko\StoreController;
use App\Http\Controllers\Toko\SupplierController;
use App\Http\Controllers\Umum\EmployeeController;
use App\Models\Product;
use App\Http\Controllers\Umum\ExEmployeeController;
use App\Http\Controllers\Usipa\LoanListController;
use App\Http\Controllers\Usipa\LoanSubmissionController;
use App\Models\CompanyBalance;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// customer
Route::get('/', function () {
  // return redirect('/admin');
  $data['product'] = Product::get();
  return view('nasabah.pages.home', $data);
});
// customer

// admin



Route::get('/admin', function () {
    return redirect(route('admin.dashboard'));
});
Route::group([
    'middleware' => ['web', 'auth'],
    'as' => 'admin.',
    'prefix' => 'admin'
], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('switcher', function () {
        return view('admin.pages.switcher.index');
    })->name('switcher');

    //toko-online
    Route::get('master-data-status', [MasterDataStatusController::class, 'index'])->name('master-status.index');
    Route::resource('product', ProductController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('store', StoreController::class);
    Route::resource('brand', BrandController::class);
    Route::resource('supplier', SupplierController::class);
    //toko-online

    
    Route::resource('employee', EmployeeController::class);
    Route::get('employee-out', [EmployeeController::class, 'employeeOut'])->name('employee.out');
    Route::post('employee-store', [EmployeeController::class, 'employeeOutStore'])->name('employee.out.store');
    Route::post('check-status-loan-employee', [EmployeeController::class, 'checkStatusLoanEmployee'])->name('check.status.loan.employee');
    Route::resource('ex-employee', ExEmployeeController::class);
    Route::resource('loan-submission', LoanSubmissionController::class);
    Route::get('loan-submission-action-approve/{loan}/{status}', [LoanSubmissionController::class, 'actionSubmissionLoan'])->name('loan-submission.action.approval');
    Route::resource('loan-list', LoanListController::class);
    Route::get('loan-full-payment/{loan}', [LoanListController::class, 'fullPayment'])->name('loan.fullpayment');
    Route::post('loan-full-payment-store', [LoanListController::class, 'fullPaymentStore'])->name('loan.fullpayment.store');
    Route::post('loan-some-payment-store', [LoanListController::class, 'somePaymentStore'])->name('loan.somepayment.store');
    Route::get('employee-savings-history/{employee_id}/{saving_type}', [EmployeeController::class, 'getEmployeeSavingsHistory'])->name('get.employee.savings.history');
    Route::resource('company-balance', CompanyBalanceController::class);
    Route::get('company-balance-history/{balance_type}', [CompanyBalanceController::class, 'getCompanyBalanceHistory'])->name('get.company.balance.history');

    // App Setting
    Route::get('app-setting', [ApplicationSettingController::class, 'index'])->name('app-setting.index');
    Route::post('app-setting', [ApplicationSettingController::class, 'update'])->name('app-setting.update');

    // Datatables Route
    Route::get('datatables-employee-index', [EmployeeController::class, 'getIndexDatatables'])->name('employee.index.datatables');
    Route::get('datatables-ex-employee-index', [ExEmployeeController::class, 'getIndexDatatables'])->name('ex-employee.index.datatables');
    Route::get('datatables-loan-submission-index', [LoanSubmissionController::class, 'getIndexDatatables'])->name('loan-submission.index.datatables');
    Route::get('datatables-loan-list-index', [LoanListController::class, 'getIndexDatatables'])->name('loan-list.index.datatables');
        

    //Logout custom
    Route::post('custom-logout', [LogoutController::class, 'logout'])->name('logout');
});


//Redirect all wild domain
Route::get('{any}', function () {
    return redirect(route('admin.dashboard'));
})->where('any', '.*');
