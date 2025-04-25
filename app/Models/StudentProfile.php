<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'university',
        'major',
        'academic_year',
        'skills',
        'interests',
        'resume_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 