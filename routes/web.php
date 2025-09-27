<?php

use App\Http\Controllers\ProfileController;
// 🔽 追加
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventJoinController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;


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
  // 🔽 追加
  Route::get('/events/search', [EventController::class, 'search'])->name('events.search');
  Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
  Route::resource('events', EventController::class);
  Route::post('/events/{event}/join', [EventJoinController::class, 'store'])->name('events.join');
  Route::delete('/events/{event}/join', [EventJoinController::class, 'destroy'])->name('events.unjoin');
    Route::resource('events.comments', CommentController::class);
      Route::post('/follow/{user}', [FollowController::class, 'store'])->name('follow.store');
  Route::delete('/follow/{user}', [FollowController::class, 'destroy'])->name('follow.destroy');


});

require __DIR__ . '/auth.php';