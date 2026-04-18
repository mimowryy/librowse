@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="section-title mb-0">Manage Books</h4>
            <span class="text-muted-custom" style="font-size:13px">{{ $books->total() }} books total</span>
        </div>
        <a href="/admin/books/create" class="btn-accent">
            <i class="bi bi-plus-lg me-1"></i> Add New Book
        </a>
    </div>

    <div class="form-card">
        @if($books->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">📚</div>
                <div class="empty-state-title">No books yet</div>
                <div class="empty-state-subtitle">Start by adding your first book</div>
            </div>
        @else
            <table class="librowse-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Copies</th>
                        <th>Available</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $book)
                    <tr>
                        <td style="font-weight:500">{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>
                            <span class="book-category">{{ $book->category }}</span>
                        </td>
                        <td>{{ $book->total_copies }}</td>
                        <td>
                            @if($book->isAvailable())
                                <span class="badge-avail">{{ $book->available_copies }}</span>
                            @else
                                <span class="badge-unavail">0</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="/admin/books/{{ $book->id }}/edit"
                                    style="font-size:12px;padding:5px 12px;border:1px solid var(--card-border);
                                    border-radius:6px;color:var(--accent);text-decoration:none;background:transparent;">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form method="POST" action="/admin/books/{{ $book->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        style="font-size:12px;padding:5px 12px;border:1px solid #ffeaea;
                                        border-radius:6px;color:#c0392b;background:#ffeaea;cursor:pointer;"
                                        onclick="return confirm('Delete \'{{ addslashes($book->title) }}\'?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">{{ $books->links() }}</div>
        @endif
    </div>
</div>
@endsection