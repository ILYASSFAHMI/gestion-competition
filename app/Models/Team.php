<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'join_code', 'field', 'max_members', 'score', 'description',
    ];

    /* ── Relationships ── */
    public function members()
    {
        return $this->hasMany(User::class);
    }

    /* ── Helpers ── */
    public function isFull(): bool
    {
        return $this->members()->count() >= $this->max_members;
    }

    public function membersCount(): int
    {
        return $this->members()->count();
    }

    public function availableSlots(): int
    {
        return max(0, $this->max_members - $this->membersCount());
    }
}