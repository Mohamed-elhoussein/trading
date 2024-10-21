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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('stock_id');
            $table->double('stock_price')->default(0);
            $table->unsignedBigInteger('order_status_id');
            $table->boolean('order_type')->comment('0=>seller,1=>buyer');
            $table->boolean('order_seller_buyer')->comment('0=>market,1=>slot')->default(false);
            $table->double('price')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('stock_id')->references('id')->on('stocks')->onDelete('cascade');

            $table->foreign('order_status_id')->references('id')->on('order_status')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
