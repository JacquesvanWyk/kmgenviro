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
        Schema::disableForeignKeyConstraints();

        Schema::create('equipment_rental_quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->nullable()->constrained();
            $table->string('name');
            $table->string('company')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->text('equipment_requested')->nullable();
            $table->string('rental_duration')->nullable();
            $table->date('start_date')->nullable();
            $table->string('location')->nullable();
            $table->boolean('delivery_required')->default(false);
            $table->text('message')->nullable();
            $table->string('status')->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_rental_quotes');
    }
};
