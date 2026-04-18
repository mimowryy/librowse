@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="section-title mb-0">Manage Borrows</h4>
            <span class="text-muted-custom" style="font-size:13px">
                {{ $pendingReturns->count() }} pending returns
            </span>
        </div>
        <a href="/admin/dashboard" class="btn-ghost-custom">
            ← Back to Dashboard
        </a>
    </div>

    {{-- Pending Returns --}}
    <h6 class="section-title mb-3">
        <i class="bi bi-hourglass-split me-1" style="color:#e65100"></i>
        Pending Returns
        @if($pendingReturns->count() > 0)
            <span class="badge-overdue ms-2">{{ $pendingReturns->count() }}</span>
        @endif
    </h6>

    <div class="form-card mb-4">
        @if($pendingReturns->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">✅</div>
                <div class="empty-state-title">No pending returns</div>
                <div class="empty-state-subtitle">All good! No students waiting for return confirmation.</div>
            </div>
        @else
            <table class="librowse-table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Book</th>
                        <th>Borrowed</th>
                        <th>Due Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingReturns as $borrow)
                    <tr>
                        <td style="font-weight:500">{{ $borrow->user->name }}</td>
                        <td>{{ $borrow->book->title }}</td>
                        <td>{{ $borrow->borrowed_at->format('M d, Y') }}</td>
                        <td style="color:{{ $borrow->due_date->isPast() ? '#c0392b' : 'var(--text-primary)' }}">
                            {{ $borrow->due_date->format('M d, Y') }}
                            @if($borrow->due_date->isPast())
                                <span class="badge-overdue ms-1">Late</span>
                            @endif
                        </td>
                        <td>
                            <form method="POST" action="/admin/borrows/{{ $borrow->id }}/confirm-return">
                                @csrf
                                <button type="submit" class="btn-accent"
                                    style="font-size:12px;padding:6px 14px;"
                                    onclick="return confirm('Confirm physical return of \'{{ addslashes($borrow->book->title) }}\' from {{ $borrow->user->name }}?')">
                                    <i class="bi bi-check-lg me-1"></i> Confirm Return
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Active Borrows --}}
    <h6 class="section-title mb-3">
        <i class="bi bi-book me-1" style="color:var(--accent)"></i>
        Active Borrows
    </h6>

    <div class="form-card">
        @if($activeBorrows->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">📚</div>
                <div class="empty-state-title">No active borrows</div>
            </div>
        @else
            <table class="librowse-table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Book</th>
                        <th>Borrowed</th>
                        <th>Due Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activeBorrows as $borrow)
                    <tr>
                        <td style="font-weight:500">{{ $borrow->user->name }}</td>
                        <td>{{ $borrow->book->title }}</td>
                        <td>{{ $borrow->borrowed_at->format('M d, Y') }}</td>
                        <td style="color:{{ $borrow->due_date->isPast() ? '#c0392b' : 'var(--text-primary)' }}">
                            {{ $borrow->due_date->format('M d, Y') }}
                        </td>
                        <td>
                            @if($borrow->status === 'overdue')
                                <span class="badge-overdue">Overdue</span>
                            @else
                                <span class="badge-borrowed">Borrowed</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</div>
@endsection