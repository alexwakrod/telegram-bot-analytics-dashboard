<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'chat_id', 'remind_at', 'message', 'done'];
    protected $casts = [
        'remind_at' => 'datetime',
        'done' => 'boolean',
    ];
}