<?php

use App\Http\Controllers\ApplicationSettingController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Master\MasterDataStatusController;
use App\Http\Controllers\Toko\BrandController;
use App\Http\Controllers\Toko\CategoryController;
use App\Http\Controllers\CompanyBalanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleManagementController;
use App\Http\Controllers\Toko\ProductController;
use App\Http\Controllers\Toko\StoreController;
use App\Http\Controllers\Toko\SupplierController;
use App\Http\Controllers\Umum\EmployeeController;
use App\Models\Product;
use App\Http\Controllers\Umum\ExEmployeeController;
use App\Http\Controllers\Usipa\LoanListController;
use App\Http\Controllers\Usipa\LoanSubmissionController;
use App\Models\CompanyBalance;
use App\Services\DynamicImageService;
use Illuminate\Support\Facades\Auth;
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

Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
});

Route::group([
    'middleware' => ['auth'],
    'as' => 'nasabah.',
], function () {
    // customer
    Route::get('/', function () {
        // return redirect('/admin');
        $data['product'] = Product::get();
        return view('nasabah.pages.home', $data);
    })->name('home');
    //Logout custom
});
Route::post('custom-logout', [LogoutController::class, 'logout'])->name('admin.logout');

Route::group([
    'middleware' => ['auth', 'admin'],
    'as' => 'admin.',
    'prefix' => 'admin'
], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    

    //toko-online
    Route::get('master-data-status', [MasterDataStatusController::class, 'index'])->name('master-status.index');
    Route::resource('toko/product', ProductController::class);
    Route::resource('toko/category', CategoryController::class);
    Route::resource('toko/store', StoreController::class);
    Route::resource('toko/brand', BrandController::class);
    Route::resource('toko/supplier', SupplierController::class);
    //toko-online

    // Divisi Umum
    Route::resource('employee', EmployeeController::class);
    Route::get('employee-out', [EmployeeController::class, 'employeeOut'])->name('employee.out');
    Route::post('employee-store', [EmployeeController::class, 'employeeOutStore'])->name('employee.out.store');
    Route::post('check-status-loan-employee', [EmployeeController::class, 'checkStatusLoanEmployee'])->name('check.status.loan.employee');
    Route::resource('ex-employee', ExEmployeeController::class);
    // Divisi Umum

    // Usipa
    Route::resource('loan-submission', LoanSubmissionController::class);
    Route::get('loan-submission-action-approve/{loan}/{status}', [LoanSubmissionController::class, 'actionSubmissionLoan'])->name('loan-submission.action.approval');
    Route::resource('loan-list', LoanListController::class);
    Route::get('loan-full-payment/{loan}', [LoanListController::class, 'fullPayment'])->name('loan.fullpayment');
    Route::post('loan-full-payment-store', [LoanListController::class, 'fullPaymentStore'])->name('loan.fullpayment.store');
    Route::post('loan-some-payment-store', [LoanListController::class, 'somePaymentStore'])->name('loan.somepayment.store');
    Route::post('loan-upload-attachment',[LoanListController::class, 'uploadAttachment'])->name('loan.upload.attachment');
    Route::post('loan-destroy-attachment',[LoanListController::class, 'destroyAttachment'])->name('loan.destroy.attachment');
    Route::get('employee-savings-history/{employee_id}/{saving_type}', [EmployeeController::class, 'getEmployeeSavingsHistory'])->name('get.employee.savings.history');
    Route::resource('company-balance', CompanyBalanceController::class);
    Route::get('company-balance-history/{balance_type}', [CompanyBalanceController::class, 'getCompanyBalanceHistory'])->name('get.company.balance.history');
    // Usipa

    // Download PDF
    Route::get('download-kontrak-peminjaman/{loan_id}', [LoanListController::class, 'downloadKontrakPeminjamanPDF'])->name('download.kontrak.peminjaman');
    Route::get('download-loan-report', [LoanListController::class, 'downloadLoanReport'])->name('download.loan.report');

    // Download Data
    Route::get('download-export-data-nasabah/{type}', [EmployeeController::class, 'exportData'])->name('download.data-nasabah');

    // App Setting
    Route::get('app-setting', [ApplicationSettingController::class, 'index'])->name('app-setting.index');
    Route::post('app-setting', [ApplicationSettingController::class, 'update'])->name('app-setting.update');
    Route::get('switcher', function () {
        return view('admin.pages.switcher.index');
    })->name('switcher');
    Route::resource('role-management', RoleManagementController::class);
    // End App Setting

    // Datatables Route
    Route::get('datatables-employee-index', [EmployeeController::class, 'getIndexDatatables'])->name('employee.index.datatables');
    Route::get('datatables-ex-employee-index', [ExEmployeeController::class, 'getIndexDatatables'])->name('ex-employee.index.datatables');
    Route::get('datatables-loan-submission-index', [LoanSubmissionController::class, 'getIndexDatatables'])->name('loan-submission.index.datatables');
    Route::get('datatables-loan-list-index', [LoanListController::class, 'getIndexDatatables'])->name('loan-list.index.datatables');

    //Logout custom
    // Route::post('custom-logout', [LogoutController::class, 'logout'])->name('logout');

});

//Images routes non spatie
Route::get('image/{filename?}', [DynamicImageService::class, 'showImage'])->where('filename', '.*')
        ->name('showimage')->middleware('auth'); //show image

//Redirect all wild domain
// Route::get('{any}', function () {
//     return redirect(route('admin.dashboard'));
// })->where('any', '.*');