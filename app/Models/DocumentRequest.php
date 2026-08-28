<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'intern_id',
        'type',
        'requested_at',
    ];

    public function intern()
    {
        return $this->belongsTo(Intern::class);
    }
}
