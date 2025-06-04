<?php

use App\Models\Task;
use App\Models\User;
use Mary\Traits\Toast;
use App\Enums\RolesEnum;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Volt\Component;
use App\Enums\TaskStatusEnum;
use App\Enums\TaskPriorityEnum;
use Livewire\Attributes\Title;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;

new class extends Component {
    use Toast;
    #[Title('Task Details')]
    public $task;
    public $deadline;
    public $selectedStatus;
    public bool $statusConfrimation = false;
    public bool $extendDeadlineModal = false;

    public function mount($id)
    {
        $this->task = Task::when(!auth()->user()->hasRole(RolesEnum::ADMIN->value), function ($q) {
            $q->where('user_id', auth()->id());
        })->findOrFail($id);

        $this->deadline = optional($this->task->expires_at)->format('Y-m-d');
    }

    public function update_status(bool $confirmStatus = false)
    {
        $this->validate(
            [
                'selectedStatus' => 'required',
            ],
            [
                'selectedStatus.required' => 'Please select one status to update',
            ],
        );

        if ($this->selectedStatus === $this->task->status) {
            $this->error('Status is already set to ' . ucfirst(str_replace('_', ' ', $this->selectedStatus)) . '.');
            return;
        }

        switch ($this->selectedStatus) {
            case TaskStatusEnum::IN_PROGRESS->value:
                if (!$confirmStatus) {
                    $this->statusConfrimation = true;
                    return;
                }

                $this->task->status = $this->selectedStatus;
                $this->task->save();
                $this->success('Task status updated to ' . TaskStatusEnum::tryFrom($this->selectedStatus)?->label() . '.');
                break;

            case TaskStatusEnum::COMPLETED->value:
                if (!$confirmStatus) {
                    $this->statusConfrimation = true;
                    return;
                }

                $this->task->status = $this->selectedStatus;

                if ($this->selectedStatus == TaskStatusEnum::COMPLETED->value) {
                    $this->task->completed_at = now();
                }

                $this->task->save();

                $this->success('Task status updated to ' . TaskStatusEnum::tryFrom($this->selectedStatus)?->label() . '.');
                break;

            default:
                $this->error('Something went wrong.');
                break;
        }

        $subject = 'Task Status Updated';
        $body = view('mail.notification.employee.task-status', [
            'subject' => $subject,
            'task' => $this->task,
        ]);
        $admin = User::role(RolesEnum::ADMIN->value)->first();
        Mail::to($admin->email)->bcc(config('app.mail.backup.address'))->send(new NotificationMail($subject, $body));

        // $this->success('Task status updated successfully and mail sent to admin.');

        $this->reset(['selectedStatus']);
        $this->statusConfrimation = false;
    }

    public function extend_deadline()
    {
        $this->validate([
            'deadline' => 'required|date|after:today',
        ]);

        $this->task->expires_at = $this->deadline;
        $this->task->save();

        $this->extendDeadlineModal = false;
        $this->success('Task deadline updated.');

        // $subject = 'Task Deadline Updated';
        // $body = view('mail.notification.employee.task-deadline', [
        //     'subject' => $subject,
        //     'task' => $this->task,
        // ]);

        // Mail::to($this->task->user->email)
        //     ->bcc(config('app.mail.backup.address'))
        //     ->send(new NotificationMail($subject, $body));
    }

    public function rendering(View $view)
    {
        $currentStatus = $this->task->status->value ?? null;

        $view->statuses = collect(TaskStatusEnum::cases())
            ->filter(function ($status) use ($currentStatus) {
                if ($currentStatus === TaskStatusEnum::IN_PROGRESS->value) {
                    $disabled = $status->value !== TaskStatusEnum::COMPLETED->value;
                }
                return true;
            })
            ->map(function ($status) use ($currentStatus) {
                $disabled = false;

                if ($currentStatus === TaskStatusEnum::PENDING->value) {
                    $disabled = $status->value !== TaskStatusEnum::IN_PROGRESS->value;
                } elseif ($currentStatus === TaskStatusEnum::IN_PROGRESS->value) {
                    $disabled = $status->value !== TaskStatusEnum::COMPLETED->value;
                } elseif ($currentStatus === TaskStatusEnum::COMPLETED->value) {
                    $disabled = true;
                } else {
                    $disabled = true;
                }

                return [
                    'id' => $status->value,
                    'name' => $status->label(),
                    'disabled' => $disabled,
                ];
            })
            ->values()
            ->toArray();
    }
}; ?>

