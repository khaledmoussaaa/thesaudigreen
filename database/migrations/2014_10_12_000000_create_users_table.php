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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('chats_id')->default(false);

            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('tax_number')->nullable();

            $table->enum('usertype', ['Admin', 'Employee', 'Customer'])->nullable();
            $table->enum('type', ['Admin', 'Requests', 'Remarks', 'Customer', 'Company', 'Governmental', 'AdminGovernmental', 'EmployeeGovernmental'])->nullable();

            $table->string('avatar')->nullable();
            $table->boolean('archive')->default(false)->nullable();
            $table->boolean('connection')->default(false)->nullable();

            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();

            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
