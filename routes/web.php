<?php

use App\livewire\Category\Index;
use App\livewire\Settings\Appearance;
use App\livewire\Settings\Password;
use App\livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard\Index as DashboardIndex;


Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/home', DashboardIndex::class)->name('dashboard');
    Route::redirect('/dashboard', '/home');

    Route::get('categories', index::class)->name('category.index');

    require __DIR__ . '/settings.php';
});