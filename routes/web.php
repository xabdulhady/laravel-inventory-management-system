<?php

use App\Http\Controllers\Admin\AdminCategorytController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RedirectController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminFrontController;
use App\Http\Controllers\Admin\AdminSubCategoryController;
use App\Http\Controllers\Admin\AdminLocationController;
use App\Http\Controllers\Admin\AdminSupplierController;
use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminReceiveStockController;
use App\Http\Controllers\Admin\AdminAjaxController;

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

Auth::routes(['register' => false]);
Route::get('/', RedirectController::class)->name('index');
Route::get('/redirect', RedirectController::class)->name('redirect');

Route::middleware(['auth', 'admin.auth'])->prefix('admin')->as('admin.')->group(function () {

    Route::prefix('ajax')->as('ajax.')->group(function () {
        Route::post('/get-subcategories', [AdminAjaxController::class, 'subcategories'])->name('subcategories');
    });

    Route::get('/', [AdminFrontController::class, 'index'])->name('index');
    Route::resource('/category', AdminCategorytController::class, ['except' => ['show']]);
    Route::resource('/subcategory', AdminSubCategoryController::class, ['except' => ['show']]);
    Route::resource('/location', AdminLocationController::class, ['except' => ['show']]);

    Route::resource('/supplier', AdminSupplierController::class, ['except' => ['show']]);
    Route::get('/supplier-trash', [AdminSupplierController::class, 'trash'])->name('supplier.trash');
    Route::PATCH('/supplier-trash/{id}', [AdminSupplierController::class, 'restore'])->name('supplier.restore');

    Route::resource('/customer', AdminCustomerController::class, ['except' => ['show']]);
    Route::get('/customer-trash', [AdminCustomerController::class, 'trash'])->name('customer.trash');
    Route::PATCH('/customer-trash/{id}', [AdminCustomerController::class, 'restore'])->name('customer.restore');

    Route::resource('/product', AdminProductController::class, ['except' => ['show']]);
    Route::get('/product-trash', [AdminProductController::class, 'trash'])->name('product.trash');
    Route::PATCH('/product-trash/{id}', [AdminProductController::class, 'restore'])->name('product.restore');

    Route::resource('/receive-stock', AdminReceiveStockController::class, ['except' => ['show']]);



});
