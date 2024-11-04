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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string("logo", 200);
            $table->string("name", 50);
            $table->string("description", 400);
            $table->string("instagram", 300)->nullable();
            $table->string("whatsApp", 300)->nullable();
            $table->string("facebook", 300)->nullable();
            $table->string("snapchat", 300)->nullable();
            $table->string("email", 150)->nullable();
            $table->string("phone", 14)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
