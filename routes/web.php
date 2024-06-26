<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PostingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AutocompleteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/company', CompanyController::class)->except('show');
    Route::post('/company/import', [CompanyController::class, 'import'])->name('company.import');
    Route::resource('/invoice', InvoiceController::class);
    Route::get('/invoice/{invoice}/pdf', [InvoiceController::class, 'downloadPDF'])->name('invoice.downloadPDF');
    Route::resource('/posting', PostingController::class);
    Route::resource('/product', ProductController::class)->except('show');
    Route::get('/autocomplete', [AutocompleteController::class, 'company']);
});

require __DIR__.'/auth.php';
