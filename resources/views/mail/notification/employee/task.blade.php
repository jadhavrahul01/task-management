@extends('mail.layout.app')

@section('content')
    <h1 class="text-center mb-3">
        {{ $subject }}
    </h1>

    <p>
        Dear {{ $task->user->name }},
    </p>
    <p>
        A new task has been assigned to you. Please find the details below:
    </p>

    <p class="text-center my-4">
        <a href="{{ route('admin.task.show', $task->id) }}" class="btn btn-primary"
            style="text-decoration: none; padding: 10px 20px; background-color: #007bff; color: white; border-radius: 5px;">
            View Task Details
        </a>
    </p>

    <h4 class="text-center mb-3">
        Task Overview
    </h4>

    <p><strong>Task Title:</strong> {{ $task->title }}</p>
    <p><strong>Task Description:</strong> {{ \Str::limit($task->description, 150) }}</p>
    <p><strong>Task ID:</strong> #{{ $task->id }}</p>
    <p><strong>Email:</strong> {{ $task->user->email }}</p>
    <p><strong>Assigned Date:</strong> {{ $task->created_at->format('M d, Y h:i A') }}</p>

    <p><strong>Expiry Date:</strong>
        {{ $task->expires_at ? $task->expires_at->format('M d, Y h:i A') : 'No time limit' }}
    </p>
    <br>

    <p>Best regards,</p>
    <p>The {{ config('app.name') }} Team</p>
@endsection
