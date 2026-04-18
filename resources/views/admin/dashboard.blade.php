@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="section-title mb-0">Admin Dashboard</h4>
            <span class="text-muted-custom" style="font-size:13px">Welcome back, {{ auth()->user()->name }}!</span>
        </div>
        <a href="/admin/books/create" class="btn-accent">
            <i class="bi bi-plus-lg me-1"></i> Add New Book
        </a>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="admin-stat">
                <div class="admin-stat-number">{{ $totalBooks }}</div>
                <div class="admin-stat-label">Total Books</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="admin-stat">
                <div class="admin-stat-number" style="color:#1565c0">{{ $totalBorrowed }}</div>
                <div class="admin-stat-label">Currently Borrowed</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="admin-stat">
                <div class="admin-stat-number" style="color:#e65100">{{ $totalOverdue }}</div>
                <div class="admin-stat-label">Overdue</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="admin-stat">
                <div class="admin-stat-number" style="color:#0a7a4a">{{ $totalStudents }}</div>
                <div class="admin-stat-label">Students</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="admin-stat">
                <div class="admin-stat-number" style="color:#e65100">{{ $pendingReturns }}</div>
                <div class="admin-stat-label">Pending Returns</div>
            </div>
        </div>
    </div>

    {{-- Recent Borrows --}}
    <div class="form-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="section-title mb-0">Recent Borrow Activity</h6>
            <div class="d-flex gap-3">
                <a href="/admin/books" style="font-size:13px;color:var(--accent);text-decoration:none">
                    Manage Books →
                </a>
                <a href="/admin/borrows" style="font-size:13px;color:#e65100;text-decoration:none">
                    Pending Returns →
                </a>
            </div>
        </div>

        @if($recentBorrows->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">📭</div>
                <div class="empty-state-title">No borrow activity yet</div>
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
                    @foreach($recentBorrows as $borrow)
                    <tr>
                        <td>{{ $borrow->user->name }}</td>
                        <td>{{ $borrow->book->title }}</td>
                        <td>{{ $borrow->borrowed_at->format('M d, Y') }}</td>
                        <td>{{ $borrow->due_date->format('M d, Y') }}</td>
                        <td>
                            @if($borrow->status === 'returned')
                                <span class="badge-returned">Returned</span>
                            @elseif($borrow->status === 'overdue')
                                <span class="badge-overdue">Overdue</span>
                            @elseif($borrow->status === 'pending_return')
                                <span class="badge-overdue">Pending Return</span>
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