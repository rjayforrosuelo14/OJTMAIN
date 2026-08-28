<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPassword;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'avatar'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime'];

    /**
     * Automatically lowercase email on set
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower(trim($value));
    }

    /**
     * Send the password reset notification.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
