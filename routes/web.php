<?php

use App\Http\Controllers\Dashboard\CompanyController;
use App\Http\Controllers\Dashboard\ExpenseController;
use App\Http\Controllers\Dashboard\IncomeController;
use App\Http\Controllers\Dashboard\InventoryController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\VisitorController;
use App\Http\Controllers\Dashboard\ZoneController;
use App\Http\Controllers\ProfileController;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Inventory;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/inventory', function () {
    return view('inventory');
})->middleware(['auth', 'verified'])->name('inventory');


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
   
});

Route::middleware(['auth'])->prefix('inventories')->group(function () {
    Route::get('/listkardex', [InventoryController::class, 'inventoryPdf'])->name('kardex.general');
   

});

Route::get('/productos/{company}', [IncomeController::class, 'getProducts'])->middleware('auth');
Route::get('/inventories/stock/{product}', [InventoryController::class, 'getStock'])->middleware('auth');
Route::post('/expense', [ExpenseController::class, 'store'])->middleware('auth');



Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('visitor', VisitorController::class);
    Route::resource('zone', ZoneController::class);
    Route::resource('company', CompanyController::class);
    Route::resource('product', ProductController::class);
    Route::resource('inventory', InventoryController::class);
    Route::resource('income', IncomeController::class);
    Route::resource('expense', ExpenseController::class);
    Route::get('/listzone', [ZoneController::class, 'zonePdf'])->name('listado.zonas');
    Route::get('/listvisitor', [VisitorController::class, 'visitorPdf'])->name('listado.visitadores');
    Route::get('/listcompany', [CompanyController::class, 'companyPdf'])->name('listado.empresas');
    Route::get('/listproduct', [ProductController::class, 'productPdf'])->name('listado.productos');
    Route::get('/listentry/{entry}', [IncomeController::class, 'entryPdf'])->name('income.entry');
    Route::get('/listexpense/{expense}', [ExpenseController::class, 'expensePdf'])->name('expense.expense');
    
});

require __DIR__.'/auth.php';
