<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommandLog extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'command_logs';
    protected $fillable = ['user_id', 'command', 'timestamp'];
    protected $casts = [
        'timestamp' => 'datetime',
    ];
}