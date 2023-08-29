<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translate extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $casts = [
        'translate' => 'array',
        'meta' => 'array',
    ];
}
