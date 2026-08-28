<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Supervisor extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'is_accepted', 'avatar',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Get the interns for the supervisor.
     */
    public function interns()
    {
        return $this->hasMany(Intern::class);
    }

    /**
     * Get the grade submissions for the supervisor.
     */
    public function gradeSubmissions()
    {
        return $this->hasMany(GradeSubmission::class);
    }

    /**
     * Get the documents for the supervisor.
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
