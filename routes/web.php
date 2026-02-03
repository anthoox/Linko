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


Route::get('categories', Index::class)
    ->middleware(['auth'])
    ->name('category.index');


Route::get('/home', DashboardIndex::class)
    ->middleware(['auth'])
    ->name('dashboard');

Route::redirect('/dashboard', '/home');

require __DIR__.'/settings.php';
