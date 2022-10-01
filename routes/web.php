<?php

use App\Http\Controllers\Admin\Toko\PaylaterController;
use App\Http\Controllers\ApplicationSettingController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Master\MasterDataStatusController;
use App\Http\Controllers\Toko\BrandController;
use App\Http\Controllers\Toko\CategoryController;
use App\Http\Controllers\CompanyBalanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Nasabah\LoanNasabahController;
use App\Http\Controllers\Nasabah\LoanSubmissionNasabahController;
use App\Http\Controllers\RoleManagementController;
use App\Http\Controllers\Nasabah\PagesController;
use App\Http\Controllers\Nasabah\ProfileController;
use App\Http\Controllers\Toko\ManagementStockController;
use App\Http\Controllers\Toko\OpnameController;
use App\Http\Controllers\Toko\OrderController;
use App\Http\Controllers\Toko\OrderSupplierController;
use App\Http\Controllers\Toko\PaymentMethodController;
use App\Http\Controllers\Toko\PriceController;
use App\Http\Controllers\toko\PrintReceiptController;
use App\Http\Controllers\Toko\ProductController;
use App\Http\Controllers\Toko\StoreController;
use App\Http\Controllers\Toko\SupplierController;
use App\Http\Controllers\Umum\CashTransactionController;
use App\Http\Controllers\Umum\EmployeeController;
use App\Models\Product;
use App\Http\Controllers\Umum\ExEmployeeController;
use App\Http\Controllers\Usipa\LoanListController;
use App\Http\Controllers\Usipa\LoanSubmissionController;
use App\Services\DynamicImageService;
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
    Route::get('/', [PagesController::class, 'home'])->name('home');
    Route::get('/product', [PagesController::class, 'product'])->name('product.index');
    Route::get('/product/{sku}', [PagesController::class, 'productDetail'])->name('product.show');
    Route::get('/checkout', [PagesController::class, 'checkout'])->name('product.checkout');
    //Logout custom

    Route::get('employee-savings-history/{employee_id}/{saving_type}', [EmployeeController::class, 'getEmployeeSavingsHistory'])->name('get.employee.savings.history');
    Route::get('loan-submission', [LoanSubmissionNasabahController::class, 'index'])->name('loan-submission.index');
    Route::post('loan-submission', [LoanSubmissionNasabahController::class, 'store'])->name('loan-submission.store');

    Route::get('loan-list-nasabah', [LoanNasabahController::class, 'index'])->name('loan.index');
    Route::get('loan-list-nasabah/{loan}', [LoanNasabahController::class, 'show'])->name('loan.show');

    Route::get('profile', [PagesController::class, "profile"])->name('profile');
    Route::get('riwayat-paylater', [PagesController::class, "paylaterHistory"])->name('history-paylater');
    Route::get('detail-paylater/{orderCode}', [PagesController::class, "detailOrder"])->name('detail-order');
});

Route::post('custom-logout', [LogoutController::class, 'logout'])->name('admin.logout');

