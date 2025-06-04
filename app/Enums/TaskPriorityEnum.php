<?php

namespace App\Enums;

enum TaskPriorityEnum: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';

    public function label(): string
    {
        return match ($this) {
            self::LOW => 'Low',
            self::MEDIUM => 'Medium',
            self::HIGH => 'High',
        };
    }
    public function color(): string
    {
        return match ($this) {
            self::LOW => 'badge-primary text-white min-h-fit',
            self::MEDIUM => 'badge-warning text-white min-h-fit',
            self::HIGH => 'badge-error text-white min-h-fit',
        };
    }
}

