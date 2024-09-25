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
        Schema::create('rent_cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->index();
            $table->foreignId('id_car')->index();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('total');
            $table->enum('status', ['Rented', 'Returned'])->default('Rented');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rent_cars');
    }
};
