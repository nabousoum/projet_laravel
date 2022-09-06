<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
    return view('auth/login');
});

/* route page d accueil user */



/* route page d accueil admin */
//Route::get('/dashboard',[UserController::class,'accueilAdmin'])->middleware(['auth'])->name('dashboard');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard',[UserController::class,'accueilAdmin'])->name('dashboard');
});

Route::middleware(['auth','role:admin'])->group(function(){
    Route::get('/admin', function () {
        return 'Bonjour admin';
    });
    Route::get('/dashboardUser',[UserController::class,'accueil']);

    Route::get('/users/create',[UserController::class,'create'])->name('users.create');

    Route::post('/users/create',[UserController::class,'store'])->name('users.store');

    Route::get('/users/{id}',[UserController::class,'update'])->name('user.update');

    Route::post('/users/edit',[UserController::class,'edit'])->name('users.update');

    Route::post('/users/delete',[UserController::class,'delete'])->name('user.delete');
});
