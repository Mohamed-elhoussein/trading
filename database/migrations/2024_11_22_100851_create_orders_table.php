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
            $table->enum('operation', ['Buy', 'Sell']);
            $table->decimal('volume', 10, 2);
            $table->decimal('openPrice');
            $table->decimal('closePrice')->nullable();
            $table->decimal('total_price');
            $table->decimal('profit');
            $table->enum('trading_type', ['local', 'metatrade'])->default('local');
            $table->enum('order_status', ['open','closed'])->default('open'); // Order Status
            $table->enum("delivery",[0,1])->default('0');;
            $table->string('payment_method')->nullable(); // Payment Method
            $table->text('shipping_address');
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
