@extends('layouts.app')

@section('content')
<div style="min-height:80vh;display:flex;align-items:center;justify-content:center;padding:24px">
    <div style="width:100%;max-width:420px">

        <div style="text-align:center;margin-bottom:28px">
            <a href="/" class="navbar-brand-custom" style="font-size:28px">
                Li<span>Browse</span>
            </a>
            <div style="font-size:14px;color:var(--text-muted);margin-top:6px">
                Create your student account
            </div>
        </div>

        <div class="form-card">
            <form method="POST" action="/register">
                @csrf

                <div style="margin-bottom:16px">
                    <label class="form-label-custom">Full Name</label>
                    <input type="text" name="name" class="form-input-custom"
                        value="{{ old('name') }}" placeholder="Enter your full name" required autofocus>
                    @error('name')
                        <span style="color:#c0392b;font-size:12px">{{ $message }}</span>
                    @enderror
                </div>

                <div style="margin-bottom:16px">
                    <label class="form-label-custom">Email</label>
                    <input type="email" name="email" class="form-input-custom"
                        value="{{ old('email') }}" placeholder="Enter your email" required>
                    @error('email')
                        <span style="color:#c0392b;font-size:12px">{{ $message }}</span>
                    @enderror
                </div>

                <div style="margin-bottom:16px">
                    <label class="form-label-custom">Password</label>
                    <input type="password" name="password" class="form-input-custom"
                        placeholder="Min. 8 characters" required>
                    @error('password')
                        <span style="color:#c0392b;font-size:12px">{{ $message }}</span>
                    @enderror
                </div>

                <div style="margin-bottom:20px">
                    <label class="form-label-custom">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-input-custom"
                        placeholder="Repeat your password" required>
                </div>

                <button type="submit" class="btn-accent w-100"
                    style="font-size:15px;padding:11px;text-align:center">
                    Create Account
                </button>
            </form>
        </div>

        <div style="text-align:center;margin-top:16px;font-size:13px;color:var(--text-muted)">
            Already have an account?
            <a href="/login" style="color:var(--accent);text-decoration:none;font-weight:500">
                Sign in here
            </a>
        </div>
    </div>
</div>
@endsection