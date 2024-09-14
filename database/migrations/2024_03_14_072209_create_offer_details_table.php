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
        Schema::create('offer_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_id')->constrained('offer_prices')->onDelete('cascade');
            $table->string('offer_number');
            $table->foreignId('car_id')->constrained('request_details');
            
            $table->string('description');
            $table->decimal('price', 10, 2);
            $table->decimal('sale', 5, 2)->nullable();
            $table->integer('quantity');

            $table->boolean('checked')->default(false);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_details');
    }
};
