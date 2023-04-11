<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

Route::get('/home/{id?}', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/crate/employee', [HomeController::class, 'store'])->name('employee.store');
Route::post('/update/employees', [HomeController::class, 'updateEmployee'])->name('employees.update');

Route::get('/show/tasks/{id?}/{employee?}/{status?}', [App\Http\Controllers\HomeController::class, 'viewTasks'])->name('task.show');
Route::post('/crate/task', [App\Http\Controllers\HomeController::class, 'storeTasks'])->name('task.store');
Route::post('/update/task', [App\Http\Controllers\HomeController::class, 'updateTasks'])->name('task.update');
Route::get('/assign/task/{id}', [App\Http\Controllers\HomeController::class, 'assignTask'])->name('task.assign');
Route::post('/update/assignee', [App\Http\Controllers\HomeController::class, 'assignTaskSubmit'])->name('assign.update');
Route::get('/status/task/{id}', [App\Http\Controllers\HomeController::class, 'taskStatus'])->name('task.status');
Route::post('/update/status', [App\Http\Controllers\HomeController::class, 'statusTaskSubmit'])->name('status.update');



// Route::get('/edit/task/{$id}', [App\Http\Controllers\HomeController::class, 'editTask'])->name('task.edit');

Route::post('/start/task', [App\Http\Controllers\HomeController::class, 'startTask'])->name('task.start');
Route::post('/complete/task', [App\Http\Controllers\HomeController::class, 'completeTask'])->name('task.complete');



