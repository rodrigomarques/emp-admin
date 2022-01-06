<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AssociadoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CupomController;
use App\Http\Controllers\InitController;
use App\Http\Controllers\FinanceiroController;

Route::get('/init', [InitController::class, 'load'])->name("init.load");

Route::match(['get','post'], '/', [AssociadoController::class, 'passo1'])->name("passo1");
Route::prefix('associado')->name("associado.")->group(function () {
    Route::get('passo-1', [AssociadoController::class, 'passo1'])->name("passo1");
    Route::post('save/passo-1', [AssociadoController::class, 'passo1Save'])->name("passo1-save");

    Route::match(['get','post'], 'passo-2/{idassociado}', [AssociadoController::class, 'passo2'])->name("passo2");
    Route::post('save/passo-2/{idassociado}', [AssociadoController::class, 'passo2Save'])->name("passo2-save");

    Route::match(['get','post'], 'passo-3/{idassociado}', [AssociadoController::class, 'passo3'])->name("passo3");
    Route::match(['get','post'], 'save/passo-3/{idassociado}', [AssociadoController::class, 'passo3Save'])->name("passo3-save");

    Route::match(['get','post'], 'passo-4/{idassociado}', [AssociadoController::class, 'passo4'])->name("passo4");
});

Route::match(['get','post'], '/login', [LoginController::class, 'login'])->name("login");
Route::match(['get','post'], '/logar', [LoginController::class, 'logar'])->name("logar");
Route::get('/sair', [LoginController::class, 'sair'])->name("sair");
Route::match(['get','post'], '/esqueceu-senha', [LoginController::class, 'esqueceuSenha'])->name("esqueceu-senha");
Route::match(['get','post'], '/send-esqueceu-senha', [LoginController::class, 'sendEsqueceuSenha'])->name("send-esqueceu-senha");

Route::get('/alterar-senha/{token}', [LoginController::class, 'alterarSenha'])->name("alterar-senha");
Route::post('/alterar-senha/{token}', [LoginController::class, 'confirmAlterarSenha'])->name("confirm-alterar-senha");

Route::middleware(['auth', 'validate.access'])->prefix('admin')->name("admin.")->group(function () {
    Route::match(['get','post'], '/', [AdminController::class, 'home'])->name("home")->middleware(["isAdmin"]);
    Route::get('/ajax-associados-ativos', [AdminController::class, 'ajaxAssociadosAtivos'])->name("ajax.associados.ativos")->middleware(["isAdmin"]);
    Route::get('/ajax-associados-ativos-inativos', [AdminController::class, 'ajaxAssociadosAtivosInativos'])->name("ajax.associados.ativos.inativos")->middleware(["isAdmin"]);
    Route::get('/ajax-planos', [AdminController::class, 'ajaxPlanos'])->name("ajax.planos")->middleware(["isAdmin"]);
    Route::get('/ajax-categorias', [AdminController::class, 'ajaxCategorias'])->name("ajax.categorias")->middleware(["isAdmin"]);

    Route::get('/meus-dados', [AdminController::class, 'meusDados'])->name("meus-dados");
    Route::post('/meus-dados', [AdminController::class, 'meusDadosSave'])->name("meus-dados.save");

    Route::prefix('cupom')->middleware(["isAdmin"])->name("cupom.")->group(function () {
        Route::match(['get', 'post'], '/', [CupomController::class, 'index'])->name("index");
        Route::match(['get', 'post'], '/save', [CupomController::class, 'save'])->name("save");
        Route::match(['get', 'post'], '/buscar', [CupomController::class, 'buscar'])->name("buscar");
        Route::match(['get', 'post'], '/ajax-buscar', [CupomController::class, 'ajaxBuscar'])->name("ajax.buscar");
    });

    Route::prefix('associado')->name("associado.")->group(function () {
        Route::match(['get', 'post'], '/buscar', [AssociadoController::class, 'adminBuscar'])->name("buscar")->middleware(["isAdmin"]);
        Route::match(['get', 'post'], '/ajax-buscar', [AssociadoController::class, 'adminAjaxBuscar'])->name("ajax.buscar")->middleware(["isAdmin"]);

        Route::match(['get', 'post'], '/aguardando-aprovacao', [AssociadoController::class, 'adminAguardandoAprovacao'])->name("aguardando.aprovacao")->middleware(["isAdmin"]);
        Route::match(['get', 'post'], '/ajax-aguardando-aprovacao', [AssociadoController::class, 'adminAjaxAguardandoAprovacao'])->name("ajax.aguardando.aprovacao")->middleware(["isAdmin"]);

        Route::match(['get', 'post'], '/dependentes', [AssociadoController::class, 'adminDependentes'])->name("dependentes")->middleware(["isAdmin"]);
        Route::match(['get', 'post'], '/ajax-dependentes', [AssociadoController::class, 'adminAjaxDependentes'])->name("ajax.dependentes");
        Route::get('/dependentes/editar/{iddependente}', [AssociadoController::class, 'editarDependente'])->name("dependentes.editar")->middleware(["isAdmin"]);
        Route::post('/dependentes/editar/{iddependente}', [AssociadoController::class, 'editarDependenteSave'])->name("dependentes.editar.save")->middleware(["isAdmin"]);

        Route::get('/ajax-detalhes/{idassociado}', [AssociadoController::class, 'adminAjaxDetalhes'])->name("ajax.detalhes");
        Route::get('/editar/{idassociado}', [AssociadoController::class, 'editar'])->name("editar")->middleware(["isAdmin"]);
        Route::post('/editar/{idassociado}', [AssociadoController::class, 'editarAssociadoSave'])->name("editar.save")->middleware(["isAdmin"]);

        Route::get('/ajax-aprovar/{idassociado}', [AssociadoController::class, 'adminAjaxAprovar'])->name("ajax.aprovar")->middleware(["isAdmin"]);
        Route::get('/ajax-excluir/{idassociado}', [AssociadoController::class, 'adminAjaxExcluir'])->name("ajax.excluir")->middleware(["isAdmin"]);

        Route::match(['get', 'post'], '/meus-dependentes', [AssociadoController::class, 'meusDependentes'])->name("meus.dependentes");

    });

    Route::prefix('financeiro')->name("financeiro.")->group(function () {
        Route::match(['get', 'post'], '/', [FinanceiroController::class, 'index'])->name("index")->middleware(["isAdmin"]);
        Route::match(['get', 'post'], '/meus-pagamentos', [FinanceiroController::class, 'meusPagamentos'])->name("meus.pagamentos");
    });
});
