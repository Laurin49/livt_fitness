<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RevokePermissionFromRoleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkoutController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::resource('/users', UserController::class);
Route::resource('/roles', RoleController::class);
Route::resource('/permissions', PermissionController::class);
Route::delete('/roles/{role}/permissions/{permission}', RevokePermissionFromRoleController::class)
    ->name('roles.permissions.destroy');

Route::middleware(['auth', 'role:admin'])->prefix('/admin')->group(
    function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    }
);

Route::resource('/categories', CategoryController::class)->middleware(['auth']);
Route::resource('/exercises', ExerciseController::class)->middleware(['auth']);
Route::resource('/workouts', WorkoutController::class)->middleware(['auth']);
Route::post('/workouts/{workout}/attach.exercise', [WorkoutController::class, 'attachExercise'])
    ->name('workouts.attach.exercise')
    ->middleware(['auth']);
Route::post('/workouts/{workout}/detach.exercise', [WorkoutController::class, 'detachExercise'])
    ->name('workouts.detach.exercise')
    ->middleware(['auth']);
Route::post('/workouts/{workout}/copy', [WorkoutController::class, 'copy_workout'])
    ->name('workouts.copy')
    ->middleware(['auth']);
Route::put('/workouts/{workout}/update.beschreibung', [WorkoutController::class, 'updateBeschreibung'])
    ->name('workouts.update.beschreibung')
    ->middleware(['auth']);


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
