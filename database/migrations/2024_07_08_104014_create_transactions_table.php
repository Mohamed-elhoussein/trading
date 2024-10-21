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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->double('value');
            $table->unsignedBigInteger('account_id');
            //$table->unsignedBigInteger('transactions_messagas_id');
            $table->unsignedBigInteger('transactions_status_id');
            $table->unsignedBigInteger('related_id')->nullable();
            $table->string('relatied_model')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
    //        $table->foreign('transactions_messagas_id')->references('id')->on('transactions_messagas')->onDelete('cascade');
            $table->foreign('transactions_status_id')->references('id')->on('transaction_statuses')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
