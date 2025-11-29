<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Empleados\Index as EmpleadosIndex;
use App\Livewire\Solicitudes\FormularioSolicitudViatico;
use App\Livewire\Solicitudes\VerSolicitudViatico;


Route::redirect('/', '/login')->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    Route::get('/empleados', EmpleadosIndex::class)->name('empleados.index');

    Route::get('/usuario-table', function(){
        return view('usuarios.index');
    });

    Route::get('/solicitudes/crear', FormularioSolicitudViatico::class)
    ->name('solicitudes.crear');

    Route::get('/solicitudes/{solicitud}', VerSolicitudViatico::class)->name('solicitud.ver');


});

require __DIR__.'/auth.php';

