<?php

use App\Http\Livewire\Pages\Home;
use App\Http\Livewire\Pages\Login;
use App\Http\Livewire\Pages\Registration;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', Home::class)->name('home');
Route::get('/login', Login::class)->name('login');
Route::get('/registration', Registration::class)->name('registration');
