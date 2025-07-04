<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Practical extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'duration',
        'deleted_by',
    ];

    protected $dates = ['deleted_at'];

    public function deletedByUser()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    // Student
    public function students()
    {
        return $this->belongsToMany(Student::class)
                    ->withTimestamps()
                    ->withPivot('issued_at');
    }

}
