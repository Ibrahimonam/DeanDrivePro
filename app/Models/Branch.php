<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory, SoftDeletes;
    

    protected $table = 'branches';
    protected $primarykey = 'id';

    protected $fillable = [
        'name', 
        'paybill_number',
        'phone_number',
        'zone_id',
        'address', 
        'deleted_by',
               
    ];

    // Zones
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    // Expenses
    public function expenses(){
        return $this->hasMany(Expense::class);
    }

    // students
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    /**
     * All payments made against invoices in this branch.
     */
    public function payments()
    {
        // hasManyThrough: payments → fee_invoices → branches
        return $this->hasManyThrough(
            Payment::class,
            FeeInvoice::class,
            'branch_id',    // FK on invoice table...
            'fee_invoice_id',// FK on payment table...
            'id',           // local key on branches
            'id'            // local key on invoices
        );
    }

}
