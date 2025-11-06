 @extends('layouts.noauth')

@section('title', 'Sign In')

@section('form')
   <div class="flex justify-center items-center p-8 lg:p-10 order-2 lg:order-1">
    <div class="kt-card max-w-[370px] w-full">
    <form action="{{ route('signup.store') }}" class="kt-card-content flex flex-col gap-5 p-10" id="sign_up_form" method="POST">
    @csrf

    <div class="text-center mb-2.5">
        <h3 class="text-lg font-medium text-mono leading-none mb-2.5">
            Sign up
        </h3>
        <div class="flex items-center justify-center">
            <span class="text-sm text-secondary-foreground me-1.5">
                Already have an Account?
            </span>
            <a class="text-sm link" href="{{ url('/login') }}">
                Sign In
            </a>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-2.5">
        <a class="kt-btn kt-btn-outline justify-center" href="#">
            <img alt="" class="size-3.5 shrink-0" src="{{ asset('assets/media/brand-logos/google.svg') }}">
            Use Google
        </a>
        <a class="kt-btn kt-btn-outline justify-center" href="#">
            <img alt="" class="size-3.5 shrink-0 dark:hidden" src="{{ asset('assets/media/brand-logos/apple-black.svg') }}">
            <img alt="" class="size-3.5 shrink-0 light:hidden" src="{{ asset('assets/media/brand-logos/apple-white.svg') }}">
            Use Apple
        </a>
    </div>

    <div class="flex items-center gap-2">
        <span class="border-t border-border w-full"></span>
        <span class="text-xs text-secondary-foreground uppercase">or</span>
        <span class="border-t border-border w-full"></span>
    </div>

    <!-- Email -->
    <div class="flex flex-col gap-1">
        <label class="kt-form-label text-mono">Email</label>
        <input class="kt-input" name="email" placeholder="email@email.com" type="email" value="{{ old('email') }}" required>
        @error('email')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <!-- Password -->
    <div class="flex flex-col gap-1">
        <label class="kt-form-label font-normal text-mono">Password</label>
        <div class="kt-input" data-kt-toggle-password="true">
            <input name="password" placeholder="Enter Password" type="password" required>
            <button class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-icon bg-transparent! -me-1.5" data-kt-toggle-password-trigger="true" type="button">
                <span class="kt-toggle-password-active:hidden">
                    <i class="ki-filled ki-eye text-muted-foreground"></i>
                </span>
                <span class="hidden kt-toggle-password-active:block">
                    <i class="ki-filled ki-eye-slash text-muted-foreground"></i>
                </span>
            </button>
        </div>
        @error('password')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div class="flex flex-col gap-1">
        <label class="kt-form-label font-normal text-mono">Confirm Password</label>
        <div class="kt-input" data-kt-toggle-password="true">
            <input name="password_confirmation" placeholder="Re-enter Password" type="password" required>
            <button class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-icon bg-transparent! -me-1.5" data-kt-toggle-password-trigger="true" type="button">
                <span class="kt-toggle-password-active:hidden">
                    <i class="ki-filled ki-eye text-muted-foreground"></i>
                </span>
                <span class="hidden kt-toggle-password-active:block">
                    <i class="ki-filled ki-eye-slash text-muted-foreground"></i>
                </span>
            </button>
        </div>
    </div>

    <!-- Checkbox -->
    <label class="kt-checkbox-group">
        <input class="kt-checkbox kt-checkbox-sm" name="terms" type="checkbox" value="1" required>
        <span class="kt-checkbox-label">
            I accept
            <a class="text-sm link" href="#">Terms & Conditions</a>
        </span>
    </label>

    <!-- Submit Button -->
    <button type="submit" class="kt-btn kt-btn-primary flex justify-center grow">
        Sign up
    </button>
</form>

    </div>
   </div>
    @endsection
