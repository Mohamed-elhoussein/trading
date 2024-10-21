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
        Schema::create('withdrawns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->double('value');
            $table->double('feas')->default(0);
            $table->unsignedBigInteger('account_bank_id');
            $table->unsignedBigInteger('status_id');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('account_bank_id')->references('id')->on('bank_accounts')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('status_withdrawns')->onDelete('cascade');



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawns');
    }
};
