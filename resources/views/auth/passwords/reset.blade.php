@extends('auth.layouts.app')

@section('content')
    <h3 class="mt-12 text-xl font-semibold text-center lg:mt-24">
        Reset Password
    </h3>
    <h3 class="mt-2 text-sm text-center text-base-content/70">
        Seamless Access, Secure Connection.
        <br>
        Your Way to a Personalized Experience.
    </h3>

    <div class="mx-auto mt-10 md:w-96">
        @if (session('status'))
            <x-alert icon="o-check" class="alert-success">
                {{ session('status') }}
            </x-alert>
        @endif
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="mb-4">
                <x-input label="E-mail" value="{{ $email }}" readonly name="email" icon="o-envelope" />
                {{-- <input type="email" name="email" value="{{ $email }}" readonly
                class="w-full p-2 bg-gray-200 border rounded cursor-not-allowed"> --}}
                @error('email')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <x-password label="Password" name="password" />
                @error('password')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <x-password label="Confirm Password" name="password_confirmation" />
                @error('password_confirmation')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>
            {{-- <button type="submit" class="w-full p-2 text-white bg-blue-600 rounded">Reset Password</button> --}}
            <div class="mb-5 text-end">
                <a href="{{ route('login') }}">Go to Login</a>
            </div>
            <hr>
            <div class="mt-4">
                <x-button label="Reset Password" type="submit" icon="o-paper-airplane" class="w-full btn-primary" />
            </div>
        </form>
    </div>
@endsection
