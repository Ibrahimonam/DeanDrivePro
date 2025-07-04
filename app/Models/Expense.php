<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category',
        'description',
        'branch_id',
        'quantity',
        'expense_date',
        'amount',
        'recept_ref_number',
        'deleted_by',
    ];

    protected $dates = [
        'expense_date',
        'deleted_at',
    ];

    // Option A (Laravel 7+)
    protected $casts = [
        'expense_date' => 'date',        // casts to Carbon\Carbon with no time
    ];

    /**
     * The branch this expense belongs to.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * The user who deleted this expense.
     */
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
