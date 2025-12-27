<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DomainServiceController;
use App\Http\Controllers\HostingServiceController;
use App\Http\Controllers\RenewalResponseController;
use App\Http\Livewire\Accounts\Show as AccountShow;
use App\Http\Livewire\Accounts\Index as AccountIndex;
use App\Http\Livewire\Accounts\Form as AccountForm;
use App\Http\Livewire\DomainServices\Index as DomainServiceIndex;
use App\Http\Livewire\DomainServices\Form as DomainServiceForm;
use App\Http\Livewire\HostingServices\Index as HostingServiceIndex;
use App\Http\Livewire\HostingServices\Form as HostingServiceForm;
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

Route::prefix('crm')->name('crm.')->group(function () {
    Route::get('/accounts', AccountIndex::class)->name('accounts.index');
    Route::get('/accounts/create', AccountForm::class)->name('accounts.create');
    Route::get('/accounts/{account}/edit', AccountForm::class)->name('accounts.edit');

    Route::get('/hosting-services', HostingServiceIndex::class)->name('hosting.index');
    Route::get('/hosting-services/create', HostingServiceForm::class)->name('hosting.create');
    Route::get('/hosting-services/{hostingService}/edit', HostingServiceForm::class)->name('hosting.edit');

    Route::get('/domain-services', DomainServiceIndex::class)->name('domains.index');
    Route::get('/domain-services/create', DomainServiceForm::class)->name('domains.create');
    Route::get('/domain-services/{domainService}/edit', DomainServiceForm::class)->name('domains.edit');
});

Route::get('/renewals/{token}', [RenewalResponseController::class, 'show'])->name('renewals.respond');
Route::post('/renewals/{token}', [RenewalResponseController::class, 'respond'])->name('renewals.respond.submit');
