<?php

use App\Http\Controllers\Master\API\MasterDataStatusController;
use App\Http\Controllers\Share\JqueryEditableController;
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
// Render Jquery DataTable Editable
Route::post('jquery-data-editable', [JqueryEditableController::class, 'renderTable']);
