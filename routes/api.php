<?php

use App\Http\Controllers\Master\API\MasterDataStatusController;
use App\Http\Controllers\Share\JqueryEditableController;
use App\Http\Controllers\Toko\API\BrandController;
use App\Http\Controllers\Toko\API\CategoryController;
use App\Http\Controllers\Toko\API\StoreController;
use App\Http\Controllers\Toko\API\SupplierController;
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
// Render Jquery DataTable Editable
Route::post('jquery-data-editable', [JqueryEditableController::class, 'renderTable']);
