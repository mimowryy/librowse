<?php
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Public routes (no login needed)
Route::get('/', [BookController::class, 'index'])->name('home');
Route::get('/books', [BookController::class, 'index'])->name('books');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

// Student routes
Route::middleware('auth')->group(function () {
    Route::get('/my-borrows', [BorrowController::class, 'myBorrows'])->name('my.borrows');
    Route::post('/books/{book}/borrow', [BorrowController::class, 'borrow'])->name('books.borrow');
    Route::post('/borrows/{borrow}/request-return', [BorrowController::class, 'requestReturn'])->name('borrows.request-return');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/books', [AdminController::class, 'books'])->name('books.index');
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    Route::get('/borrows', [AdminController::class, 'borrows'])->name('borrows.index');
    Route::post('/borrows/{borrow}/confirm-return', [BorrowController::class, 'confirmReturn'])->name('borrows.confirm-return');
});

require __DIR__.'/auth.php';
