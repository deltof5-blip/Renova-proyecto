<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\MovilController;

Route::get('/', function () {
    return Inertia::render('welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});
Route::resource('marcas', MarcaController::class)->except(['show', 'create', 'edit']);
Route::resource('modelos', ModeloController::class)->except(['create','edit','show']);
Route::resource('moviles', MovilController::class)
    ->except(['create','edit','show'])
    ->parameters(['moviles' => 'movil']);

require __DIR__.'/settings.php';
