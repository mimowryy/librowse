@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h3 class="fw-bold">{{ $book->title }}</h3>
                <p class="text-muted">by {{ $book->author }}</p>
                <span class="badge bg-secondary mb-3">{{ $book->category }}</span>
                <p>{{ $book->description ?? 'No description available.' }}</p>
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge {{ $book->isAvailable() ? 'bg-success' : 'bg-danger' }} fs-6">
                        {{ $book->isAvailable() ? 'Available ('.$book->available_copies.' copies)' : 'Not Available' }}
                    </span>
                    @auth
                        @if($book->isBorrowedBy(auth()->id()))
                            <span class="btn btn-secondary disabled">Already Borrowed</span>
                        @elseif($book->isAvailable())
                            <form method="POST" action="/books/{{ $book->id }}/borrow">
                                @csrf
                                <button class="btn btn-primary"
                                    onclick="return confirm('Borrow this book? Due in 7 days.')">
                                    Borrow This Book
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="/login" class="btn btn-primary">Login to Borrow</a>
                    @endauth
                </div>
            </div>
        </div>
        <a href="/" class="btn btn-outline-secondary mt-3">← Back to Library</a>
    </div>
</div>
@endsection