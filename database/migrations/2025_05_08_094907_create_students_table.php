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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone_number');
            $table->string('id_number');
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->enum('pdl_status',['Booked','Not Booked','Accepted']);
            $table->enum('exam_status',['Booked','Not Booked'])->default('Not Booked');
            $table->enum('tshirt_status',['Issued','Not Issued'])->default('Not Issued');
            $table->enum('student_status',['Active','Cleared','Expired'])->default('Active');
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
        Schema::dropIfExists('students');
    }
};
