@extends('layouts.noauth')

@section('title', 'Sign In')

@section('form')
<div class="flex justify-center items-center p-8 lg:p-10 order-2 lg:order-1">
    <div class="kt-card max-w-[370px] w-full">
        <form action="{{ route('login.store') }}" method="POST" class="kt-card-content flex flex-col gap-5 p-10">
            @csrf
            <div class="text-center mb-2.5">
                <h3 class="text-lg font-medium text-mono mb-2.5">Sign in</h3>
                <div class="flex items-center justify-center font-medium">
                    <span class="text-sm text-secondary-foreground me-1.5">Need an account?</span>
                    <a href="{{ route('signup.store') }}" class="text-sm link">Sign up</a>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2.5">
                <a class="kt-btn kt-btn-outline justify-center" href="#">
                    <img alt="" class="size-3.5 shrink-0" src="{{ asset('assets/media/brand-logos/google.svg') }}"/>
                    Use Google
                </a>
                <a class="kt-btn kt-btn-outline justify-center" href="#">
                    <img alt="" class="size-3.5 shrink-0 dark:hidden" src="{{ asset('assets/media/brand-logos/apple-black.svg') }}"/>
                    <img alt="" class="size-3.5 shrink-0 light:hidden" src="{{ asset('assets/media/brand-logos/apple-white.svg') }}"/>
                    Use Apple
                </a>
            </div>

            <div class="flex items-center gap-2">
                <span class="border-t border-border w-full"></span>
                <span class="text-xs text-muted-foreground font-medium uppercase">Or</span>
                <span class="border-t border-border w-full"></span>
            </div>

            <div class="flex flex-col gap-1">
                <label class="kt-form-label font-normal text-mono">Email</label>
                <input type="email" name="email" class="kt-input" placeholder="email@email.com" required/>
            </div>

            <div class="flex flex-col gap-1">
                <label class="kt-form-label font-normal text-mono">Password</label>
                <div class="kt-input" data-kt-toggle-password="true">
                    <input type="password" name="password" placeholder="Enter Password" required/>
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

            <label class="kt-label">
                <input class="kt-checkbox kt-checkbox-sm" name="remember" type="checkbox" value="1"/>
                <span class="kt-checkbox-label">Remember me</span>
            </label>

            <button class="kt-btn kt-btn-primary flex justify-center grow" type="submit">Sign In</button>
        </form>
    </div>
</div>
@endsection

 
