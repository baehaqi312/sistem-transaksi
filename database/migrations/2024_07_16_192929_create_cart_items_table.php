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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('cart_id', 36);
            $table->char('services_id', 36);
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('cart_id')
                ->references('id')
                ->on('carts')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('services_id')
                ->references('id')
                ->on('services')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
