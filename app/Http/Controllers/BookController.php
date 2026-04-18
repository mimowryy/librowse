<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request) {
    $query = Book::query();

    if ($request->search) {
        $query->where('title', 'like', '%'.$request->search.'%')
              ->orWhere('author', 'like', '%'.$request->search.'%')
              ->orWhere('category', 'like', '%'.$request->search.'%');
    }

    if ($request->category) {
        $query->where('category', $request->category);
    }

    $books = $query->paginate(12);
    $categories = Book::select('category')->distinct()->pluck('category');

    return view('books.index', compact('books', 'categories'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
    return view('admin.books.create');
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
    $request->validate([
        'title'         => 'required|string|max:255',
        'author'        => 'required|string|max:255',
        'isbn'          => 'required|unique:books',
        'category'      => 'required|string',
        'description'   => 'nullable|string',
        'total_copies'  => 'required|integer|min:1',
    ]);

    $data = $request->all();
    $data['available_copies'] = $request->total_copies;

    Book::create($data);

    return redirect('/admin/books')->with('success', 'Book added successfully!');
}

    /**
     * Display the specified resource.
     */
   public function show(Book $book) {
    return view('books.show', compact('book'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book) {
    return view('admin.books.edit', compact('book'));
}

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Book $book) {
    $request->validate([
        'title'        => 'required|string|max:255',
        'author'       => 'required|string|max:255',
        'category'     => 'required|string',
        'cover_image'  => 'nullable|url',
    ]);

    $book->update($request->all());

    return redirect('/admin/books')->with('success', 'Book updated successfully!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
