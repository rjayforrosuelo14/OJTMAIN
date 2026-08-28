<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = [
        'intern_id',
        'day',
        'entry',
        'file_path'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function intern()
    {
        return $this->belongsTo(Intern::class);
    }
}
