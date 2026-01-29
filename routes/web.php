<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/polls', [App\Http\Controllers\PollController::class, 'index'])->name('polls.index');
    Route::get('/polls/{id}', [App\Http\Controllers\PollController::class, 'show'])->name('polls.show');
    Route::post('/polls/vote', [App\Http\Controllers\PollController::class, 'vote'])->name('polls.vote');
    
    // Temporary route to view registered users
    Route::get('/users', function() {
        $users = App\Models\User::all();
        return view('users.index', compact('users'));
    })->name('users.index');
});

require __DIR__.'/auth.php';
