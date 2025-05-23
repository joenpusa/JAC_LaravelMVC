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
use App\Http\Controllers\ComisionController;
use App\Http\Controllers\AutoController;
use App\Http\Controllers\CarpetaController;

Route::get('/', [WelcomeController::class, 'index']);

Auth::routes(['register' => false]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/generar-certificado', [CertificadoController::class, 'generar'])->name('certificado.generar');
Route::post('/generar-certificado-aso', [CertificadoController::class, 'generarAso'])->name('certificado.generarAso');
Route::post('/validar-certificado', [CertificadoController::class, 'validar'])->name('certificado.validar');
Route::get('/juntas/{junta_id}/descargar-archivos/{num_documento}', [DocumentoController::class, 'descargarArchivos'])->name('juntas.descargar-archivos');
Route::get('/asociaciones/{asociacion_id}/descargar-archivos/{num_documentoAso}', [DocumentoController::class, 'descargarArchivosAso'])->name('asocoaciones.descargar-archivos');
Route::get('/juntas/por-municipio/{municipio}', [JuntaController::class, 'getPorMunicipio'])->name('juntas.porMunicipio');
Route::get('/asociaciones/por-municipio/{municipio}', [AsociacionController::class, 'getPorMunicipio'])->name('asociaciones.porMunicipio');
//ruta para descargar archivos

Route::middleware(['auth'])->group(function () {
    //Rutas protegidas por autenticacion
    Route::resource('funcionarios', FuncionarioController::class);
    Route::get('/juntas/export', [JuntaController::class, 'export'])->name('juntas.export');
    Route::resource('juntas', JuntaController::class);


    Route::get('/asociaciones/export', [AsociacionController::class, 'export'])->name('asociaciones.export');
    Route::resource('asociaciones', AsociacionController::class)->parameters([
        'asociaciones' => 'asociacion'
    ]);
    Route::resource('comunas', ComunaController::class);
    Route::resource('certificados', CertificadoController::class);


    Route::get('/configuracion', [ConfiguracionController::class, 'index'])->name('configuracion.index');
    Route::post('/configuracion', [ConfiguracionController::class, 'store'])->name('configuracion.store');
    Route::resource('documentos', DocumentoController::class)->only(['store', 'destroy', 'show']);
    Route::resource('users', UserController::class);
    Route::patch('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggleActive');
    Route::patch('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.resetPassword');
    Route::get('/password/change', [UserController::class, 'showChangePasswordForm'])->name('password.change')->middleware('auth');
    Route::post('/password/change', [UserController::class, 'changePassword'])->name('password.update')->middleware('auth');

    Route::post('/comisiones', [ComisionController::class, 'store'])->name('comisiones.store');
    Route::delete('/comisiones/{id}', [ComisionController::class, 'destroy'])->name('comisiones.destroy');
    Route::post('/autos', [AutoController::class, 'store'])->name('autos.store');
    Route::delete('/autos/{auto}', [AutoController::class, 'destroy'])->name('autos.destroy');
    Route::resource('carpetas', CarpetaController::class);

    //rutas de eventos ajax
    Route::put('/funcionario/upload', [FuncionarioController::class, 'upload'])->name('funcionario.upload');
});
