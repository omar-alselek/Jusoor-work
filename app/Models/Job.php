<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'opportunities';

    protected $fillable = [
        'company_id',
        'title',
        'description',
        'type',
        'location',
        'salary',
        'working_hours',
        'required_skills',
        'duration',
        'academic_credit',
        'start_date',
        'deadline',
        'requirements',
        'benefits',
        'status'
    ];

    protected $casts = [
        'deadline' => 'date',
        'start_date' => 'date',
        'required_skills' => 'array',
        'academic_credit' => 'boolean'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isClosed()
    {
        return $this->status === 'closed';
    }
} 