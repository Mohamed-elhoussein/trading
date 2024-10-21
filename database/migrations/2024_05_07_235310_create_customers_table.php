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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('avtar',300)->default('l60Hf.png')->nullable();
            $table->date('birthday')->nullable();
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('country_id');
            $table->boolean('email_verified')->default(false);

            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
