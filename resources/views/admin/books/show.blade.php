@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <a href="/" style="font-size:13px;color:var(--text-muted);text-decoration:none;
                display:inline-block;margin-bottom:20px">
                ← Back to Library
            </a>

            <div class="form-card">
                <div class="row g-4">
                    {{-- Cover --}}
                    <div class="col-md-3 text-center">
                        <div style="width:100%;aspect-ratio:2/3;border-radius:10px;overflow:hidden;
                            background:{{ ['#e8f0fe','#fce8e6','#e6f4ea','#fef7e0','#f3e8fd','#e8f5e9'][($book->id % 6)]}};
                            display:flex;align-items:center;justify-content:center;font-size:56px;">
                            @if($book->cover_image)
                                <img src="{{ $book->cover_image }}"
                                    style="width:100%;height:100%;object-fit:cover"
                                    onerror="this.style.display='none'">
                            @else
                                {{ ['📘','📕','📗','📙','📓','📔'][$book->id % 6] }}
                            @endif
                        </div>
                    </div>

                    {{-- Details --}}
                    <div class="col-md-9">
                        <div style="margin-bottom:6px">
                            <span class="book-category">{{ $book->category }}</span>
                        </div>
                        <h3 style="font-size:24px;font-weight:700;color:var(--text-primary);margin-bottom:4px">
                            {{ $book->title }}
                        </h3>
                        <p style="font-size:15px;color:var(--text-muted);margin-bottom:16px">
                            by {{ $book->author }}
                        </p>

                        <div style="font-size:13px;color:var(--text-muted);margin-bottom:6px">
                            <i class="bi bi-upc me-1"></i> ISBN: {{ $book->isbn }}
                        </div>
                        <div style="font-size:13px;color:var(--text-muted);margin-bottom:16px">
                            <i class="bi bi-stack me-1"></i>
                            {{ $book->total_copies }} total copies —
                            @if($book->isAvailable())
                                <span style="color:#0a7a4a;font-weight:500">
                                    {{ $book->available_copies }} available
                                </span>
                            @else
                                <span style="color:#c0392b;font-weight:500">None available</span>
                            @endif
                        </div>

                        @if($book->description)
                        <div style="font-size:14px;color:var(--text-primary);line-height:1.7;
                            padding:16px;background:var(--bg-secondary);border-radius:10px;margin-bottom:20px">
                            {{ $book->description }}
                        </div>
                        @endif

                        {{-- Availability badge --}}
                        <div style="margin-bottom:20px">
                            @if($book->isAvailable())
                                <span class="badge-avail" style="font-size:13px;padding:6px 14px">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Available ({{ $book->available_copies }} copies)
                                </span>
                            @else
                                <span class="badge-unavail" style="font-size:13px;padding:6px 14px">
                                    <i class="bi bi-x-circle me-1"></i> Not Available
                                </span>
                            @endif
                        </div>

                        {{-- Borrow Button --}}
                        @auth
                            @if($book->isBorrowedBy(auth()->id()))
                                <div style="font-size:14px;color:var(--text-muted)">
                                    <i class="bi bi-info-circle me-1"></i>
                                    You already borrowed this book.
                                    <a href="/my-borrows" style="color:var(--accent)">View in My Books →</a>
                                </div>
                            @elseif($book->isAvailable())
                                <form method="POST" action="/books/{{ $book->id }}/borrow">
                                    @csrf
                                    <button type="submit" class="btn-accent"
                                        style="font-size:15px;padding:10px 28px;"
                                        onclick="return confirm('Borrow \'{{ addslashes($book->title) }}\'? Due in 7 days.')">
                                        <i class="bi bi-book me-2"></i> Borrow This Book
                                    </button>
                                </form>
                                <div style="font-size:12px;color:var(--text-muted);margin-top:8px">
                                    <i class="bi bi-info-circle me-1"></i> Due date: {{ now()->addDays(7)->format('M d, Y') }}
                                </div>
                            @else
                                <button class="btn-ghost-custom" disabled style="opacity:0.5;cursor:not-allowed">
                                    No copies available
                                </button>
                            @endif
                        @else
                            <a href="/login" class="btn-accent" style="font-size:15px;padding:10px 28px;">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Login to Borrow
                            </a>
                            <div style="font-size:12px;color:var(--text-muted);margin-top:8px">
                                You need to be logged in to borrow books.
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection