<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitorsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('page.users.index');
});

Route::get('/users', function () {
    return view('page.users.index');
});

Route::prefix('users')->controller(UserController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/data', 'getAllDataTable')->name('users.data');
    Route::post('/register', 'register');
    Route::get('/add', 'add');
    Route::get('/findById/{id}', 'findById');
    Route::post('/update', 'update');
    Route::delete('/destroy/{id}', 'destroy');

    // Route::get('/customers', 'userCustomers')->name('user-customers.index');
    // Route::post('/customer/register', 'customerRegister');
    // Route::get('/findById/{id}', 'findById');
    // Route::post('/update', 'update');
    // Route::delete('/destroy/{id}', 'destroy');

    // Route::get('/profile', 'profile');
    // Route::get('/edit-profile', 'editProfile');
});

Route::get('/dashboard', function () {
    return view('page.dashboard.index');
});

Route::prefix('address')->controller(AddressController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/create', 'create');
    Route::post('/store', 'store');
    Route::get('/data', 'getAllDataTable')->name('address.data');
    Route::get('/getAddressesGroupedByBlock', 'getAddressesGroupedByBlock');
});

Route::prefix('visitors')->controller(VisitorsController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/create', 'create');
    Route::post('/store', 'store');
    // Route::get('/data', 'getAllDataTable')->name('address.data');
    // Route::get('/getAddressesGroupedByBlock', 'getAddressesGroupedByBlock');
});

// Route::get('/address', function () {
//     return view('page.address.index');
// });

Route::get('/visitors', function () {
    return view('page.visitors.index');
});
