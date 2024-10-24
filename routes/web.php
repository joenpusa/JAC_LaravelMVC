<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\JuntaController;
use App\Http\Controllers\ComunaController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\DocumentoController;

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

Route::get('/', [WelcomeController::class, 'index']);
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/generar-certificado', [CertificadoController::class, 'generar'])->name('certificado.generar');
Route::post('/validar-certificado', [CertificadoController::class, 'validar'])->name('certificado.validar');


Route::middleware(['auth'])->group(function () {
    //Rutas protegidas por autenticacion
    Route::resource('funcionarios', FuncionarioController::class);
    Route::resource('juntas', JuntaController::class);
    Route::resource('comunas', ComunaController::class);
    Route::resource('certificados', CertificadoController::class);

    Route::get('/configuracion', [ConfiguracionController::class, 'index'])->name('configuracion.index');
    Route::post('/configuracion', [ConfiguracionController::class, 'store'])->name('configuracion.store');
    Route::resource('documentos', DocumentoController::class)->only(['store', 'destroy', 'show']);

    //rutas de eventos ajax
    Route::put('/funcionario/upload', [FuncionarioController::class, 'upload'])->name('funcionario.upload');
});
