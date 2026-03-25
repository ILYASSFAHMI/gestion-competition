<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'points',
        'flag',
        'file_url',
        'difficulty',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * All solves for this challenge.
     */
    public function solves()
    {
        return $this->hasMany(Solve::class);
    }

    /**
     * Check if a team has already solved this challenge.
     */
    public function isSolvedByTeam(int $teamId): bool
    {
        return $this->solves()->where('team_id', $teamId)->exists();
    }

    /**
     * Category color for UI badges.
     */
    public function categoryColor(): string
    {
        return match($this->category) {
            'web'       => 'text-cyan-400 border-cyan-400',
            'pwn'       => 'text-red-400 border-red-400',
            'crypto'    => 'text-yellow-400 border-yellow-400',
            'forensics' => 'text-purple-400 border-purple-400',
            'reverse'   => 'text-orange-400 border-orange-400',
            'misc'      => 'text-green-400 border-green-400',
            default     => 'text-gray-400 border-gray-400',
        };
    }

    /**
     * Difficulty color for UI.
     */
    public function difficultyColor(): string
    {
        return match($this->difficulty) {
            'easy'   => 'text-green-400',
            'medium' => 'text-yellow-400',
            'hard'   => 'text-orange-400',
            'insane' => 'text-red-400',
            default  => 'text-gray-400',
        };
    }
}
