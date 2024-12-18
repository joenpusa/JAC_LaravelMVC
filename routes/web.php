<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\JuntaController;
use App\Http\Controllers\ComunaController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AsociacionController;

Route::get('/', [WelcomeController::class, 'index']);

Auth::routes(['register' => false]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/generar-certificado', [CertificadoController::class, 'generar'])->name('certificado.generar');
Route::post('/generar-certificado-aso', [CertificadoController::class, 'generarAso'])->name('certificado.generarAso');
Route::post('/validar-certificado', [CertificadoController::class, 'validar'])->name('certificado.validar');
Route::get('/juntas/{junta_id}/descargar-archivos/{num_documento}', [DocumentoController::class, 'descargarArchivos'])->name('juntas.descargar-archivos');
Route::get('/asociaciones/{asociacion_id}/descargar-archivos/{num_documentoAso}', [DocumentoController::class, 'descargarArchivosAso'])->name('asocoaciones.descargar-archivos');
//ruta para descargar archivos

Route::middleware(['auth'])->group(function () {
    //Rutas protegidas por autenticacion
    Route::resource('funcionarios', FuncionarioController::class);
    Route::resource('juntas', JuntaController::class);
    Route::resource('comunas', ComunaController::class);
    Route::resource('certificados', CertificadoController::class);
    Route::get('asociaciones/{asociacion}/edit', [AsociacionController::class, 'edit']);
    Route::resource('asociaciones', AsociacionController::class);

    Route::get('/configuracion', [ConfiguracionController::class, 'index'])->name('configuracion.index');
    Route::post('/configuracion', [ConfiguracionController::class, 'store'])->name('configuracion.store');
    Route::resource('documentos', DocumentoController::class)->only(['store', 'destroy', 'show']);
    Route::resource('users', UserController::class);
    Route::patch('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggleActive');
    Route::patch('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.resetPassword');
    Route::get('/password/change', [UserController::class, 'showChangePasswordForm'])->name('password.change')->middleware('auth');
    Route::post('/password/change', [UserController::class, 'changePassword'])->name('password.update')->middleware('auth');



    //rutas de eventos ajax
    Route::put('/funcionario/upload', [FuncionarioController::class, 'upload'])->name('funcionario.upload');
});
