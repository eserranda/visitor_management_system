<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\VisitorsController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\FutureVisitorController;
use App\Http\Controllers\RoleController;

Route::get('/', function () {
    return view('page.users.index');
});

Route::get('/users', function () {
    return view('page.users.index');
});

Route::get('login', [UserController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('login', [UserController::class, 'login'])->middleware('guest');



Route::prefix('users')->controller(UserController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/data', 'getAllDataTable')->name('users.data');
    Route::post('/register', 'register');
    Route::get('/add', 'add');
    Route::get('/findById/{id}', 'findById');
    Route::post('/update/{id}', 'update');
    Route::delete('/destroy/{id}', 'destroy');
    Route::get('/getAll', 'getAll');
    Route::get('/findById/{id}', 'findById');

    // Route::get('/customers', 'userCustomers')->name('user-customers.index');
    // Route::post('/customer/register', 'customerRegister');

    // Route::get('/profile', 'profile');
    // Route::get('/edit-profile', 'editProfile');
});

Route::get('/dashboard', function () {
    return view('page.dashboard.index');
});


Route::prefix('address')->controller(AddressController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/create', 'create');
    Route::get('/findById/{id}', 'findById');
    Route::post('/store', 'store');
    Route::get('/data', 'getAllDataTable')->name('address.data');
    Route::get('/getAddressesGroupedByBlock', 'getAddressesGroupedByBlock');
    Route::delete('/destroy/{id}', 'destroy');
    Route::post('/update/{id}', 'update');
});

Route::prefix('future-visitors')->controller(FutureVisitorController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/store', 'store');
    Route::get('/data', 'getAllDataTable')->name('future-visitors.data');
    Route::get('/findById/{id}', 'findById');
    Route::put('/update/{id}', 'update');
    Route::get('/detail/{id}', 'detail');
    Route::delete('/destroy/{id}', 'destroy');
});

Route::prefix('roles')->controller(RoleController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/data', 'getAllDataTable')->name('roles.data');
    Route::post('/store', 'store');
    // Route::get('/findById/{id}', 'findById');
    Route::delete('/destroy/{id}', 'destroy');
});

Route::prefix('visitors')->controller(VisitorsController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/data', 'getAllWithDataTable')->name('visitors.data');
    Route::get('/pengunjung_aktif', 'pengunjungAktif');
    Route::get('/data_pengunjung_aktif', 'GetAllDataPengunjungAktif')->name('visitors.pengunjung_aktif');
    Route::get('/registrasi', 'registrasi');
    Route::get('/create', 'create');
    Route::post('/store', 'store');
    Route::put('/update/{id}', 'update');
    Route::get('/detail/{id}', 'detail');
    Route::delete('/destroy/{id}', 'destroy');
    // Route::get('/data', 'getAllDataTable')->name('address.data');
    // Route::get('/getAddressesGroupedByBlock', 'getAddressesGroupedByBlock');
});

Route::prefix('companies')->controller(CompaniesController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/create', 'create');
    Route::get('/findById/{id}', 'findById');
    Route::post('/update/{id}', 'update');
    Route::post('/store', 'store');
    Route::get('/data', 'getAllDataTable')->name('companies.data');
    Route::delete('/destroy/{id}', 'destroy');
});

// Route::get('/address', function () {
//     return view('page.address.index');
// });
