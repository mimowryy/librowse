<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Http\Request;

class BorrowController extends Controller {

    // Student: View my borrowed books
    public function myBorrows() {
        $borrows = Borrow::with('book')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($borrow) {
                if ($borrow->isOverdue()) {
                    $borrow->update(['status' => 'overdue']);
                    $borrow->status = 'overdue';
                }
                return $borrow;
            });

        return view('borrows.my-borrows', compact('borrows'));
    }

    // Student: Borrow a book
    public function borrow(Book $book) {
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

    // Student: Return a book
   // Student: Request a return
public function requestReturn(Borrow $borrow) {
    if ($borrow->user_id !== auth()->id()) {
        return back()->with('error', 'Unauthorized action.');
    }

    $borrow->update(['status' => 'pending_return']);

    return back()->with('success', 'Return request submitted! Please bring the book to the librarian.');
}

// Admin: Confirm physical return
public function confirmReturn(Borrow $borrow) {
    $borrow->update([
        'returned_at' => now(),
        'status'      => 'returned',
    ]);

    $borrow->book->increment('available_copies');

    return back()->with('success', 'Book return confirmed for '.$borrow->user->name.'!');
}
}