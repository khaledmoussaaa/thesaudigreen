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
        Schema::create('offer_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained('requests');

            $table->string('offer_number');
            $table->string('price_before_sale', 10, 2);
            $table->decimal('sale')->nullable();
            $table->string('price_after_sale', 10, 2);
            $table->decimal('vat')->nullable();
            $table->decimal('total_price', 10, 2);
            $table->integer('total_quantity');

            $table->boolean('status')->default(false);
            $table->integer('approval')->default(0);
            $table->boolean('seen')->default(false);
            $table->longText('description')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_prices');
    }
};
