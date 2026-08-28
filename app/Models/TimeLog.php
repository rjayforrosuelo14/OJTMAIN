<?php

// app/Models/TimeLog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'intern_id',
        'date',
        'time_in',
        'time_out',
        'duration',

    ];

    /**
     * Define relationship: A TimeLog belongs to an Intern.
     */
    public function intern()
    {
        return $this->belongsTo(Intern::class);
    }
}
