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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('symble');
            $table->boolean('measure')->comment('0=>km,1=>gm')->default(true);
            $table->double('feas_buy')->default(0);
            $table->double('feas_seller')->default(0);
            $table->integer('min_deliverd')->nullable();
            $table->double('feas_deliverd_for_one')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
