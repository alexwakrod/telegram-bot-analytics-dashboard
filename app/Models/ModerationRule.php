<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModerationRule extends Model
{
    use HasFactory;

    protected $fillable = ['rule_type', 'threshold', 'duration_minutes', 'enabled'];
    protected $casts = [
        'enabled' => 'boolean',
        'duration_minutes' => 'integer',
    ];
}