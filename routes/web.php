<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DomainServiceController;
use App\Http\Controllers\HostingServiceController;
use App\Http\Controllers\RenewalResponseController;
use App\Http\Livewire\Accounts\Show as AccountShow;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/accounts/{account}', AccountShow::class)->name('accounts.show');

Route::resource('accounts', AccountController::class)->except(['create', 'edit']);
Route::resource('hosting-services', HostingServiceController::class)->except(['create', 'edit']);
Route::resource('domain-services', DomainServiceController::class)->except(['create', 'edit']);

Route::get('/renewals/{token}', [RenewalResponseController::class, 'show'])->name('renewals.respond');
Route::post('/renewals/{token}', [RenewalResponseController::class, 'respond'])->name('renewals.respond.submit');
