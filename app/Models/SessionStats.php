<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SessionStats extends Model
{
    protected $table = 'session_stats';
    protected $fillable = ['event_id', 'created_at', 'stats'];
    protected $casts = [
        'id' => 'int',
        'event_id' => 'int',
        'created_at' => 'datetime',
        'stats' => 'json'
    ];
}
