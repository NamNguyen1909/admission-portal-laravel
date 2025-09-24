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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_id')->unique(); // APP-YYYY-#### (sẽ được tự sinh trong model)
            $table->string('student_name');
            $table->string('program');
            $table->enum('status', ['submitted', 'approved', 'enrolled', 'rejected'])->default('submitted');
            $table->enum('payment_status', ['unpaid', 'partial', 'paid'])->default('unpaid');
            $table->foreignId('registration_id')->constrained('registrations')->onDelete('cascade');
            $table->timestamps(); //created_at, updated_at của php
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
