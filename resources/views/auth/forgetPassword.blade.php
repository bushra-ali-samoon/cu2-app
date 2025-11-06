@extends('layouts.noauth')

@section('title', 'Forgot Password')

@section('form')
<div class="flex justify-center items-center p-8 lg:p-10 order-2 lg:order-1">
    <div class="kt-card max-w-[370px] w-full">
        <form method="POST" action="{{ route('password.email') }}" class="kt-card-content flex flex-col gap-5 p-10">
            @csrf
            <div class="text-center mb-2.5">
                <h3 class="text-lg font-medium text-mono">Forgot Password</h3>
                <span class="text-sm text-secondary-foreground">Enter your email to receive reset link</span>
            </div>

            @if (session('status'))
                <div class="text-green-500 text-xs mb-2">{{ session('status') }}</div>
            @endif

            <div class="flex flex-col gap-1">
                <label class="kt-form-label font-normal text-mono">Email</label>
                <input name="email" type="email" placeholder="email@email.com"
                       class="kt-input @error('email') is-invalid @enderror" required>
                @error('email')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <button class="kt-btn kt-btn-primary flex justify-center grow" type="submit">
                Send Reset Link
            </button>
        </form>
    </div>
</div>
@endsection
 
