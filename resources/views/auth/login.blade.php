@extends('layouts.app')

@section('content')
<div style="min-height:80vh;display:flex;align-items:center;justify-content:center;padding:24px">
    <div style="width:100%;max-width:420px">

        <div style="text-align:center;margin-bottom:28px">
            <a href="/" class="navbar-brand-custom" style="font-size:28px">
                Li<span>Browse</span>
            </a>
            <div style="font-size:14px;color:var(--text-muted);margin-top:6px">
                Sign in to your account
            </div>
        </div>

        <div class="form-card">
            <form method="POST" action="/login">
                @csrf

                <div style="margin-bottom:16px">
                    <label class="form-label-custom">Email</label>
                    <input type="email" name="email" class="form-input-custom"
                        value="{{ old('email') }}" placeholder="Enter your email" required autofocus>
                    @error('email')
                        <span style="color:#c0392b;font-size:12px">{{ $message }}</span>
                    @enderror
                </div>

                <div style="margin-bottom:16px">
                    <div class="d-flex justify-content-between">
                        <label class="form-label-custom">Password</label>
                        @if(Route::has('password.request'))
                            <a href="/forgot-password"
                                style="font-size:12px;color:var(--accent);text-decoration:none">
                                Forgot password?
                            </a>
                        @endif
                    </div>
                    <input type="password" name="password" class="form-input-custom"
                        placeholder="Enter your password" required>
                    @error('password')
                        <span style="color:#c0392b;font-size:12px">{{ $message }}</span>
                    @enderror
                </div>

                <div style="margin-bottom:20px;display:flex;align-items:center;gap:8px">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember" style="font-size:13px;color:var(--text-muted);cursor:pointer">
                        Remember me
                    </label>
                </div>

                <button type="submit" class="btn-accent w-100"
                    style="font-size:15px;padding:11px;text-align:center">
                    Sign In
                </button>
            </form>
        </div>

        <div style="text-align:center;margin-top:16px;font-size:13px;color:var(--text-muted)">
            Don't have an account?
            <a href="/register" style="color:var(--accent);text-decoration:none;font-weight:500">
                Register here
            </a>
        </div>
    </div>
</div>
@endsection