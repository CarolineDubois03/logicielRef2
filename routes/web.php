<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Exports\CouriersExport;
use Maatwebsite\Excel\Facades\Excel;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});


Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'doLogin']);
Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);






Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    
    
    Route::get('export-couriers', [\App\Http\Controllers\Admin\CourierController::class, 'export'])->name('couriers.export');

    // Profil de l'utilisateur
    Route::get('profile', [\App\Http\Controllers\Admin\UsersController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [\App\Http\Controllers\Admin\UsersController::class, 'edit'])->name('profile.edit');
    Route::put('profile/update/{id}', [\App\Http\Controllers\Admin\UsersController::class, 'update'])->name('profile.update');
    Route::get('profile/change-password', [\App\Http\Controllers\Admin\UsersController::class, 'showChangePasswordForm'])->name('profile.showChangePasswordForm');
    Route::post('profile/change-password', [\App\Http\Controllers\Admin\UsersController::class, 'changePassword'])->name('profile.change-password');
    
    Route::get('courier/additionalColumns', [\App\Http\Controllers\Admin\CourierController::class, 'showColumns'])->name('courier.showColumns');
    Route::post('courier/additionalColumns', [\App\Http\Controllers\Admin\CourierController::class, 'storeColumns'])->name('courier.storeColumns');
    Route::post('courier/additionalColumns/{id}', [\App\Http\Controllers\Admin\CourierController::class, 'editColumn'])->name('courier.editColumn');
    Route::delete('courier/additionalColumns/{id}', [\App\Http\Controllers\Admin\CourierController::class, 'destroyColumn'])->name('courier.destroyColumn');
    Route::post('courier/categories', [\App\Http\Controllers\Admin\CourierController::class, 'storeNature'])->name('courier.storeNature');
    Route::post('courier/categories/{id}', [\App\Http\Controllers\Admin\CourierController::class, 'editNature'])->name('courier.editNature');
    Route::delete('courier/categories/{id}', [\App\Http\Controllers\Admin\CourierController::class, 'destroyNature'])->name('courier.destroyNature');
    Route::post('courier/agents', [\App\Http\Controllers\Admin\CourierController::class, 'storeAgent'])->name('courier.storeAgent');
    Route::delete('courier/agents/{id}', [\App\Http\Controllers\Admin\CourierController::class, 'destroyAgent'])->name('courier.destroyAgent');
    Route::post('courier/update-selected-services', [\App\Http\Controllers\Admin\CourierController::class, 'updateSelectedServices'])->name('courier.updateSelectedServices');
    Route::resource('courier', \App\Http\Controllers\Admin\CourierController::class);
    Route::delete('courier', [\App\Http\Controllers\Admin\CourierController::class, 'destroy'])->name('courier.destroy');

    
});




