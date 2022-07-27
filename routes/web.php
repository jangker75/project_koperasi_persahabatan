<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Master\MasterDataStatusController;
use App\Http\Controllers\Toko\CategoryController;
use App\Http\Controllers\Toko\ProductController;
use App\Http\Controllers\Umum\EmployeeController;
use App\Models\Product;
use App\Http\Controllers\Umum\ExEmployeeController;
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
    Route::get('dashboard', function () {
        return view('admin.pages.dashboard.index');
    })->name('dashboard');
    Route::get('pinjaman', function () {
        return view('admin.pages.dashboard.index');
    })->name('pinjaman');
    Route::get('switcher', function () {
        return view('admin.pages.switcher.index');
    })->name('switcher');

    //toko-online
    Route::get('master-data-status', [MasterDataStatusController::class, 'index'])->name('master-status.index');
    Route::resource('product', ProductController::class);
    Route::resource('category', CategoryController::class);
    //toko-online

    
    Route::resource('employee', EmployeeController::class);
    Route::get('employee-out', [EmployeeController::class, 'employeeOut'])->name('employee.out');
    Route::post('employee-store', [EmployeeController::class, 'employeeOutStore'])->name('employee.out.store');
    Route::resource('ex-employee', ExEmployeeController::class);

    // Datatables Route
    Route::get('datatables-employee-index', [EmployeeController::class, 'getIndexDatatables'])->name('employee.index.datatables');
    Route::get('datatables-ex-employee-index', [ExEmployeeController::class, 'getIndexDatatables'])->name('ex-employee.index.datatables');

    //Logout custom
    Route::post('custom-logout', [LogoutController::class, 'logout'])->name('logout');
});


//Redirect all wild domain
Route::get('{any}', function () {
    return redirect(route('admin.dashboard'));
})->where('any', '.*');
