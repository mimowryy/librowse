<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Borrow;
use Illuminate\Http\Request;

class UserController extends Controller {

    public function index(Request $request) {
        $query = User::where('role', 'student');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%');
            });
        }

        $students = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.students', compact('students'));
    }

    public function toggleActive(User $user) {
        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'activated' : 'deactivated';
        return back()->with('success', 'Student '.$user->name.' has been '.$status.'.');
    }
    public function borrow(Book $book) {
    if (!auth()->user()->is_active) {
        return back()->with('error', 'Your account has been deactivated. Please contact the librarian.');
    }

    if ($book->isBorrowedBy(auth()->id())) {
        return back()->with('error', 'You already borrowed this book!');
    }

    if (!$book->isAvailable()) {
        return back()->with('error', 'No copies available right now.');
    }

    Borrow::create([
        'user_id'     => auth()->id(),
        'book_id'     => $book->id,
        'borrowed_at' => now(),
        'due_date'    => now()->addDays(7),
        'status'      => 'borrowed',
    ]);

    $book->decrement('available_copies');

    return back()->with('success', 'You borrowed "'.$book->title.'"! Due in 7 days.');
}

    public function show(User $user) {
        $borrows = Borrow::with('book')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.student-detail', compact('user', 'borrows'));
    }
}