<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'intern_id',
        'supervisor_id',
        'semester',
        'file_path',
        'submitted_at',
        'forwarded_to_admin',
    ];

    protected $dates = [
        'submitted_at',
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
