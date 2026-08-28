<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'intern_id',
        'type',
        'fulfilled',
        'requested_at',
    ];

    public $timestamps = true;
}
