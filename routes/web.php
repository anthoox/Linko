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

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('category', Index::class)->name('category.index');


Route::get('/dashboard', DashboardIndex::class)->middleware(['auth'])->name('dashboard');

require __DIR__.'/settings.php';
