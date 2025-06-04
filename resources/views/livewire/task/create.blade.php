<?php

use App\Models\User;
use App\Models\Task;
use Mary\Traits\Toast;
use App\Enums\RolesEnum;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Models\Notification;
use Livewire\Volt\Component;
use Livewire\Attributes\Title;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;

new class extends Component {
    use Toast;
    #[Title('Assign Task')]
    public $employee;
    public $title;
    public $description;
    public $priority;
    public $deadline;

    public function mount()
    {
        $this->employee = request()->query('employee', null);
    }

    public function store()
    {
        $this->validate([
            'title' => 'required|max:100',
            'employee' => 'required|exists:users,id',
            'description' => 'required|max:1000',
            'deadline' => 'required|date',
            'priority' => 'required|in:low,medium,high',
        ]);

        $task = new Task();
        $task->title = $this->title;
        $task->user_id = $this->employee;
        $task->description = $this->description;
        $task->expires_at = $this->deadline;
        $task->priority = $this->priority;

        $task->save();

        // Notification::create([
        //     'user_id' => $task->user_id,
        //     'title' => 'New Task Assigned',
        //     'message' => "A new task has been assigned to you. Task number: #{$task->id} and deadline {$task->expires_at->format('d/m/Y')}.",
        //     'type' => 'task_created',
        //     'data' => json_encode(['task_id' => $task->id]),
        // ]);

        // $subject = 'New Task Assigned';
        // $body = view('mail.notification.employee.task', [
        //     'subject' => $subject,
        //     'task' => $task,
        // ]);
        // Mail::to($task->user->email)->bcc(config('app.mail.backup.address'))->send(new NotificationMail($subject, $body));

        $this->success('Task assigned', redirectTo: route('admin.task.index'));
    }

    public function rendering(View $view)
    {
        $view->employees = User::role(RolesEnum::EMPLOYEE->value)
            ->get(['id', 'name'])
            ->map(
                fn($user) => [
                    'id' => $user->id,
                    'name' => $user->name,
                ],
            );
    }
}; ?>

<div>
    <div class="flex flex-col items-start justify-between gap-2 mt-3 mb-5 lg:items-center lg:flex-row">
        <div>
            <h1 class="mb-2 text-2xl font-bold">Create Task</h1>
            <div class="text-sm breadcrumbs">
                <ul class="flex">
                    <li>
                        <a href="{{ route('admin.index') }}" wire:navigate>Dashboard</a>
                    </li>

                    <li>
                        <a href="{{ route('admin.task.index') }}">Tasks</a>
                    </li>

                    <li>
                        Create Task
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <hr class="mb-5">

    <x-card class="bg-base-200" separator>
        <div class="grid md:grid-cols-2 gap-3">
            <x-input label="Title" wire:model='title' hint="Max 100 characters" />
            <x-choices-offline :options="$employees" placeholder="Search ..." label="Select Employee" single clearable
                searchable wire:model='employee' />
            <x-choices-offline label="Priority" wire:model="priority" :options="[
                ['id' => 'low', 'name' => 'Low'],
                ['id' => 'medium', 'name' => 'Medium'],
                ['id' => 'high', 'name' => 'High'],
            ]" option-label="name"
                option-value="id" placeholder="Select Priority" single clearable searchable />


            <x-datetime label="Due date" wire:model="deadline" min="{{ now()->toDateString() }}" />

            <div class="col-span-2">
                <x-textarea label="Description" wire:model='description' hint="Max 1000 characters" />
            </div>
        </div>

        <x-slot:actions separator>
            <x-button label="Submit" class="btn-primary" spinner="store" wire:click='store' />
        </x-slot:actions>
    </x-card>
</div>
