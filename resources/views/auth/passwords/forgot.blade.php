@extends('auth.layouts.app')

@section('content')
    <h3 class="mt-12 text-xl font-semibold text-center lg:mt-24">
        Forgot Password
    </h3>
    <h3 class="mt-2 mb-4 text-sm text-center text-base-content/70">
        Forgot your password? No problem. Just let us know your email address </br>
        and we will email you a password reset link that will allow you to
        choose a new one.
    </h3>

    @if (session('status'))
        <div class="flex justify-center my-3">
            <x-alert icon="o-check" class="alert-success md:w-2/3">
                {{ session('status') }}
            </x-alert>
        </div>
    @endif
    <div class="mx-auto mt-3 md:w-96">
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-4">
                <x-input label="E-mail" name="email" icon="o-envelope" value="{{ old('email') }}" />
                @error('email')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-5 text-end">
                <a href="{{ route('login') }}">Back to Login</a>
            </div>
            <hr>
            <div class="mt-4">
                <x-button label="Send Reset Link" type="submit" icon="o-paper-airplane" class="w-full btn-primary" />
            </div>
        </form>
    </div>
@endsection
