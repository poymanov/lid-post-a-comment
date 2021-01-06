<?php

use App\Http\Livewire\Pages\Home;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Registration;
use App\Http\Livewire\Topic\Create;
use App\Http\Livewire\Topic\TopicList;
use App\Http\Livewire\Topic\Update;
use App\Http\Livewire\Topic\View;
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
Route::get('/topics', TopicList::class)->name('topic.list');
Route::get('/topics/create', Create::class)->name('topic.create')->middleware('auth');
Route::get('/topics/{topic}/edit', Update::class)->name('topic.edit')->middleware('auth');
Route::get('/topics/{topic}', View::class)->name('topic.view');
