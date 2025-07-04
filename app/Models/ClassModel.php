<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'classes';
    protected $primarykey = 'id';

    protected $fillable = [
        'name', 
        'description',
        'duration',
        'fee',
        'deleted_by',
               
    ];
}
