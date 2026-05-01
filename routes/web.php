<?php

use App\Livewire\Category\Index as CategoryIndex;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard\Index as DashboardIndex;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/home', DashboardIndex::class)->name('dashboard');
    Route::redirect('/dashboard', '/home');

    Route::get('/categories', CategoryIndex::class)->name('category.index');

    require __DIR__ . '/settings.php';
});