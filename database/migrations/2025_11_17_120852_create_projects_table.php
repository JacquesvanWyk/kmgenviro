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

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sector_id')->nullable()->constrained();
            $table->string('title');
            $table->string('slug')->unique()->index();
            $table->string('client_name')->nullable();
            $table->string('location')->nullable();
            $table->string('province')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('full_description')->nullable();
            $table->text('services_provided')->nullable();
            $table->text('outcomes')->nullable();
            $table->string('featured_image')->nullable();
            $table->text('gallery_images')->nullable();
            $table->date('completion_date')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
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
        Schema::dropIfExists('projects');
    }
};
