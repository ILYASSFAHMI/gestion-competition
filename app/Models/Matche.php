<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matche extends Model
{
    protected $table = 'matches';

    protected $fillable = [
        'team1_id',
        'team2_id',
        'score_team1',
        'score_team2'
    ];

    public function team1()
    {
        return $this->belongsTo(Team::class, 'team1_id');
    }

    public function team2()
    {
        return $this->belongsTo(Team::class, 'team2_id');
    }
}
