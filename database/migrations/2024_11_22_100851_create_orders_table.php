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
            $table->id(); // Order ID
            $table->foreignId('customer_id')->constrained("customers")->onDelete('cascade'); // User ID
            $table->string('symbol');
            $table->string('operation');
            $table->float('volume');
            $table->float('total_price');
            $table->enum('order_status', ['open','pause','closed'])->default('open'); // Order Status
            $table->enum("delivery",[0,1])->default('0');;
            $table->string('payment_method')->nullable(); // Payment Method
            $table->text('shipping_address'); // Shipping Address
            $table->string('tracking_number')->nullable(); // Tracking Number
            $table->timestamps(); // Created At & Updated At
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
