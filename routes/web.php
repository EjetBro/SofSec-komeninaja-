<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\IdeasController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;

Route::resource('idea', IdeaController::class);

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return redirect('/register');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/profile', function () {
    return view('profile');
})->middleware('auth');
Route::post('/user/profile-picture', [UserController::class, 'updateProfilePicture'])->name('user.updateProfilePicture');

Route::middleware('auth')->group(function () {
    Route::post('/ideas', [IdeaController::class, 'store'])->name('idea.create');
    Route::get('/ideas', [IdeasController::class, 'ideas'])->name('idea.index');
    Route::get('/ideas/{idea}', [IdeaController::class, 'show'])->name('idea.show');
    Route::get('/ideas/{idea}/edit', [IdeaController::class, 'edit'])->name('idea.edit');
    Route::put('/ideas/{idea}', [IdeaController::class, 'update'])->name('idea.update');
    Route::delete('/ideas/{idea}', [IdeaController::class, 'destroy'])->name('idea.destroy');
    Route::post('/ideas/{idea}/comments', [CommentController::class, 'store'])->name('idea.comments.store');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

require __DIR__.'/auth.php';

Route::fallback(function () {
    abort(404);
});

Route::post('/ideas/{idea}/like', [UserController::class, 'likeIdea'])->name('idea.like');

Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
Route::post('/admin/users/{user}/ban', [UserController::class, 'ban'])->name('admin.users.ban');
Route::post('/admin/users/{user}/unban', [UserController::class, 'unban'])->name('admin.users.unban');
Route::post('admin/users/{user}/make-admin', [UserController::class, 'makeAdmin'])->name('admin.users.makeAdmin');
Route::post('admin/users/{user}/remove-admin', [UserController::class, 'removeAdmin'])->name('admin.users.removeAdmin');

