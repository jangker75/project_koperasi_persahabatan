<?php

use App\Http\Controllers\Master\API\MasterDataStatusController;
use App\Http\Controllers\Share\JqueryEditableController;
use App\Http\Controllers\Toko\API\BrandController;
use App\Http\Controllers\Toko\API\CategoryController;
use App\Http\Controllers\Toko\API\OpnameController;
use App\Http\Controllers\Toko\API\OrderController;
use App\Http\Controllers\Toko\API\OrderSupplierController;
use App\Http\Controllers\Toko\API\PaymentMethodController;
use App\Http\Controllers\Toko\API\ProductController;
use App\Http\Controllers\Toko\API\PromoController;
use App\Http\Controllers\Toko\API\ReturnSupplierController;
use App\Http\Controllers\Toko\API\StoreController;
use App\Http\Controllers\Toko\API\SupplierController;
use App\Http\Controllers\Toko\API\TransferStockController;
use App\Http\Controllers\Umum\API\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('master-data-status', MasterDataStatusController::class);
Route::resource('category', CategoryController::class);
Route::resource('store', StoreController::class);
Route::resource('brand', BrandController::class);
Route::resource('supplier', SupplierController::class);
Route::resource('order', OrderController::class);
Route::resource('transfer-stock', TransferStockController::class);
Route::resource('order-supplier', OrderSupplierController::class);
Route::resource('payment-method', PaymentMethodController::class);
Route::resource('promo', PromoController::class);
Route::resource('opname', OpnameController::class);
Route::resource('return-supplier', ReturnSupplierController::class);

Route::post("order-nasabah", [OrderController::class, "orderNasabah"]);
Route::post('reject-order', [OrderController::class, 'rejectOrder']);
Route::post('checkout-order', [OrderController::class, 'checkoutOrder']);
Route::post('get-data-order', [OrderController::class, 'getDataOrder']);
// Render Jquery DataTable Editable
Route::post('jquery-data-editable', [JqueryEditableController::class, 'renderTable']);
Route::post('payment-data-editable', [JqueryEditableController::class, 'paymentTable']);
Route::post('search-employee', [EmployeeController::class, 'findEmployee']);
// product
Route::get('paginate-product-in-stock-from-store', [ProductController::class, "getProductOnStockPaginate"]);
Route::post('search-product', [ProductController::class, "searchProduct"])->name('search-product');
Route::get('product-by-sku', [ProductController::class, "searchProductBySKU"]);

// transfer stock
Route::get('transfer-stock-items/{id}', [TransferStockController::class, 'getDetailById']);
Route::post('transfer-stock-confirm', [TransferStockController::class, 'confirmStock']);
Route::post('transfer-stock-receive', [TransferStockController::class, 'receiveStock']);

// Order Supplier
Route::get('order-supplier-items/{id}', [OrderSupplierController::class, 'getDetailById']);
// Route::post('order-supplier-confirm', [OrderSupplierController::class, 'confirmStock']);
Route::post('order-supplier-receive', [OrderSupplierController::class, 'receiveOrder']);
Route::get('order-supplier-paid/{id}', [OrderSupplierController::class, 'changeToPaid']);


// opname
Route::get('opname-commit/{id}', [OpnameController::class, 'commit'])->name('opname.commit');
Route::get('change-status-promo/{id}', [PromoController::class, 'changeStatus'])->name('promo.change-status');