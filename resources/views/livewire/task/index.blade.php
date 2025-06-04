<?php

use App\Models\User;
use App\Models\Task;
use Mary\Traits\Toast;
use App\Enums\RolesEnum;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\Volt\Component;
use App\Enums\TaskStatusEnum;
use App\Enums\TaskPriorityEnum;
use Livewire\Attributes\Title;

new class extends Component {
    use Toast, WithPagination;
    #[Title('Tasks')]
    public $headers;
    public string $search = '';
    public $sortBy = ['column' => 'id', 'direction' => 'desc'];
    public $employee;
    public bool $filterDrawer = false;
    public $selectedEmployee;
    public $selectedStatus;
    public $selectedPriority;

    public $startDate;
    public $endDate;
    public $deadlineDate;

    public function boot(): void
    {
        $this->headers = [['key' => 'id', 'label' => '#', 'class' => 'w-1']];

        if (auth()->user()->hasRole(RolesEnum::ADMIN->value)) {
            $this->headers[] = ['key' => 'user.name', 'label' => 'Employee', 'sortable' => false, 'class' => 'w-1'];
        }

        $this->headers = array_merge($this->headers, [['key' => 'title', 'label' => 'Title'], ['key' => 'status', 'label' => 'Status'], ['key' => 'priority', 'label' => 'Priority'], ['key' => 'created_at', 'label' => 'Assign Date'], ['key' => 'completed_at', 'label' => 'Completed At'], ['key' => 'expires_at', 'label' => 'Deadline']]);
    }

    public function applyFilter()
    {
        $user = auth()->user();

        $query = Task::query()
            ->with('user')
            ->when(!auth()->user()->hasRole(RolesEnum::ADMIN->value), function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->when($this->selectedEmployee, fn($query) => $query->where('user_id', $this->selectedEmployee))
            ->when($this->selectedStatus, fn($query) => $query->where('status', $this->selectedStatus))
            ->when($this->selectedPriority, fn($query) => $query->where('priority', $this->selectedPriority))
            ->when($this->startDate, fn($query) => $query->whereDate('created_at', '>=', $this->startDate))
            ->when($this->endDate, fn($query) => $query->whereDate('created_at', '<=', $this->endDate))
            ->when($this->deadlineDate, fn($query) => $query->whereDate('expires_at', $this->deadlineDate))
            ->search($this->search)
            ->orderBy(...array_values($this->sortBy));

        $this->patients = $query->get();
        $this->filterDrawer = false;
    }

    public function clearFilter()
    {
        $this->reset(['selectedEmployee', 'selectedStatus', 'selectedPriority', 'startDate', 'endDate', 'deadlineDate']);
        $this->filterDrawer = false;
    }

    public function rendering(View $view)
    {
        $view->tasks = Task::when(!auth()->user()->hasRole(RolesEnum::ADMIN->value), function ($q) {
            $q->where('user_id', auth()->id());
        })
            ->when($this->selectedEmployee, fn($query) => $query->where('user_id', $this->selectedEmployee))
            ->when($this->selectedStatus, fn($query) => $query->where('status', $this->selectedStatus))
            ->when($this->selectedPriority, fn($query) => $query->where('priority', $this->selectedPriority))
            ->when($this->startDate, fn($query) => $query->whereDate('created_at', '>=', $this->startDate))
            ->when($this->endDate, fn($query) => $query->whereDate('created_at', '<=', $this->endDate))
            ->when($this->deadlineDate, fn($query) => $query->whereDate('expires_at', $this->deadlineDate))
            ->with('user')
            ->search($this->search)
            ->orderBy(...array_values($this->sortBy))
            ->paginate(10);

        $view->employees = User::role(RolesEnum::EMPLOYEE->value)->get();

        $view->statuses = array_map(
            fn($case) => [
                'id' => $case->value,
                'name' => $case->label(),
            ],
            TaskStatusEnum::cases(),
        );
        $view->priorities = array_map(
            fn($case) => [
                'id' => $case->name,
                'name' => $case->label(),
            ],
            TaskPriorityEnum::cases(),
        );
    }
}; ?>

<div>
    <x-card class="bg-base-200 rounded-2xl">
        <div class="flex flex-col items-start justify-between gap-2 mt-3 mb-5 lg:items-center lg:flex-row">
            <div>
                <h1 class="mb-2 text-2xl font-bold">Tasks</h1>
                <div class="text-sm breadcrumbs">
                    <ul class="flex">
                        <li>
                            <a href="{{ route('admin.index') }}" wire:navigate>Dashboard</a>
                        </li>
                        <li>Tasks</li>
                    </ul>
                </div>
            </div>

            <div class="flex gap-3 justify-end">
                <x-input placeholder="Search ..." icon="o-magnifying-glass" wire:model.live.debounce="search" clearable />

                @role('admin')
                    <x-button icon="o-plus" tooltip="Assign Task" class="inline-flex btn-primary"
                        link="{{ route('admin.task.create') }}" />
                @endrole
                <x-button icon="o-funnel" tooltip="Filter" class="inline-flex btn-primary"
                    wire:click="$toggle('filterDrawer')" />
            </div>
        </div>
        <hr class="mb-5">

        <x-table :headers="$headers" :rows="$tasks" with-pagination :sort-by="$sortBy" class="bg-base-100">
            @scope('cell_title', $task)
                {{ Str::limit($task->title, 40) }}
            @endscope
            @scope('cell_user.name', $task)
                {{ Str::limit($task->user->name, 8) }}
            @endscope
            @scope('cell_status', $task)
                <span class="badge {{ $task->status->color() }}">
                    {{ $task->status->label() }}
                </span>
            @endscope
            @scope('cell_priority', $task)
                <span class="badge {{ $task->priority->color() }}">
                    {{ $task->priority->label() }}
                </span>
            @endscope

            @scope('cell_created_at', $task)
                {{ $task->created_at ? $task->created_at->format('d M Y') : '-' }}
            @endscope
            @scope('cell_completed_at', $task)
                <div class="w-fit">
                    {{ $task->completed_at ? $task->completed_at->format('d M Y h:i A') : '-' }}
                </div>
            @endscope
            @scope('cell_expires_at', $task)
                <div class="w-fit">
                    {{ $task->expires_at ? $task->expires_at->format('d M Y') : 'No Deadline' }}
                </div>
            @endscope
            @scope('actions', $task)
                <div class="flex gap-2 w-fit">
                    @role('admin')
                        <x-button icon="o-pencil" link="{{ route('admin.task.edit', $task->id) }}" />
                    @endrole
                    <x-button icon="o-eye" class="bg-transparent border-none"
                        link="{{ route('admin.task.show', $task->id) }}" />
                </div>
            @endscope

            <x-slot:empty>
                <x-empty icon="o-no-symbol" message="No tasks found" />
            </x-slot>
        </x-table>
    </x-card>

    <x-drawer wire:model="filterDrawer" class="w-11/12 lg:w-1/3" right title="Apply Filters">
        @role('admin')
            <x-choices-offline :options="$employees" placeholder="Select Employee" label="Employee"
                wire:model="selectedEmployee" clearable single searchable />
        @endrole

        <div class="mt-2">
            <x-select :options="$statuses" placeholder="Choose status" label="Status" wire:model="selectedStatus" />
        </div>

        <div class="mt-2">
            <x-select :options="$priorities" placeholder="Choose priority" label="Priority" wire:model="selectedPriority" />
        </div>


        <div class="my-2">
            <x-datetime label="Deadline Date" wire:model="deadlineDate" />
        </div>

        <div class="flex items-center justify-center">
            <div class="border-t border-gray-500 w-full"></div>
            <span class="text-gray-500 px-4">Or</span>
            <div class="border-t border-gray-500 w-full"></div>
        </div>

        <div class="mt-2 grid md:grid-cols-2 gap-3">
            <x-datetime label="Start Date" wire:model="startDate" />
            <x-datetime label="End Date" wire:model="endDate" />
        </div>

        <div class="mt-3 flex justify-end items-center gap-3">
            <x-button label="Clear" wire:click='clearFilter' spinner="clearFilter" />
            <x-button label="Apply" class="btn-primary" wire:click='applyFilter' spinner="applyFilter" />
        </div>
    </x-drawer>
</div>
