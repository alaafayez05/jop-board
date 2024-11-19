<?php

namespace App\Models\Job;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Job extends Model
{
    use Searchable;
    use HasFactory;
    protected $table = 'jobs';
    protected $fillable = [
        'id',
        'job_title',
        'job_region',
        'company',
        'job_type',
        'vacancy',
        'experience',
        'salary',
        'gender',
        'application_deadline',
        'jobdescription',
        'responsibilities',
        'education_experience',
        'otherbenefits',
        'category',
        'image',


    ];
    public $timestamp = true;
}
