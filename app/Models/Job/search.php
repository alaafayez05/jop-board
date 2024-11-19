<?php

namespace App\Models\Job;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class search extends Model
{
    use HasFactory;
        protected $table= 'searches';

    protected $fillable= [
        'id',
        'keyword',
    
    ];
    public $timestamp= true;
}
