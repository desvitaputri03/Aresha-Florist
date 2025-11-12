<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController as AdminUserController;

Route::prefix('admin')->name('admin.')->group(function () {
    // ...existing admin routes...
    Route::get('users/{user}', [AdminUserController::class, 'show'])->name('users.show');
});
