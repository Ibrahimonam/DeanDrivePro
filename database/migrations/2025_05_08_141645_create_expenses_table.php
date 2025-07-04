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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->enum('category',['Repairs/Maintainance','Office Supplies','Travel/Communication','Admin Expenses','Miscellenous','Commisions','Fuel','Marketing']);
            $table->string('description');
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');
            $table->string('quantity');
            $table->date('expense_date');
            $table->decimal('amount');
            $table->string('recept_ref_number')->nullable();
            $table->timestamps();
            // Soft deletes
            $table->softDeletes();

            // To capture who deleted the record
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