Route::group([
    'middleware' => ['auth', 'admin'],
    'as' => 'admin.',
    'prefix' => 'admin'
], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    


    // POS
    
    Route::get('pos/checkout', [DashboardController::class, 'posCheckout']);
    Route::get('pos/request-order', [DashboardController::class, 'requestOrder'])->name('request-order.index');
    Route::get('pos/request-order/{orderCode}', [DashboardController::class, 'detailRequestOrder'])->name('request-order.detail');
    Route::get('pos/print-receipt/{orderCode}', [DashboardController::class, 'printReceipt'])->name('print-receipt');
    Route::get('pos/history-order', [OrderController::class, 'index'])->name('order.index');
    Route::get('pos/history-order/{orderCode}', [OrderController::class, 'show'])->name('order.show');
    Route::get('pos/history-paylater', [PaylaterController::class, 'index'])->name('paylater.index');
    Route::get('pos/history-paylater/{staffId}', [PaylaterController::class, 'show'])->name('paylater.show');


    //toko-online
    Route::get('master-data-status', [MasterDataStatusController::class, 'index'])->name('master-status.index');
    Route::group([
      'prefix' => 'toko'
    ], function(){
      Route::resource('product', ProductController::class);
    Route::resource('price', PriceController::class);
      Route::resource('category', CategoryController::class);
      Route::resource('store', StoreController::class);
      Route::resource('brand', BrandController::class);
      Route::resource('supplier', SupplierController::class);
      Route::resource('management-price', PriceController::class);
      Route::get('prices-from-product/{productId}', [PriceController::class, 'pricesProduct'])->name('prices.from.product');
      Route::resource('management-stock', ManagementStockController::class);
      Route::resource('order-supplier', OrderSupplierController::class);
      Route::resource('payment-method', PaymentMethodController::class);
      Route::resource('opname', OpnameController::class);
      Route::get('print-form-opname/{storeId}', [OpnameController::class, 'printFormOpname']);

      // transfer-stock
      Route::get('confirm-ticket-transfer-stock/{id}', [ManagementStockController::class, 'confirmTicket']);
      Route::get('start-order-transfer-stock/{id}', [ManagementStockController::class, 'startTicket']);
      Route::get('reject-order-transfer-stock/{id}', [ManagementStockController::class, 'rejectTicket']);
      // transfer-stock

      // order-supplier
      Route::get('confirm-order-supplier/{id}', [OrderSupplierController::class, 'confirmTicket']);
      Route::get('start-order-supplier/{id}', [OrderSupplierController::class, 'startTicket']);
      Route::get('reject-order-supplier/{id}', [OrderSupplierController::class, 'rejectTicket']);
      // order-supplier
    });

    //toko-online

    // Divisi Umum
    Route::resource('employee', EmployeeController::class);
    Route::get('employee-out', [EmployeeController::class, 'employeeOut'])->name('employee.out');
    Route::post('employee-store', [EmployeeController::class, 'employeeOutStore'])->name('employee.out.store');
    Route::post('check-status-loan-employee', [EmployeeController::class, 'checkStatusLoanEmployee'])->name('check.status.loan.employee');
    Route::resource('ex-employee', ExEmployeeController::class);
    Route::get('employee-download-card/{employee}', [EmployeeController::class, 'downloadEmployeeCard'])->name('employee.download.card');
    Route::resource('cash-in-out', CashTransactionController::class);
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
    
    Route::resource('company-balance', CompanyBalanceController::class);
    Route::get('company-balance-history/{balance_type}', [CompanyBalanceController::class, 'getCompanyBalanceHistory'])->name('get.company.balance.history');
    // Usipa

    // Download PDF
    Route::get('download-kontrak-peminjaman/{loan_id}', [LoanListController::class, 'downloadKontrakPeminjamanPDF'])->name('download.kontrak.peminjaman');
    Route::get('download-loan-report', [LoanListController::class, 'downloadLoanReport'])->name('download.loan.report');
    Route::get('print-receipt-order/{orderId}', [PrintReceiptController::class, 'printOrderReceipt'])->name('order.receipt');

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
    Route::get('datatables-product', [ProductController::class, 'getIndexDatatables'])->name('product.index.datatables');
    Route::get('datatables-employee-index', [EmployeeController::class, 'getIndexDatatables'])->name('employee.index.datatables');
    Route::get('datatables-ex-employee-index', [ExEmployeeController::class, 'getIndexDatatables'])->name('ex-employee.index.datatables');
    Route::get('datatables-loan-submission-index', [LoanSubmissionController::class, 'getIndexDatatables'])->name('loan-submission.index.datatables');
    Route::get('datatables-loan-list-index', [LoanListController::class, 'getIndexDatatables'])->name('loan-list.index.datatables');
    Route::get('datatables-cash-in-out-index', [CashTransactionController::class, 'getIndexDatatables'])->name('cash-in-out.index.datatables');

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