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
        Schema::create('order_layanan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('service_id');
            $table->char('user_id')->unique();
            $table->string('title');
            $table->mediumText('description');
            $table->string('logo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_layanan');
    }
};
