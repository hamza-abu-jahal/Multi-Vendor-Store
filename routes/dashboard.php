<?php

use App\Http\Controllers\Dashboard\AdminsController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ImportProductsController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\UsersController;
use App\Http\Controllers\DashboardController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['auth:admin' ],   //'auth.type:super_admin,admin' => //NameMiddeware:NameNewParmeter
    'as' => 'dashboard.',
    'prefix' => 'admin/dashboard',

], function (){

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/', [DashboardController::class , 'index'])->name('dashboard');

    Route::get('/categories/trash', [CategoriesController::class , 'trash'])->name('categories.trash');
    Route::put('/categories/{category}/restore', [CategoriesController::class , 'restore'])->name('categories.restore');
    Route::delete('/categories/{category}/forse-delete', [CategoriesController::class , 'forseDelete'])->name('categories.forse-delete');


    Route::get('products/import', [ImportProductsController::class, 'create'])->name('products.import');
    Route::post('products/import', [ImportProductsController::class, 'store']);

    Route::resource('/categories', CategoriesController::class);
    Route::resource('/products', ProductsController::class);
    Route::resource('/roles', RoleController::class);
    Route::resource('/admins', AdminsController::class);
    Route::resource('/users', UsersController::class);

});

// Route::middleware('auth')->as('dashboard.')->prefix('dashboard')->group(function (){

// });

