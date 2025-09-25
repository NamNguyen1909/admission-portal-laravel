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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();

            $table->string('profile_picture')->nullable(); // Ảnh hồ sơ - upload file
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('email')->unique();
            $table->enum('gender', ['male', 'female', 'other']); 
            $table->date('date_of_birth');
            $table->string('country_of_birth');
            $table->string('nationality');
            $table->string('passport_no')->nullable();
            $table->string('passport_file')->nullable();
            $table->string('permanent_address')->nullable(); //nơi ở thường trú
            $table->string('present_address')->nullable(); //nơi ở hiện tại
            $table->string('program'); //tên chương trình học 

            $table->timestamps(); //created_at, updated_at của php
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
