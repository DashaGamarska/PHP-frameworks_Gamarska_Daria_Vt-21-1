<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['score', 'enrollment_id'];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
}
