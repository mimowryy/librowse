@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="section-title mb-0">My Borrowed Books</h4>
            <span class="text-muted-custom" style="font-size:13px">
                {{ $borrows->whereIn('status', ['borrowed', 'overdue'])->count() }} active,
                {{ $borrows->where('status', 'pending')->count() }} waiting approval,
                {{ $borrows->where('status', 'pending_return')->count() }} pending return,
                {{ $borrows->where('status', 'overdue')->count() }} overdue
            </span>
        </div>
        <a href="/" class="btn-ghost-custom">
            <i class="bi bi-search me-1"></i> Browse Books
        </a>
    </div>

    @if($borrows->isEmpty())
        <div class="form-card">
            <div class="empty-state">
                <div class="empty-state-icon">📭</div>
                <div class="empty-state-title">No borrowed books yet</div>
                <div class="empty-state-subtitle">Browse the library and borrow your first book!</div>
                <a href="/" class="btn-accent mt-3 d-inline-block">Browse Library</a>
            </div>
        </div>
    @else
        @php
            $active = $borrows->whereIn('status', ['pending', 'borrowed', 'overdue', 'pending_return']);
            $returned = $borrows->whereIn('status', ['returned', 'rejected']);
        @endphp

        {{-- Active, Pending, Overdue & Pending Return --}}
        @if($active->count() > 0)
        <h6 class="section-title mb-3">Currently Borrowed</h6>
        <div class="row g-3 mb-4">
            @foreach($active as $borrow)
            <div class="col-md-6">
                <div class="form-card h-100">
                    <div class="d-flex gap-3">

                        {{-- Cover --}}
                        <div style="width:70px;height:90px;border-radius:8px;overflow:hidden;
                            background:{{ ['#e8f0fe','#fce8e6','#e6f4ea','#fef7e0','#f3e8fd','#e8f5e9'][($borrow->book->id % 6)]}};
                            display:flex;align-items:center;justify-content:center;
                            font-size:28px;flex-shrink:0;">
                            @if($borrow->book->cover_image)
                                <img src="{{ $borrow->book->cover_image }}"
                                    style="width:100%;height:100%;object-fit:cover"
                                    onerror="this.style.display='none'">
                            @else
                                {{ ['📘','📕','📗','📙','📓','📔'][$borrow->book->id % 6] }}
                            @endif
                        </div>

                        {{-- Info --}}
                        <div style="flex:1;min-width:0">
                            <div style="font-size:14px;font-weight:600;color:var(--text-primary);
                                white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $borrow->book->title }}
                            </div>
                            <div style="font-size:12px;color:var(--text-muted);margin-bottom:8px">
                                {{ $borrow->book->author }}
                            </div>

                            <div style="font-size:12px;color:var(--text-muted);margin-bottom:4px">
                                <i class="bi bi-calendar me-1"></i>
                                Requested: {{ $borrow->borrowed_at->format('M d, Y') }}
                            </div>

                            @if($borrow->status !== 'pending')
                            <div style="font-size:12px;margin-bottom:10px;
                                color:{{ $borrow->status === 'overdue' ? '#c0392b' : 'var(--text-muted)' }}">
                                <i class="bi bi-clock me-1"></i>
                                Due: {{ $borrow->due_date->format('M d, Y') }}
                                @if($borrow->status === 'overdue')
                                    <span class="badge-overdue ms-1">Overdue</span>
                                @endif
                            </div>
                            @endif

                            {{-- Action Buttons --}}
                            @if($borrow->status === 'pending')
                                <div style="font-size:12px;padding:6px 14px;background:#e3f2fd;
                                    color:#1565c0;border-radius:8px;display:inline-block">
                                    <i class="bi bi-clock me-1"></i>
                                    Waiting for librarian approval
                                </div>

                            @elseif($borrow->status === 'borrowed' || $borrow->status === 'overdue')
                                <form method="POST" action="/borrows/{{ $borrow->id }}/request-return">
                                    @csrf
                                    <button type="submit" class="btn-accent"
                                        style="font-size:12px;padding:6px 14px;"
                                        onclick="return confirm('Request return for \'{{ addslashes($borrow->book->title) }}\'? Please bring the book to the librarian.')">
                                        <i class="bi bi-arrow-return-left me-1"></i> Request Return
                                    </button>
                                </form>

                            @elseif($borrow->status === 'pending_return')
                                <div style="font-size:12px;padding:6px 14px;background:#fff3e0;
                                    color:#e65100;border-radius:8px;display:inline-block">
                                    <i class="bi bi-hourglass-split me-1"></i>
                                    Pending librarian confirmation
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Borrow History --}}
        @if($returned->count() > 0)
        <h6 class="section-title mb-3">Borrow History</h6>
        <div class="form-card">
            <table class="librowse-table">
                <thead>
                    <tr>
                        <th>Book</th>
                        <th>Author</th>
                        <th>Requested</th>
                        <th>Returned</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($returned as $borrow)
                    <tr>
                        <td style="font-weight:500">{{ $borrow->book->title }}</td>
                        <td>{{ $borrow->book->author }}</td>
                        <td>{{ $borrow->borrowed_at->format('M d, Y') }}</td>
                        <td>
                            @if($borrow->returned_at)
                                {{ $borrow->returned_at->format('M d, Y') }}
                            @else
                                <span style="color:var(--text-muted)">—</span>
                            @endif
                        </td>
                        <td>
                            @if($borrow->status === 'returned')
                                <span class="badge-returned">Returned</span>
                            @elseif($borrow->status === 'rejected')
                                <span class="badge-unavail">Rejected</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

    @endif
</div>
@endsection