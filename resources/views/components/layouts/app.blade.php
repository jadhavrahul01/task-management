<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>
    <link rel="shortcut icon" href="{{ url('backend/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" />
    @yield('cdn')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <x-nav sticky full-width>
        <x-slot:brand>
            <label for="main-drawer" class="mr-3 lg:hidden">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>
            <div class="grid grid-cols-1 lg:grid-cols-3 items-center md:gap-10 gap-2">
                <div class="font-black text-2xl underline decoration-amber-400  decoration-[0.15rem]">TaskMate</div>
            </div>
        </x-slot:brand>

        <x-slot:actions>
            <x-theme-toggle class="w-12 h-12 btn-sm btn-ghost" lightTheme="light" darkTheme="dark" responsive />
            <div class="gap-1.5">
                <div class="tooltip tooltip-bottom" data-tip="Toggle Theme">
                </div>
                @auth
                    <div class="dropdown dropdown-bottom dropdown-end">
                        <label tabindex="0" class="btn btn-ghost rounded-btn px-1.5 hover:bg-base-content/20">
                            <div class="flex items-center gap-2">
                                <div aria-label="Avatar photo" class="avatar placeholder flex justify-center items-center">
                                    <div class="w-8 h-8 rounded-full bg-primary text-primary-content text-xl">
                                        <span>
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <ul tabindex="0" class="z-50 p-2 mt-4 shadow dropdown-content menu bg-base-100 rounded-box w-52"
                            role="menu">
                            <li>
                                @if ($user = auth()->user())
                                    <div class="flex flex-col items-start bg-base-300 cursor-default rounded-md">
                                        <p class="text-sm/none pt-2">
                                            {{ auth()->user()->name }}
                                        </p>
                                        <p class="text-sm/none py-2">
                                            {{ auth()->user()->email }}
                                        </p>
                                    </div>
                                @endif
                            </li>
                            <li class="mt-2">
                                <a href="{{ route('admin.profile') }}" wire:navigate>
                                    My Profile
                                </a>
                            </li>
                            <hr class="my-1 -mx-2 border-base-content/10" />
                            <li>
                                <form action="{{ route('admin.logout') }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to log out?')">
                                    @csrf
                                    <button class="text-error">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth
            </div>
        </x-slot:actions>
    </x-nav>

    <x-main with-nav full-width>
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-200">
            <div class="flex flex-col justify-between h-full">
                <x-menu activate-by-route>
                    <div class="my-1 divider divider-start">
                        <small>
                            Overview
                        </small>
                    </div>
                    <x-menu-item title="Dashboard" icon="fas.home" link="{{ route('admin.index') }}" />
                    <div class="my-1 divider divider-start">
                        <small>
                            Administration
                        </small>
                    </div>
                    @role('admin')
                        <x-menu-item title="Employee" icon="fas.users" link="{{ route('admin.employee.index') }}" />
                    @endrole
                    <x-menu-item title="Task" icon="fas.tasks" link="{{ route('admin.task.index') }}" />

                    <div class="my-1 divider divider-start">
                        <small>
                            Profile
                        </small>
                    </div>
                    <x-menu-item title="Manage" icon="fas.user-gear" link="{{ route('admin.profile') }}" />
                </x-menu>
            </div>
        </x-slot:sidebar>

        <x-slot:content>
            <div class="flex flex-col h-full">
                <div class="flex-grow">
                    {{ $slot }}
                </div>

                <footer class="mt-auto py-4">
                    <div class="flex justify-between items-center text-sm text-base-content/50">
                        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                        <p>Version {{ config('app.version', '1.0.0') }}</p>
                    </div>
                </footer>
            </div>
        </x-slot:content>
    </x-main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    @yield('js')
    <x-toast />
</body>

</html>
