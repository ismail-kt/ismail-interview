<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/show/employees', [App\Http\Controllers\HomeController::class, 'viewEployees'])->name('employees.show');
Route::get('/edit/employees/{$id}', [App\Http\Controllers\HomeController::class, 'editEmployee'])->name('employees.edit');
Route::post('/update/employees', [App\Http\Controllers\HomeController::class, 'updateEmployee'])->name('employees.update');
Route::post('/crate/employee', [App\Http\Controllers\HomeController::class, 'store'])->name('employee.store');

Route::get('/show/tasks', [App\Http\Controllers\HomeController::class, 'viewTasks'])->name('task.store');
Route::get('/edit/task/{$id}', [App\Http\Controllers\HomeController::class, 'editTask'])->name('task.edit');
Route::post('/update/task', [App\Http\Controllers\HomeController::class, 'updateTasks'])->name('task.update');
Route::post('/crate/task', [App\Http\Controllers\HomeController::class, 'storeTasks'])->name('task.store');

Route::post('/assign/task', [App\Http\Controllers\HomeController::class, 'assignTask'])->name('task.assign');
Route::post('/reassign/task', [App\Http\Controllers\HomeController::class, 'assigneeChange'])->name('task.assign.change');
Route::post('/start/task', [App\Http\Controllers\HomeController::class, 'startTask'])->name('task.start');
Route::post('/complete/task', [App\Http\Controllers\HomeController::class, 'completeTask'])->name('task.complete');



