<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Empleados\Empleados;
use App\Livewire\Solicitudes\FormularioSolicitudViatico;
use App\Livewire\Solicitudes\VerSolicitudViatico;
use App\Http\Controllers\PDFController;
use App\Livewire\Certificaciones\FormularioCertificacion;
use App\Livewire\Reportes\ReporteMensual;
use App\Http\Controllers\ReporteController;
use App\Livewire\Solicitudes\IndexSolicitudes;



Route::redirect('/', '/login')->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    Route::get('/empleados', Empleados::class)->name('empleados.empleado');



    Route::get('/usuario-table', function () {
        return view('usuarios.index');
    });

    Route::get('/solicitudes/crear', FormularioSolicitudViatico::class)
    ->name('solicitudes.crear');

    Route::get('/solicitudes/{solicitud}', VerSolicitudViatico::class)->name('solicitud.ver');
    Route::get('solicitud/pdf/{id}', [PDFController::class, 'generarPDF'])->name('generar.pdf');
    Route::get('/solicitudes/{id}/certificar', FormularioCertificacion::class)->name('solicitudes.certificar');
    Route::get('solicitud/{solicitud_id}/certificado/{empleado_id}', [PDFController::class, 'generarCertificado'])
        ->name('certificado.pdf');
    Route::get('solicitud/{solicitud_id}/liquidacion/{empleado_id}', [PDFController::class, 'generarLiquidacion'])
        ->name('liquidacion.pdf');
    Route::get('/reportes', ReporteMensual::class)->name('reportes.mensual');

    Route::get('/reportes/exportar/pdf', [ReporteController::class, 'exportarPDF'])
        ->name('reportes.exportar.pdf');
    Route::get('/reportes/exportar/excel', [ReporteController::class, 'exportarExcel'])
        ->name('reportes.exportar.excel');

    Route::get('/solicitudes', IndexSolicitudes::class)->name('solicitudes.index');

});

require __DIR__.'/auth.php';

