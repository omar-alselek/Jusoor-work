<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'user_id',
        'company_id',
        'message',
        'cv_path',
        'status',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isReviewed()
    {
        return $this->status === 'reviewed';
    }

    public function isShortlisted()
    {
        return $this->status === 'shortlisted';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function isAccepted()
    {
        return $this->status === 'accepted';
    }
} 