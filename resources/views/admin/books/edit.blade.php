@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="/admin/books" style="color:var(--text-muted);text-decoration:none;font-size:13px">
                    ← Back
                </a>
                <h4 class="section-title mb-0">Edit Book</h4>
            </div>

            <div class="form-card">
                <form method="POST" action="/admin/books/{{ $book->id }}">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label-custom">Title *</label>
                            <input type="text" name="title" class="form-input-custom"
                                value="{{ old('title', $book->title) }}" required>
                            @error('title')
                                <span style="color:#c0392b;font-size:12px">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-custom">Author *</label>
                            <input type="text" name="author" class="form-input-custom"
                                value="{{ old('author', $book->author) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-custom">ISBN *</label>
                            <input type="text" name="isbn" class="form-input-custom"
                                value="{{ old('isbn', $book->isbn) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-custom">Category *</label>
                            <input type="text" name="category" class="form-input-custom"
                                value="{{ old('category', $book->category) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-custom">Number of Copies *</label>
                            <input type="number" name="total_copies" class="form-input-custom"
                                value="{{ old('total_copies', $book->total_copies) }}" min="1" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label-custom">Description</label>
                            <textarea name="description" class="form-input-custom"
                                rows="4">{{ old('description', $book->description) }}</textarea>
                        </div>

                        <div class="col-12 d-flex gap-2 justify-content-end mt-2">
                            <a href="/admin/books" class="btn-ghost-custom">Cancel</a>
                            <button type="submit" class="btn-accent">
                                <i class="bi bi-check-lg me-1"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection