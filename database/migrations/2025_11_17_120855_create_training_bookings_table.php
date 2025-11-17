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

        Schema::create('training_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_course_id')->constrained();
            $table->foreignId('training_schedule_id')->nullable()->constrained();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('company')->nullable();
            $table->integer('number_of_delegates')->default(1);
            $table->text('delegate_names')->nullable();
            $table->text('special_requirements')->nullable();
            $table->date('preferred_date')->nullable();
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
        Schema::dropIfExists('training_bookings');
    }
};
