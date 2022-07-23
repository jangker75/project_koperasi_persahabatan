<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Toko\ProductController;
use App\Http\Controllers\Umum\EmployeeController;
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

Route::get('/', function () {
    return redirect('/admin');
});
Route::get('/admin', function () {
    return redirect(route('admin.dashboard'));
});
Route::resource('product', ProductController::class);
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
