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
        Schema::create('sms_logs', function(Blueprint $t){
        $t->id();
        $t->string('recipient');
        $t->text('sms_body');
        $t->string('sms_type');
        $t->decimal('sms_cost', 10,2)->default(0);
        $t->json('provider_response')->nullable();
        $t->string('status')->default('queued');
        $t->string('provider_sid')->nullable();
        $t->timestamp('sent_at')->nullable();
        $t->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_logs');
    }
};
