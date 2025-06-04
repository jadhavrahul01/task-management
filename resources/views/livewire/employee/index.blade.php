<?php
use Livewire\Volt\Component;
use Livewire\Attributes\{Layout};
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;
use Mary\Traits\Toast;

new class extends Component {
    use WithPagination, Toast;
    #[Title('All Employees')]
    public $headers;
    #[Url]
    public string $search = '';
    public $name, $email, $password;
    public $confirmationModal = false;
    public $user_id;

    public bool $employeeModal = false;

    public $sortBy = ['column' => 'name', 'direction' => 'asc'];
    // boot
    public function boot(): void
    {
        $this->headers = [['key' => 'id', 'label' => '#', 'class' => 'w-1'], ['key' => 'name', 'label' => 'Name'], ['key' => 'email', 'label' => 'Email'], ['key' => 'created_at', 'label' => 'Date']];
    }

    public function rendering(View $view): void
    {
        $view->users = User::role('employee')
            ->orderBy(...array_values($this->sortBy))
            ->where('name', 'like', "%$this->search%")
            ->paginate(20);
    }

    public function addEmployee()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ]);

        $user = User::where('email', $this->email)->first();
        $user->assignRole('employee');

        $this->reset(['name', 'email', 'password']);

        $this->employeeModal = false;
        $this->success('Employee added successfully');
    }
};
?>

<div>
    <div class="flex flex-col items-start justify-between gap-2 mt-3 mb-5 lg:items-center lg:flex-row">
        <div>
            <h1 class="text-2xl font-bold">
                All Employees
            </h1>
            <div class="text-sm breadcrumbs">
                <ul class="flex">
                    <li>
                        <a href="{{ route('admin.index') }}" wire:navigate>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        All Employees
                    </li>
                </ul>
            </div>
        </div>
        <div class="flex gap-3">
            <x-button label="Add Employee" icon="o-user-plus" class="inline-flex btn-primary" responsive
                @click="$wire.employeeModal = true" />
            <x-input placeholder="Search ..." icon="o-magnifying-glass" wire:model.live.debounce="search" />
        </div>
    </div>

    <x-modal wire:model="employeeModal" class="backdrop-blur" title="Add Employee">
        <div class="mt-3">
            <x-form wire:submit="addEmployee">
                <x-input label="Name" inline wire:model='name' />
                <x-input label="Email" type="email" inline wire:model='email' />
                <x-input label="Password" type="password" inline wire:model='password' />

                <x-slot:actions>
                    <x-button label="Cancel" @click="$wire.employeeModal = false" />
                    <x-button label="Confirm" type="submit" class="btn-primary" spinner="addEmployee" />
                </x-slot:actions>
            </x-form>
        </div>
    </x-modal>

    <hr class="mb-5">
    <x-table :headers="$headers" :rows="$users" with-pagination :sort-by="$sortBy">
        @scope('cell_created_at', $user)
            {{ $user->created_at->format('d M Y') }}
        @endscope
        <x-slot:empty>
            <x-empty icon="o-no-symbol" message="No Employee found" />
        </x-slot>
    </x-table>
</div>
