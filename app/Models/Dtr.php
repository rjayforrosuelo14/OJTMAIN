<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dtr extends Model
{
    public function intern()
{
    return $this->belongsTo(User::class, 'intern_id');
}
}
