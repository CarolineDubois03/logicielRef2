<?php

use App\Http\Controllers\Admin\AgentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Exports\CouriersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\CourierController;
use App\Http\Controllers\Admin\RecipientController;
use App\Http\Controllers\Admin\CategoryController;



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
    
    
    Route::get('export-couriers', [CourierController::class, 'export'])->name('couriers.export');

    // Profil de l'utilisateur
    Route::get('profile', [UsersController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [UsersController::class, 'edit'])->name('profile.edit');
    Route::put('profile/update/{id}', [UsersController::class, 'update'])->name('profile.update');
    Route::get('profile/change-password', [UsersController::class, 'showChangePasswordForm'])->name('profile.showChangePasswordForm');
    Route::post('profile/change-password', [UsersController::class, 'changePassword'])->name('profile.change-password');
    
    Route::delete('categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::delete('users/{id}', [UsersController::class, 'destroy'])->name('users.destroy');

    Route::post('courier/agents', [CourierController::class, 'storeAgent'])->name('courier.storeAgent');
    Route::delete('courier/agents/{id}', [CourierController::class, 'destroyAgent'])->name('courier.destroyAgent');
    Route::post('courier/update-selected-services', [CourierController::class, 'updateSelectedServices'])->name('courier.updateSelectedServices');
    Route::resource('courier', CourierController::class);
    Route::delete('courier', [CourierController::class, 'destroy'])->name('courier.destroy');
    Route::get('courier/{id}/edit', [CourierController::class, 'edit'])->name('courier.edit');

    Route::get('couriers/settings', [CourierController::class, 'settings'])->name('courier.settings');

    Route::get('recipients/search', [RecipientController::class, 'search'])->name('recipients.search');
    Route::post('recipients/store', [RecipientController::class, 'store'])->name('recipients.store');
    Route::get('users/search', [UsersController::class, 'search'])->name('users.search');
    Route::get('courier/download/{id}', [CourierController::class, 'download'])->name('courier.download');
    
    Route::post('recipients/store', [RecipientController::class, 'store'])->name('recipients.store');
    Route::post('recipients/update/{id}', [RecipientController::class, 'update'])->name('recipients.update');
    Route::put('recipients/{id}', [RecipientController::class, 'update'])->name('admin.recipients.update');

    Route::delete('recipients/{id}', [RecipientController::class, 'destroy'])->name('recipients.destroy');

    Route::resource('categories', CategoryController::class)
    ->except(['show', 'create']);
    Route::resource('users', UsersController::class)->except(['show']);
    Route::put('users/{id}', [UsersController::class, 'update'])->name('users.update'); 

    Route::resource('agents', UsersController::class)->except(['show']);
    Route::post('agents/add', [AgentController::class, 'addAgent'])->name('agents.add');


        
});




