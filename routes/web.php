<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\PhotoController;
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

Route::get('/cars', [CarController::class, 'index']);
Route::get('/cars/list', [CarController::class, 'getCars'])->name('cars.list');
Route::get('public/cars/{filename}', [PhotoController::class, 'get']);

Route::get('cars/import', [CarController::class, 'importForm'])->name('importForm')->middleware(['auth']);
Route::post('/cars/import', [CarController::class, 'import'])->name('import')->middleware(['auth']);
Route::post('/cars/addPhoto', [CarController::class, 'addPhoto'])->name('addPhoto')->middleware(['auth']);
Route::resource('cars', CarController::class);



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
