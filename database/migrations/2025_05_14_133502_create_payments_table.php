<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fee_invoice_id')
                  ->constrained('fee_invoices')
                  ->cascadeOnDelete();
            $table->string('tran_code')->nullable();      // e.g. M-PESA receipt
            $table->enum('payment_method', ['Mpesa','Cheque','Cash','Card']);
            $table->decimal('amount_paid', 10, 2);         // e.g. 7500.00
            $table->date('payment_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
