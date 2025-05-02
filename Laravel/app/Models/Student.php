<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['name', 'email', 'birthdate']; // додай це, щоб дозволити масове призначення

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
