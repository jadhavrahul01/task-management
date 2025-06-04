<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    use Toast;
    #[Layout('components.layouts.empty')]
    #[Title('Login')]
    #[Rule('required|email')]
    public string $email = '';

    #[Rule('required')]
    public string $password = '';

    public function mount()
    {
        // It is logged in
        if (auth()->user()) {
            $this->success('You are already logged in.', redirectTo: route('admin.index'));
        }
    }

    public function login()
    {
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt($credentials)) {
            request()->session()->regenerate();

            $user = auth()->user();
            if ($user->hasAnyRole(['admin', 'employee'])) {
                $intended = session('url.intended', route('admin.index'));
                $this->success('You are logged in.', redirectTo: $intended);
            } else {
                auth()->logout();
                $this->addError('email', 'You do not have permission to access this area.');
            }
        } else {
            $this->addError('email', 'The provided credentials do not match our records.');
        }
    }
};
?>
<div>
    <h3 class="text-xl font-semibold text-center mt-10">
        Login
    </h3>
    <h3 class="mt-2 text-sm text-center text-base-content/70">
        Seamless Access, Secure Connection.
        <br>
        Your Way to a Personalized Experience.
    </h3>
    <div class="mx-auto mt-10 md:w-96">
        <x-form wire:submit="login">
            <x-input label="E-mail" wire:model="email" icon="o-envelope" />
            <x-password label="Password" wire:model="password" icon="fas.lock" right />
            <a class="text-end" href="{{ route('password.request') }}">Forgot Password</a>
            <x-slot:actions class="justify-center">
                <x-button label="Login" type="submit" icon="o-paper-airplane" class="w-full btn-primary"
                    spinner="login" />
            </x-slot:actions>
        </x-form>
    </div>
</div>
