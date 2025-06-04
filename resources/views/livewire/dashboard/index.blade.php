<?php

use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\Attributes\Title;

new class extends Component {
    use Toast;
    #[Title('Dashboard')]
    public $user;
    public $headers;
    public $revenue;
    public $employees;
    public $tasks;
    public $all_employees;
    public $selectedTab = 'employees-tab';

    public function boot(): void
    {
        $this->headers = [['key' => 'id', 'label' => '#', 'class' => 'w-1'], ['key' => 'name', 'label' => 'Name'], ['key' => 'email', 'label' => 'Email'], ['key' => 'created_at', 'label' => 'Joined Date']];
    }

    public function mount()
    {
        $this->user = auth()->user();
        $this->employees = User::role('employee')->count();
        $this->all_employees = User::role('employee')->latest()->take(10)->get();
        $this->tasks = Task::where('user_id', $this->user->id)->count();
        $this->refreshData();
    }

    public function refreshData(): void
    {
        $this->all_employees = User::role('employee')->latest()->take(10)->get();
    }
}; ?>

<div>
    <x-card title="Welcome back, {{ $user->name }}!" subtitle="Here's what's happening with your business today."
        class="bg-base-200" shadow />

    @role('admin')
        <div class="flex flex-wrap items-center justify-center gap-2 mt-5 md:flex-nowrap">
            <x-stat title="Total Employees" value="{{ $employees }}" icon="fas.users" class="bg-base-200"
                color="text-[#00d390]" />
        </div>
    @endrole
    @role('employee')
        <div class="flex flex-wrap items-center justify-center bg-base-200 gap-2 pe-3 mt-5 md:flex-nowrap">
            <x-stat title="Total Tasks" value="{{ $tasks }}" icon="fas.tasks" class="bg-base-200"
                color="text-[#00d390]" />
            <x-button href="{{ route('admin.task.index') }}" class="btn btn-primary">View All Tasks</x-button>
        </div>
    @endrole
</div>
