<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\PenggunaController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('[$dashboard]/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');

// Route untuk Admin
Route::middleware('role:Admin') -> get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');


// Route untuk User
Route::middleware('role:User') -> get('/user/dashboard', [App\Http\Controllers\UserController::class, 'index'])->name('user.dashboard');

// Route Hitung
Route::middleware('role:Admin') -> get('/admin/dashboard', [App\Http\Controllers\AdministratorController::class, 'hitung'])->name('admin.dashboard');
Route::middleware('role:User') -> get('/user/dashboard', [App\Http\Controllers\PenggunaController::class, 'hitung1'])->name('user.dashboard');

// ==============================
// ==== Route Akses Data KTP ====
// ==============================

// Route untuk Admin
// Route::middleware('role:Admin')->get('/ektp', [App\Http\Controllers\AdministratorController::class, 'lihatktp'])->name('read.ektp');
Route::middleware('role:Admin')->get('/admin/users/activity', [App\Http\Controllers\AdministratorController::class, 'activity'])->name('user.activity');

// --- CRUD ---
Route::middleware('role:Admin')->get('/ektp/create', [App\Http\Controllers\AdministratorController::class, 'create'])->name('create.ektp');
Route::middleware('role:Admin')->post('/ektp/create/save', [App\Http\Controllers\AdministratorController::class, 'store'])->name('post.ktp');
Route::middleware('role:Admin')->get('/ektp/delete/{id}', [App\Http\Controllers\AdministratorController::class, 'destroy'])->name('delete.ktp');
Route::middleware('role:Admin')->get('/ektp/edit/{id}', [App\Http\Controllers\AdministratorController::class, 'edit'])->name('edit.ktp');
Route::middleware('role:Admin')->get('/ektp/show/{id}', [App\Http\Controllers\AdministratorController::class, 'show'])->name('show.ktp');
Route::middleware('role:Admin')->post('/ektp/update/{id}', [App\Http\Controllers\AdministratorController::class, 'update'])->name('update.ktp');
Route::middleware('role:Admin')->post('/ektp/create}', [App\Http\Controllers\PhotoController::class, 'store'])->name('upload.foto');

// Route untuk User
Route::get('/ektp', [App\Http\Controllers\PenggunaController::class, 'lihatktp']);
Route::get('/ektp?search=', [App\Http\Controllers\PenggunaController::class, 'searchktp'])->name('search.ktp');


// ==================================
// ==== Route Akses Manage Users ====
// ==================================

// Route untuk Admin
Route::middleware('role:Admin')->resource('/admin/users', AdministratorController::class);
Route::middleware('role:Admin') -> get('/admin/profile', [App\Http\Controllers\AdministratorController::class, 'Profile'])->name('admin.profile');
// --- CRUD ---
Route::middleware('role:Admin')->get('/user/create', [App\Http\Controllers\PenggunaController::class, 'create'])->name('create.user');
Route::middleware('role:Admin')->post('/user/create/save', [App\Http\Controllers\PenggunaController::class, 'store'])->name('post.user');
Route::middleware('role:Admin')->get('/user/delete/{id}', [App\Http\Controllers\PenggunaController::class, 'destroy'])->name('delete.user');
Route::middleware('role:Admin')->get('/user/edit/{id}', [App\Http\Controllers\PenggunaController::class, 'edit'])->name('edit.user');
Route::middleware('role:Admin')->post('/user/update/{id}', [App\Http\Controllers\PenggunaController::class, 'update'])->name('update.user');

// Route untuk User
Route::middleware('role:User')->get('/user/profile', [App\Http\Controllers\PenggunaController::class, 'profile']);

// ==================================
// ==== Route Ekspor dan Import  ====
// ==================================

Route::get('/ektp/export', [App\Http\Controllers\AdministratorController::class, 'ktpexport'])->name('export.ktp');
Route::middleware('role:Admin')->get('/ektp/import', [App\Http\Controllers\AdministratorController::class, 'ktpimport'])->name('import.ktp');
Route::middleware('role:Admin')->post('/ektp/import/save', [App\Http\Controllers\AdministratorController::class, 'import'])->name('import.save');