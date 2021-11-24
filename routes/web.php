<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AssociadoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CupomController;

Route::match(['get','post'], '/', [AssociadoController::class, 'passo1'])->name("passo1");
Route::prefix('associado')->name("associado.")->group(function () {
    Route::match(['get','post'], 'passo-1', [AssociadoController::class, 'passo1'])->name("passo1");
    Route::match(['get','post'], 'passo-2', [AssociadoController::class, 'passo2'])->name("passo2");
    Route::match(['get','post'], 'passo-3', [AssociadoController::class, 'passo3'])->name("passo3");
    Route::match(['get','post'], 'passo-4', [AssociadoController::class, 'passo4'])->name("passo4");
});

Route::match(['get','post'], '/login', [LoginController::class, 'login'])->name("login");

Route::prefix('admin')->name("admin.")->group(function () {
    Route::match(['get','post'], '/', [AdminController::class, 'home'])->name("home");

    Route::prefix('cupom')->name("cupom.")->group(function () {
        Route::match(['get', 'post'], '/', [CupomController::class, 'index'])->name("index");
        Route::match(['get', 'post'], '/save', [CupomController::class, 'save'])->name("save");
        Route::match(['get', 'post'], '/buscar', [CupomController::class, 'buscar'])->name("buscar");
    });

});
