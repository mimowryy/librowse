<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\User;

class AdminController extends Controller {

   public function index() {
    $totalBooks      = Book::count();
    $totalBorrowed   = Borrow::where('status', 'borrowed')->count();
    $totalOverdue    = Borrow::where('status', 'overdue')->count();
    $totalStudents   = User::where('role', 'student')->count();
    $pendingReturns  = Borrow::where('status', 'pending_return')->count();
    $recentBorrows   = Borrow::with(['user', 'book'])
                        ->orderBy('created_at', 'desc')
                        ->take(8)
                        ->get();

    return view('admin.dashboard', compact(
        'totalBooks', 'totalBorrowed',
        'totalOverdue', 'totalStudents',
        'pendingReturns', 'recentBorrows'
    ));
}

    public function books() {
        $books = Book::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.books.index', compact('books'));
    }

    public function borrows() {
    $pendingReturns = Borrow::with(['user', 'book'])
                        ->where('status', 'pending_return')
                        ->orderBy('created_at', 'desc')
                        ->get();

    $activeBorrows = Borrow::with(['user', 'book'])
                        ->whereIn('status', ['borrowed', 'overdue'])
                        ->orderBy('created_at', 'desc')
                        ->get();

    return view('admin.borrows', compact('pendingReturns', 'activeBorrows'));
}
}
