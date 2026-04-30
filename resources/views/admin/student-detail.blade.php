@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="/admin/students" style="font-size:13px;color:var(--text-muted);text-decoration:none">
            ← Back to Students
        </a>
        <h4 class="section-title mb-0">Student Details</h4>
    </div>

    <div class="row g-4">

        {{-- Student Info --}}
        <div class="col-md-4">
            <div class="form-card text-center">
                <div style="width:72px;height:72px;border-radius:50%;background:var(--accent);
                    display:flex;align-items:center;justify-content:center;
                    font-size:28px;font-weight:700;color:#fff;margin:0 auto 14px;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div style="font-size:17px;font-weight:600;color:var(--text-primary)">
                    {{ $user->name }}
                </div>
                <div style="font-size:13px;color:var(--text-muted);margin-bottom:14px">
                    {{ $user->email }}
                </div>
                @if($user->is_active)
                    <span class="badge-avail">Active account</span>
                @else
                    <span class="badge-unavail">Deactivated account</span>
                @endif

                <hr style="border-color:var(--card-border);margin:16px 0">

                <div style="font-size:13px;color:var(--text-muted);margin-bottom:8px">
                    Registered: {{ $user->created_at->format('M d, Y') }}
                </div>
                <div style="font-size:13px;color:var(--text-muted);margin-bottom:16px">
                    Total borrows: {{ $borrows->count() }}
                </div>

                <form method="POST" action="/admin/students/{{ $user->id }}/toggle">
                    @csrf
                    <button type="submit" class="btn-accent w-100"
                        style="background:{{ $user->is_active ? '#c0392b' : 'var(--accent)' }};"
                        onclick="return confirm('{{ $user->is_active ? 'Deactivate' : 'Activate' }} this student?')">
                        {{ $user->is_active ? 'Deactivate Student' : 'Activate Student' }}
                    </button>
                </form>
            </div>
        </div>

        {{-- Borrow History --}}
        <div class="col-md-8">
            <div class="form-card">
                <h6 class="section-title mb-3">Borrow History</h6>

                @if($borrows->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">📭</div>
                        <div class="empty-state-title">No borrow history</div>
                        <div class="empty-state-subtitle">This student hasn't borrowed any books yet</div>
                    </div>
                @else
                    <table class="librowse-table">
                        <thead>
                            <tr>
                                <th>Book</th>
                                <th>Borrowed</th>
                                <th>Due</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($borrows as $borrow)
                            <tr>
                                <td style="font-weight:500">{{ $borrow->book->title }}</td>
                                <td>{{ $borrow->borrowed_at->format('M d, Y') }}</td>
                                <td style="color:{{ $borrow->status === 'overdue' ? '#c0392b' : 'var(--text-muted)' }}">
                                    {{ $borrow->due_date->format('M d, Y') }}
                                </td>
                                <td>
                                    @if($borrow->status === 'returned')
                                        <span class="badge-returned">Returned</span>
                                    @elseif($borrow->status === 'overdue')
                                        <span class="badge-overdue">Overdue</span>
                                    @elseif($borrow->status === 'pending_return')
                                        <span class="badge-overdue">Pending return</span>
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
    </div>
</div>
@endsection