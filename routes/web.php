<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EducationController;

Route::get('/', function () {
    return view('education');
});
Route::get('/education', [EducationController::class, 'index'])->name('education.index');
Route::post('/education', [EducationController::class, 'store'])->name('education.store');
Route::get('/education/{id}', [EducationController::class, 'show'])->name('education.show');
Route::put('/education/{id}', [EducationController::class, 'update'])->name('education.update');
Route::delete('/education/{id}', [EducationController::class, 'destroy'])->name('education.destroy');
