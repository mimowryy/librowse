@extends('layouts.app')

@section('content')
<div style="min-height:80vh;display:flex;align-items:center;justify-content:center;padding:24px">
    <div style="width:100%;max-width:420px">

        <div style="text-align:center;margin-bottom:28px">
            <a href="/" class="navbar-brand-custom" style="font-size:28px">
                Li<span>Browse</span>
            </a>
            <div style="font-size:14px;color:var(--text-muted);margin-top:6px">
                Forgot your password?
            </div>
        </div>

        <div class="form-card">
            <div style="font-size:13px;color:var(--text-muted);margin-bottom:20px">
                No problem! Enter your email and we'll send you a reset link.
            </div>

            @if(session('status'))
                <div class="alert alert-success mb-3">
                    <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
                </div>
            @endif

            <form method="POST" action="/forgot-password">
                @csrf
                <div style="margin-bottom:16px">
                    <label class="form-label-custom">Email</label>
                    <input type="email" name="email" class="form-input-custom"
                        value="{{ old('email') }}"
                        placeholder="Enter your email" required autofocus>
                    @error('email')
                        <span style="color:#c0392b;font-size:12px">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-accent w-100"
                    style="font-size:15px;padding:11px;text-align:center">
                    Send Reset Link
                </button>
            </form>
        </div>

        <div style="text-align:center;margin-top:16px;font-size:13px;color:var(--text-muted)">
            Remember your password?
            <a href="/login" style="color:var(--accent);text-decoration:none;font-weight:500">
                Sign in here
            </a>
        </div>
    </div>
</div>
@endsection