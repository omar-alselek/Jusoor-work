<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSeekerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'education',
        'experience',
        'skills',
        'resume_path',
        'linkedin_profile',
        'github_profile',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 