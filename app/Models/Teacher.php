<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'id_number',
        'branch_id',
        'deleted_by',
    ];

    /**
     * The attributes that should be mutated to dates.
     */
    protected $dates = ['deleted_at'];

    /**
     * Branch relationship.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Who deleted this teacher.
     */
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    /**
     * Full name accessor.
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
