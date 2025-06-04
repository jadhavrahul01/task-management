<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\TaskStatusEnum;
use App\Enums\TaskPriorityEnum;


class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'priority',
        'completed_at',
        'expires_at',
    ];
    protected $casts = [
        'status' => TaskStatusEnum::class,
        'priority' => TaskPriorityEnum::class,
        'completed_at' => 'datetime',
        'expires_at' => 'datetime'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function scopeSearch($q, $term)
    {
        $q->where(function ($query) use ($term) {
            $query->where('title', 'like', "%$term%")
                ->whereHas('user', function ($query) use ($term) {
                    $query->where('name', 'like', "%$term%")
                        ->orWhere('email', 'like', "%$term%");
                });
        });
    }
}
