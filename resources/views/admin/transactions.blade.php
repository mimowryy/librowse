@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="section-title mb-0">Transaction Log</h4>
            <span class="text-muted-custom" style="font-size:13px">
                {{ $transactions->total() }} transactions found
            </span>
        </div>
        <a href="/admin/dashboard" class="btn-ghost-custom">← Dashboard</a>
    </div>

    {{-- Filters --}}
    <div class="form-card mb-4">
        <form method="GET" action="/admin/transactions">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label-custom">Borrower Name</label>
                    <input type="text" name="borrower" class="form-input-custom"
                        placeholder="Search borrower..."
                        value="{{ request('borrower') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label-custom">Status</label>
                    <select name="status" class="form-input-custom">
                        <option value="">All Status</option>
                        <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                        <option value="pending_return" {{ request('status') == 'pending_return' ? 'selected' : '' }}>Pending Return</option>
                        <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Returned</option>
                        <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label-custom">Date From</label>
                    <input type="date" name="date_from" class="form-input-custom"
                        value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label-custom">Date To</label>
                    <input type="date" name="date_to" class="form-input-custom"
                        value="{{ request('date_to') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn-accent w-100">
                        <i class="bi bi-filter me-1"></i> Filter
                    </button>
                    <a href="/admin/transactions" class="btn-ghost-custom w-100 text-center">
                        Clear
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- Active Filters Display --}}
    @if(request('borrower') || request('status') || request('date_from') || request('date_to'))
    <div class="d-flex gap-2 mb-3 flex-wrap">
        <span style="font-size:13px;color:var(--text-muted)">Active filters:</span>
        @if(request('borrower'))
            <span style="font-size:12px;background:var(--bg-secondary);color:var(--accent);
                padding:3px 10px;border-radius:10px;border:1px solid var(--card-border)">
                Borrower: {{ request('borrower') }}
            </span>
        @endif
        @if(request('status'))
            <span style="font-size:12px;background:var(--bg-secondary);color:var(--accent);
                padding:3px 10px;border-radius:10px;border:1px solid var(--card-border)">
                Status: {{ ucfirst(str_replace('_', ' ', request('status'))) }}
            </span>
        @endif
        @if(request('date_from'))
            <span style="font-size:12px;background:var(--bg-secondary);color:var(--accent);
                padding:3px 10px;border-radius:10px;border:1px solid var(--card-border)">
                From: {{ request('date_from') }}
            </span>
        @endif
        @if(request('date_to'))
            <span style="font-size:12px;background:var(--bg-secondary);color:var(--accent);
                padding:3px 10px;border-radius:10px;border:1px solid var(--card-border)">
                To: {{ request('date_to') }}
            </span>
        @endif
    </div>
    @endif

    {{-- Transaction Table --}}
    <div class="form-card">
        @if($transactions->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">📭</div>
                <div class="empty-state-title">No transactions found</div>
                <div class="empty-state-subtitle">Try adjusting your filters</div>
            </div>
        @else
            <table class="librowse-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Borrower</th>
                        <th>Book</th>
                        <th>Borrowed Date</th>
                        <th>Due Date</th>
                        <th>Returned Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $t)
                    <tr>
                        <td style="color:var(--text-muted);font-size:12px">{{ $t->id }}</td>
                        <td>
                            <a href="/admin/students/{{ $t->user->id }}"
                                style="color:var(--accent);text-decoration:none;font-weight:500">
                                {{ $t->user->name }}
                            </a>
                            <div style="font-size:11px;color:var(--text-muted)">{{ $t->user->email }}</div>
                        </td>
                        <td>
                            <div style="font-weight:500">{{ $t->book->title }}</div>
                            <div style="font-size:11px;color:var(--text-muted)">{{ $t->book->author }}</div>
                        </td>
                        <td style="font-size:13px">{{ $t->borrowed_at->format('M d, Y') }}</td>
                        <td style="font-size:13px;
                            color:{{ $t->status === 'overdue' ? '#c0392b' : 'var(--text-primary)' }}">
                            {{ $t->due_date->format('M d, Y') }}
                        </td>
                        <td style="font-size:13px;color:var(--text-muted)">
                            {{ $t->returned_at ? $t->returned_at->format('M d, Y') : '—' }}
                        </td>
                        <td>
                            @if($t->status === 'returned')
                                <span class="badge-returned">Returned</span>
                            @elseif($t->status === 'overdue')
                                <span class="badge-overdue">Overdue</span>
                            @elseif($t->status === 'pending_return')
                                <span class="badge-overdue">Pending Return</span>
                            @else
                                <span class="badge-borrowed">Borrowed</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">{{ $transactions->links() }}</div>
        @endif
    </div>
</div>
@endsection