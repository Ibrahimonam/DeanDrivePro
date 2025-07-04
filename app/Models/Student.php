<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Student extends Model
{
    use HasFactory, SoftDeletes,  Notifiable;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone_number',
        'id_number',
        'branch_id',
        'class_id',
        'pdl_status',
        'exam_status',
        'tshirt_status',
        'student_status',
        'deleted_by',
    ];

    protected $dates = ['deleted_at'];

    // Relationships
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    // Track who deleted
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    // Full name accessor
    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }
    // Invoice
    public function invoices()
    {
        return $this->hasMany(FeeInvoice::class);
    }

    // Practicals

    public function practicals()
    {
        return $this->belongsToMany(Practical::class)
                    ->withTimestamps()
                    ->withPivot('issued_at');
    }

    // Authorize delete optional

    // in Student.php
    protected static function booted()
    {
        static::deleting(function($student) {
            $student->invoices->each(function($invoice) {
                $invoice->payments()->delete();
            });
            $student->invoices()->delete();
            $student->practicals()->detach();
        });
    }


}
