<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AssociadoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CupomController;
use App\Http\Controllers\InitController;

Route::get('/init', [InitController::class, 'load'])->name("init.load");

Route::match(['get','post'], '/', [AssociadoController::class, 'passo1'])->name("passo1");
Route::prefix('associado')->name("associado.")->group(function () {
    Route::match(['get','post'], 'passo-1', [AssociadoController::class, 'passo1'])->name("passo1");
    Route::match(['get','post'], 'passo-2', [AssociadoController::class, 'passo2'])->name("passo2");
    Route::match(['get','post'], 'passo-3', [AssociadoController::class, 'passo3'])->name("passo3");
    Route::match(['get','post'], 'passo-4', [AssociadoController::class, 'passo4'])->name("passo4");
});

Route::match(['get','post'], '/login', [LoginController::class, 'login'])->name("login");
Route::match(['get','post'], '/logar', [LoginController::class, 'logar'])->name("logar");
Route::get('/sair', [LoginController::class, 'sair'])->name("sair");

Route::middleware(['auth', 'validate.access'])->prefix('admin')->name("admin.")->group(function () {
    Route::match(['get','post'], '/', [AdminController::class, 'home'])->name("home");

    Route::prefix('cupom')->name("cupom.")->group(function () {
        Route::match(['get', 'post'], '/', [CupomController::class, 'index'])->name("index");
        Route::match(['get', 'post'], '/save', [CupomController::class, 'save'])->name("save");
        Route::match(['get', 'post'], '/buscar', [CupomController::class, 'buscar'])->name("buscar");
        Route::match(['get', 'post'], '/ajax-buscar', [CupomController::class, 'ajaxBuscar'])->name("ajax.buscar");
    });

});
