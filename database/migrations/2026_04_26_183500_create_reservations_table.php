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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('chambre_id')->constrained('chambres')->cascadeOnDelete();
            $table->date('date_debut');
            $table->date('date_fin');
            $table->unsignedSmallInteger('nombre_personnes');
            $table->string('status')->default('pending')->index();
            $table->decimal('prix_total', 10, 2);
            $table->timestamps();

            $table->index(['chambre_id', 'date_debut', 'date_fin']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
