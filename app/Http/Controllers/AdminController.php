<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\User;
use Illuminate\Http\Request;
class AdminController extends Controller {

   public function index() {
    $totalBooks      = Book::count();
    $totalBorrowed = Borrow::whereIn('status', ['borrowed', 'overdue'])->count();
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
public function transactions(Request $request) {
    // Auto-update overdue status
    Borrow::where('status', 'borrowed')
        ->whereDate('due_date', '<', now())
        ->update(['status' => 'overdue']);

    $query = Borrow::with(['user', 'book']);

    if ($request->borrower) {
        $query->whereHas('user', function($q) use ($request) {
            $q->where('name', 'like', '%'.$request->borrower.'%');
        });
    }

    if ($request->status) {
        $query->where('status', $request->status);
    }

    if ($request->date_from) {
        $query->whereDate('borrowed_at', '>=', $request->date_from);
    }

    if ($request->date_to) {
        $query->whereDate('borrowed_at', '<=', $request->date_to);
    }

    $transactions = $query->orderBy('created_at', 'desc')->paginate(15);
    $totalResults = $query->count();

    return view('admin.transactions', compact('transactions', 'totalResults'));
}
}
