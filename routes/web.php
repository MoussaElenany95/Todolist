<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Models\Task;
use Illuminate\Support\Facades\Route;



Route::middleware('guest')->group(function () {
   Route::get('/',function (){
       return redirect()->route('login');
   })->name('home');
});

Route::middleware(['auth', 'verified'])->group(function(){
    route::get('/dashboard',[TaskController::class,'index'])->name('dashboard');
    Route::resource('tasks',TaskController::class)->except(['index','show'])->names('tasks');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
