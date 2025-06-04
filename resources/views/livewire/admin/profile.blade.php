<?php

use App\Models\User;
use Mary\Traits\Toast;
use App\Enums\RolesEnum;
use Illuminate\View\View;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;

new class extends Component {
    use WithFileUploads, Toast;

    #[Title('Edit Profile')]
    #[Url]
    public $name;
    public $email;
    public $phone_no;
    public $password;
    public $user;
    public $config = ['aspectRatio' => 1];

    public function mount()
    {
        $this->user = User::findOrFail(auth()->id());
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone_no = $this->user->phone_no; 
    }

    public function generate_password()
    {
        $this->password = Str::random(rand(8, 16));
    }

    public function save(): void
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $this->user->id,
            'phone_no' => 'nullable|max_digits:10|unique:users,phone_no,' . $this->user->id,
            'password' => 'nullable|min:8',
        ]);

        $this->user->name = $this->name;
        $this->user->email = $this->email;
        $this->user->phone_no = $this->phone_no;

        if ($this->password) {
            $this->user->password = \Hash::make($this->password);
        }

        $this->user->save();
        $this->success('Profile updated successfully.');
    }
};
?>

@section('cdn')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" />
@endsection

<div>
    <div class="text-sm breadcrumbs">
        <h1 class="mb-2 text-2xl font-bold">Edit Profile</h1>
        <ul>
            <li>
                <a href="{{ route('admin.index') }}" wire:navigate>
                    Dashboard
                </a>
            </li>

            <li>
                Edit Profile
            </li>
        </ul>
    </div>

    <div class="grid grid-cols-1 gap-6 mt-6">
        <x-form wire:submit="save">
            <div class="grid grid-cols-2 gap-2">
                <div class="flex justify-between gap-8">
                    <div class="w-full">
                        <x-input label="Name" wire:model="name" />
                        <x-input label="Email" wire:model="email" :readonly="!$user->hasRole(RolesEnum::ADMIN->value)" />
                        <x-input label="Phone" wire:model="phone_no" />
                        <x-password label="Password" wire:model="password" right clearable
                            hint="Leave blank to keep current password">
                            <x-slot:append>
                                <x-button icon="fas.random" class="btn-primary" wire:click="generate_password"
                                    tooltip-left="Generate Password" />
                            </x-slot:append>
                        </x-password>
                    </div>
                </div>
            </div>

            <x-slot:actions>
                <div class="flex justify-end w-full">
                    <x-button label="Update" class="btn-primary" type="submit" spinner="save" />
                </div>
            </x-slot:actions>
        </x-form>
    </div>
</div>
