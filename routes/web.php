<?php

use App\Http\Controllers\A404;
use App\Http\Controllers\Dashboard\CustomersReportController;
use App\Http\Controllers\Dashboard\InvoicesArchiveController;
use App\Http\Controllers\Dashboard\InvoicesAttachmentsController;
use App\Http\Controllers\Dashboard\InvoicesController;
use App\Http\Controllers\Dashboard\InvoicesReportController;
use App\Http\Controllers\Dashboard\SectionsController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Route::get('/a404', [A404::class, 'a404'])->name('a404');

Auth::routes();

Route::get('/MarkAsRead_all', [InvoicesController::class, 'MarkAsRead_all'])->name('MarkAsRead_all');

Route::middleware(['CheckStatus'])->group(function () {  
    Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('invoices')->middleware('auth')->group(function () {
    Route::get('/index', [InvoicesController::class, 'index'])->name('invoices.index');
    Route::get('/create', [InvoicesController::class, 'create'])->name('invoices.create');
    Route::post('/store', [InvoicesController::class, 'store'])->name('invoices.store');
    Route::get('/prodBySec/{id}', [InvoicesController::class, 'prodBySec']);
    Route::get('/invoicesDetails/{id}', [InvoicesController::class, 'invoicesDetails'])->name('invoicesDetails');

    Route::get('download/{id}/{file_name}', [InvoicesAttachmentsController::class, 'get_file']);
    Route::get('View_file/{id}/{file_name}', [InvoicesAttachmentsController::class, 'open_file']);

    Route::get('/edit/{id}', [InvoicesController::class, 'edit'])->name('invoices.edit');
    Route::post('/update/{id}', [InvoicesController::class, 'update'])->name('invoices.update');
    Route::post('/delete', [InvoicesController::class, 'destroy'])->name('invoices.delete');

    Route::get('/Status_edit/{id}', [InvoicesController::class, 'Status_edit'])->name('Status_edit');
    Route::post('/Status_Update/{id}', [InvoicesController::class, 'Status_Update'])->name('Status_Update');

    Route::get('/Paid', [InvoicesController::class, 'invoicesPaid'])->name('invoicesPaid');
    Route::get('/Unpaid', [InvoicesController::class, 'invoicesUnpaid'])->name('invoicesUnpaid');
    Route::get('/Partial', [InvoicesController::class, 'invoicesPartial'])->name('invoicesPartial');

    Route::get('/Print_invoice/{id}', [InvoicesController::class, 'Print_invoice'])->name('Print_invoice');

    Route::get('/invoicesArchive', [InvoicesArchiveController::class, 'invoicesArchive'])->name('invoicesArchive');
    Route::get('/archive/{id}', [InvoicesArchiveController::class, 'archive'])->name('invoices.archive');
    Route::get('/archiveCancel/{id}', [InvoicesArchiveController::class, 'update'])->name('invoices.archiveCancel');
    Route::get('/destroy/{id}', [InvoicesArchiveController::class, 'destroy'])->name('destroy_arch');
});
Route::prefix('sections')->middleware('auth')->group(function () {
    Route::get('/index', [SectionsController::class, 'index'])->name('sections.index');
    Route::post('/store', [SectionsController::class, 'store'])->name('sections.store');
    Route::post('/update', [SectionsController::class, 'update'])->name('sections.update');
    Route::post('/delete', [SectionsController::class, 'destroy'])->name('sections.destroy');
});
Route::prefix('products')->middleware('auth')->group(function () {
    Route::get('/index', [ProductsController::class, 'index'])->name('products.index');
    Route::post('/store', [ProductsController::class, 'store'])->name('products.store');
    Route::post('/update', [ProductsController::class, 'update'])->name('products.update');
    Route::post('/delete', [ProductsController::class, 'destroy'])->name('products.destroy');
});


Route::group(['middleware' => ['auth']], function () {
    // route resource : Users'
    Route::get('/index', [UserController::class, 'index'])->name('users.index');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::post('/destroy', [UserController::class, 'destroy'])->name('users.destroy');

    // route resource : roles 
    Route::get('/roles/index', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles/store', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('/roles/update/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::get('/roles/destroy/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
    Route::get('/roles/show/{id}', [RoleController::class, 'show'])->name('roles.show');

});
Route::prefix('reports')->middleware('auth')->group(function () {
    Route::get('/index', [InvoicesReportController::class, 'index'])->name('reportsINV.index');
    Route::post('/Search_invoices', [InvoicesReportController::class, 'Search_invoices'])->name('Search_invoices');
    
});
Route::prefix('customers')->middleware('auth')->group(function () {
    Route::get('/index', [CustomersReportController::class, 'index'])->name('reportsCust.index');
    Route::post('/Search_customers', [CustomersReportController::class, 'Search_customers'])->name('Search_customers');
});
Route::prefix('profile')->middleware('auth')->group(function () {
    Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/update', [ProfileController::class, 'update'])->name('profile.update');
});

});

