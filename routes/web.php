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
    
    // Admin Routes - Must be before wildcard routes
    Route::get('/admin', [App\Http\Controllers\PollController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/polls/create', [App\Http\Controllers\PollController::class, 'create'])->name('polls.create');
    Route::post('/polls', [App\Http\Controllers\PollController::class, 'store'])->name('polls.store');

    Route::get('/polls', [App\Http\Controllers\PollController::class, 'index'])->name('polls.index');
    Route::get('/polls/{id}', [App\Http\Controllers\PollController::class, 'show'])->name('polls.show');
    Route::post('/polls/vote', [App\Http\Controllers\PollController::class, 'vote'])->name('polls.vote');
    
    // Temporary route to view registered users
    Route::get('/users', function() {
        $users = App\Models\User::all();
        return view('users.index', compact('users'));
    })->name('users.index');

    Route::get('/polls/{id}/results', [App\Http\Controllers\PollController::class, 'getResults'])->name('polls.results');
    
    Route::get('/polls/{id}/admin', [App\Http\Controllers\PollController::class, 'adminView'])->name('polls.admin');
    Route::post('/polls/{id}/release', [App\Http\Controllers\PollController::class, 'releaseIp'])->name('polls.release');
});

require __DIR__.'/auth.php';
