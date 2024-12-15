<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\studentController;

Route::get('/students',[studentController::class, 'index'])->name('students.index');


Route::post('/students', [studentController::class, 'store'])->name('students.store');

Route::get('/students/{id}', [studentController::class, 'show'])->name('students.show');


Route::put('/students/{id}', [studentController::class, 'update'])->name('students.update');

Route::delete('/students/{id}', [studentController::class, 'destroy'])->name('students.destroy');



