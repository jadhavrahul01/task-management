@extends('mail.layout.app')

@section('content')
    <h1 class="text-center mb-3">
        {{ $subject ?? 'Task Deadline Updated' }}
    </h1>

    <p>
        Dear {{ $task->user->name }},
    </p>

    <p>
        The deadline for your assigned task has been updated. Please review the updated details below:
    </p>

    <p class="text-center my-4">
        <a href="{{ route('admin.task.show', $task->id) }}" class="btn btn-primary"
            style="text-decoration: none; padding: 10px 20px; background-color: #007bff; color: white; border-radius: 5px;">
            View Task
        </a>
    </p>

    <h4 class="text-center mb-3">Task Details</h4>

    <p><strong>Task Title:</strong> {{ $task->title }}</p>
    <p><strong>Task ID:</strong> #{{ $task->id }}</p>
    <p><strong>Description:</strong> {{ \Str::limit($task->description, 150) }}</p>
    <p><strong>New Deadline:</strong>
        {{ $task->expires_at ? $task->expires_at->format('M d, Y h:i A') : 'No time limit' }}
    </p>
    <p><strong>Assigned Date:</strong> {{ $task->created_at->format('M d, Y h:i A') }}</p>

    <br>

    <p>If you have any questions or need clarification, please reach out to your admin.</p>

    <p>Best regards,</p>
    <p>The {{ config('app.name') }} Team</p>
@endsection