<div>
    <div class="flex flex-col items-start justify-between gap-2 mt-3 mb-5 lg:items-center lg:flex-row">
        <div>
            <h1 class="mb-2 text-2xl font-bold">Task #{{ $task->id }}</h1>
            <div class="text-sm breadcrumbs">
                <ul class="flex">
                    <li>
                        <a href="{{ route('admin.index') }}" wire:navigate>Dashboard</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.task.index') }}">Tasks</a>
                    </li>
                    <li>
                        Task #{{ $task->id }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <hr class="mb-5">

    <div class="flex justify-between md:flex-nowrap flex-wrap gap-2">
        <x-card class="bg-base-200 md:w-2/3 w-full h-fit">
            <div class="flex justify-between items-center">
                <div class="flex gap-2 items-center">
                    <h2 class="font-bold text-xl">Task Details</h2>

                    <x-badge value="{{ $task->status->label() }}" class="badge {{ $task->status->color() }}" />
                </div>

                @role(RolesEnum::EMPLOYEE->value)
                    <x-group wire:model.live="selectedStatus" :options="$statuses" class="[&:checked]:!btn-primary"
                        wire:click="update_status" />

                    {{-- <x-button icon="fas.edit" class="btn-primary" tooltip-left="Update Status"
                        @click="$wire.updateStatus = true" /> --}}
                @endrole

                @role(RolesEnum::ADMIN->value)
                    <x-button icon="fas.clock" class="btn-primary" tooltip-left="Extend Deadline"
                        @click="$wire.extendDeadlineModal = true" />
                @endrole
            </div>

            <x-card class="mt-3">
                <h3 class="font-bold text-xl">{{ $task->title }}</h3>

                <p class="mt-2">
                    Assigned On:
                    <span class="text-primary">{{ $task->created_at->format('D, d M Y, h:i A') }}</span>
                </p>
                <p>
                    Deadline:
                    @if ($task->expires_at)
                        <span class="text-{{ $task->expires_at > now() ? 'success' : 'error' }}">
                            {{ $task->expires_at->format('D, d M Y, h:i A') }}
                        </span>
                    @else
                        <span class="text-warning">
                            No Deadline
                        </span>
                    @endif
                </p>
                <div class="mt-3">
                    <h3>Description:</h3>
                    {{ $task->description }}
                </div>
            </x-card>
        </x-card>

        @role(RolesEnum::EMPLOYEE->value)
            <x-modal wire:model="statusConfrimation" title="Update Status" class="backdrop-blur">
                <p>Are you sure you want to change status to
                    {{ $selectedStatus ? TaskStatusEnum::tryFrom($selectedStatus)?->label() : '' }}?</p>

                <x-slot:actions>
                    <x-button label="Cancel" @click="$wire.statusConfrimation = false" />
                    <x-button label="Update" class="btn-primary" wire:click="update_status(true)" spinner="update_status" />
                </x-slot:actions>
            </x-modal>
        @endrole

        @role(RolesEnum::ADMIN->value)
            <x-modal wire:model="extendDeadlineModal" title="Extend Task Deadline" class="backdrop-blur">
                <x-datetime label="Deadline" wire:model="deadline" />

                <x-slot:actions>
                    <x-button label="Cancel" @click="$wire.extendDeadlineModal = false" />
                    <x-button label="Update" class="btn-primary" wire:click='extend_deadline' spinner="extend_deadline" />
                </x-slot:actions>
            </x-modal>
        @endrole
    </div>
</div>
