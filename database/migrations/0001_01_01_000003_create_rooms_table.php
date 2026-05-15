<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('amenities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon')->default('sparkles');
            $table->timestamps();
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('type'); // single, double, suite, deluxe, family
            $table->decimal('price_per_night', 10, 2);
            $table->integer('capacity')->default(2);
            $table->integer('beds')->default(1);
            $table->integer('bathrooms')->default(1);
            $table->integer('area')->nullable(); // in m²
            $table->integer('floor')->nullable();
            $table->enum('status', ['available', 'maintenance', 'occupied'])->default('available');
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            $table->index(['type', 'status']);
            $table->index('price_per_night');
        });

        Schema::create('room_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->boolean('is_primary')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('room_amenity', function (Blueprint $table) {
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->foreignId('amenity_id')->constrained()->cascadeOnDelete();
            $table->primary(['room_id', 'amenity_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_amenity');
        Schema::dropIfExists('room_images');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('amenities');
    }
};
