<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'branch_id',
        'amount_original',
        'discount_amount',
        'amount_due',
        'status',
        'due_date',
    ];

    protected $casts = [
        'amount_original' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'amount_due'     => 'decimal:2',
        'due_date'       => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getAmountPaidAttribute()
    {
        return $this->payments()->sum('amount_paid');
    }

    public function getBalanceAttribute()
    {
        return $this->amount_due - $this->amount_paid;
    }

    public function isPaid(): bool
    {
        return $this->balance <= 0;
    }
}

