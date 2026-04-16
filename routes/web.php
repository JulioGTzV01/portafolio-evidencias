<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;

// Redirigir al login
Route::get('/', function () {
    return redirect('/login');
});

// Rutas Protegidas
Route::middleware(['auth'])->group(function () {

    // CRUD Productos
    Route::get('/productos/buscar', [ProductoController::class, 'buscar']);
    Route::resource('productos', ProductoController::class);

    
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

// Ruta de Login
require __DIR__.'/auth.php';