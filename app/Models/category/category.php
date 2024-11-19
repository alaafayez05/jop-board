<?php

namespace App\Models\category;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;

    protected $table= 'categories';
    protected $fillable= [
        'id',
        'name',
        'created_at',
        'updated_at',
        


    ];
    public $timestamp= true;
}
