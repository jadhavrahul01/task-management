<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <link rel="shortcut icon" href="{{ url('backend/favicon.png') }}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class=" ">
    <div class="grid min-h-screen grid-cols-12 overflow-auto">
        <div class="relative hidden bg-base-200 lg:col-span-6 lg:block   ">
            <div class="absolute inset-0 flex items-center justify-center">
                <img src="{{ asset('backend/auth/login-cover.svg') }}"
                    class="object-contain w-full h-full max-w-2xl p-4" alt="Auth Image">
            </div>
        </div>
        <div class="col-span-12 lg:col-span-6">
            <div class="flex items-end justify-end ">
                <div class="tooltip tooltip-left " data-tip="Toggle Theme">
                    <x-theme-toggle class=" btn-sm w-12 h-12 btn-ghost" lightTheme="light" darkTheme="dark" />
                </div>
            </div>
            <div class="flex flex-col items-center h-[90%] justify-center p-8">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>
