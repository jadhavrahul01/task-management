<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Task;
use Mary\Traits\Toast;
use App\Enums\RolesEnum;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Livewire\Volt\Component;
use Livewire\Attributes\Title;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;

new class extends Component {
    use Toast;
    #[Title('Edit Task')]
    public $task;
    public $employee;
    public $title;
    public $description;
    public $deadline;
    public $priority;

    public function mount($id)
    {
        $this->task = Task::findOrFail($id);
        $this->title = $this->task->title;
        $this->description = $this->task->description;
        $this->priority = $this->task->priority->value;
        $this->deadline = Carbon::parse($this->task->expires_at)->format('Y-m-d');
        $this->employee = $this->task->user_id;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|max:100',
            'employee' => 'required|exists:users,id',
            'description' => 'required|max:1000',
            'deadline' => 'required|date',
            'priority' => 'required|in:low,medium,high',
        ]);

        $oldEmployee = $this->task->user_id;
        $this->task->title = $this->title;
        $this->task->user_id = $this->employee;
        $this->task->description = $this->description;
        $this->task->priority = $this->priority;
        $this->task->expires_at = $this->deadline;
        $this->task->save();

        // if ($this->employee != $oldEmployee) {
        //     $subject = 'New Task Assigned';
        //     $body = view('mail.notification.employee.task', [
        //         'subject' => $subject,
        //         'task' => $this->task,
        //     ]);
        // } else {
        //     $subject = 'Task Updated';
        //     $body = view('mail.notification.employee.task-update', [
        //         'subject' => $subject,
        //         'task' => $this->task,
        //     ]);
        // }

        // Mail::to($this->task->user->email)
        //     ->bcc(config('app.mail.backup.address'))
        //     ->send(new NotificationMail($subject, $body));

        $this->success('Task updated', redirectTo: route('admin.task.index'));
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
            <h1 class="mb-2 text-2xl font-bold">Edit Task</h1>
            <div class="text-sm breadcrumbs">
                <ul class="flex">
                    <li>
                        <a href="{{ route('admin.index') }}" wire:navigate>Dashboard</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.task.index') }}">Tasks</a>
                    </li>
                    <li>
                        Edit Task
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

            <x-datetime label="Deadline date" min="{{ now()->toDateString() }}" wire:model="deadline" />

            <div class="col-span-2">
                <x-textarea label="Description" wire:model='description' hint="Max 1000 characters" />
            </div>
        </div>

        <x-slot:actions separator>
            <x-button label="Submit" class="btn-primary" spinner="update" wire:click='update' />
        </x-slot:actions>
    </x-card>
</div>
