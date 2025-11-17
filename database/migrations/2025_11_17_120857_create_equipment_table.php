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

        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_category_id')->constrained();
            $table->string('name');
            $table->string('slug')->unique()->index();
            $table->longText('description')->nullable();
            $table->text('specifications')->nullable();
            $table->text('typical_uses')->nullable();
            $table->string('photo')->nullable();
            $table->text('gallery_images')->nullable();
            $table->decimal('daily_rate', 10, 2)->nullable();
            $table->decimal('weekly_rate', 10, 2)->nullable();
            $table->decimal('monthly_rate', 10, 2)->nullable();
            $table->boolean('is_available')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
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
        Schema::dropIfExists('equipment');
    }
};
