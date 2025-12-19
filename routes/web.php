<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MiembroController;

Route::get('/', function () {
    return redirect()->route('miembros.index');
});

Route::resource('miembros', MiembroController::class);
