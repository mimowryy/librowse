@extends('layouts.app')

@section('content')
<div style="min-height:80vh;display:flex;align-items:center;justify-content:center;padding:24px">
    <div style="width:100%;max-width:420px">

        <div style="text-align:center;margin-bottom:28px">
            <a href="/" class="navbar-brand-custom" style="font-size:28px">
                Li<span>Browse</span>
            </a>
            <div style="font-size:14px;color:var(--text-muted);margin-top:6px">
                Reset your password
            </div>
        </div>

        <div class="form-card">
            <form method="POST" action="/reset-password">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div style="margin-bottom:16px">
                    <label class="form-label-custom">Email</label>
                    <input type="email" name="email" class="form-input-custom"
                        value="{{ old('email', $request->email) }}"
                        placeholder="Enter your email" required autofocus>
                    @error('email')
                        <span style="color:#c0392b;font-size:12px">{{ $message }}</span>
                    @enderror
                </div>

                <div style="margin-bottom:16px">
                    <label class="form-label-custom">New Password</label>
                    <input type="password" name="password" class="form-input-custom"
                        placeholder="Enter new password" required>
                    @error('password')
                        <span style="color:#c0392b;font-size:12px">{{ $message }}</span>
                    @enderror
                </div>

                <div style="margin-bottom:20px">
                    <label class="form-label-custom">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-input-custom"
                        placeholder="Repeat new password" required>
                </div>

                <button type="submit" class="btn-accent w-100"
                    style="font-size:15px;padding:11px;text-align:center">
                    Reset Password
                </button>
            </form>
        </div>

    </div>
</div>
@endsection