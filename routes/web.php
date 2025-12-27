<?php

use App\Http\Controllers\RenewalResponseController;
use App\Http\Livewire\Accounts\Index as AccountIndex;
use App\Http\Livewire\Accounts\Form as AccountForm;
use App\Http\Livewire\Accounts\Show as AccountShow;
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

Route::get('/accounts', AccountIndex::class)->name('accounts.index');
Route::get('/accounts/create', AccountForm::class)->name('accounts.create');
Route::get('/accounts/{account}', AccountShow::class)->name('accounts.show');
Route::get('/accounts/{account}/edit', AccountForm::class)->name('accounts.edit');

Route::get('/hosting-services', HostingServiceIndex::class)->name('hosting-services.index');
Route::get('/hosting-services/create', HostingServiceForm::class)->name('hosting-services.create');
Route::get('/hosting-services/{hostingService}/edit', HostingServiceForm::class)->name('hosting-services.edit');

Route::get('/domain-services', DomainServiceIndex::class)->name('domain-services.index');
Route::get('/domain-services/create', DomainServiceForm::class)->name('domain-services.create');
Route::get('/domain-services/{domainService}/edit', DomainServiceForm::class)->name('domain-services.edit');

Route::get('/renewals/{token}', [RenewalResponseController::class, 'show'])->name('renewals.respond');
Route::post('/renewals/{token}', [RenewalResponseController::class, 'respond'])->name('renewals.respond.submit');
