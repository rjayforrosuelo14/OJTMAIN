<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'intern_id',
        'supervisor_id',
        'type',
        'path',
        'filename',
        'submitted_at',
        'description',
        'forwarded_to_admin',
    ];

    public function intern()
    {
        return $this->belongsTo(Intern::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }
}
