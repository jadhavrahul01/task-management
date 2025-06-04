<?php

namespace App\Enums;

enum TaskStatusEnum: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::IN_PROGRESS => 'In Progress',
            self::COMPLETED => 'Completed',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'badge-warning text-white min-h-fit',
            self::IN_PROGRESS => 'badge-info text-white min-h-fit',
            self::COMPLETED => 'badge-success text-white min-h-fit',
        };
    }
}
