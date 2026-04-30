@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="section-title mb-0">Manage Students</h4>
            <span class="text-muted-custom" style="font-size:13px">
                {{ $students->total() }} students registered
            </span>
        </div>
        <a href="/admin/dashboard" class="btn-ghost-custom">← Dashboard</a>
    </div>

    {{-- Search --}}
    <form method="GET" action="/admin/students" class="mb-4">
        <div style="display:flex;gap:8px;max-width:460px">
            <input type="text" name="search" class="form-input-custom"
                placeholder="Search by name or email..."
                value="{{ request('search') }}">
            <button type="submit" class="btn-accent" style="white-space:nowrap">
                <i class="bi bi-search me-1"></i> Search
            </button>
        </div>
    </form>

    <div class="form-card">
        @if($students->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">👥</div>
                <div class="empty-state-title">No students found</div>
                <div class="empty-state-subtitle">No students have registered yet</div>
            </div>
        @else
            <table class="librowse-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Registered</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr>
                        <td style="font-weight:500">{{ $student->name }}</td>
                        <td style="color:var(--text-muted)">{{ $student->email }}</td>
                        <td style="color:var(--text-muted)">
                            {{ $student->created_at->format('M d, Y') }}
                        </td>
                        <td>
                            @if($student->is_active)
                                <span class="badge-avail">Active</span>
                            @else
                                <span class="badge-unavail">Deactivated</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="/admin/students/{{ $student->id }}"
                                    style="font-size:12px;padding:5px 12px;border:1px solid var(--card-border);
                                    border-radius:6px;color:var(--accent);text-decoration:none;">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <form method="POST" action="/admin/students/{{ $student->id }}/toggle">
                                    @csrf
                                    <button type="submit"
                                        style="font-size:12px;padding:5px 12px;cursor:pointer;border-radius:6px;
                                        border:1px solid {{ $student->is_active ? '#ffeaea' : '#e6f9f0' }};
                                        color:{{ $student->is_active ? '#c0392b' : '#0a7a4a' }};
                                        background:{{ $student->is_active ? '#ffeaea' : '#e6f9f0' }};"
                                        onclick="return confirm('{{ $student->is_active ? 'Deactivate' : 'Activate' }} {{ $student->name }}?')">
                                        {{ $student->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">{{ $students->links() }}</div>
        @endif
    </div>
</div>
@endsection