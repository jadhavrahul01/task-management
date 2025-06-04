@extends('mail.layout.app')

@section('content')
    <h1 class="text-center mb-3">
        {{ $subject ?? 'Task Status Updated' }}
    </h1>

    <p>
        Dear Admin,
    </p>

    <p>
        The status of the following task has been updated by {{ $task->user->name }}:
    </p>

    <p class="text-center my-4">
        <a href="{{ route('admin.task.show', $task->id) }}" class="btn btn-primary"
            style="text-decoration: none; padding: 10px 20px; background-color: #007bff; color: white; border-radius: 5px;">
            View Task Details
        </a>
    </p>

    <h4 class="text-center mb-3">Task Summary</h4>

    <p><strong>Task Title:</strong> {{ $task->title }}</p>
    <p><strong>Task ID:</strong> #{{ $task->id }}</p>
    <p><strong>Updated By:</strong> {{ $task->user->name }} ({{ $task->user->email }})</p>
    <p><strong>New Status:</strong>
        <span class="badge {{ $task->status->color() }}">
            {{ $task->status->label() }}
        </span>
    </p> 
    <p><strong>Updated At:</strong> {{ now()->format('M d, Y h:i A') }}</p>

    <br>

    <p>Regards,</p>
    <p>{{ config('app.name') }} System Notification</p>
@endsection
