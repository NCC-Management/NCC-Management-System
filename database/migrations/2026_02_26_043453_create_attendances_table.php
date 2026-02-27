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
    Schema::create('attendances', function (Blueprint $table) {
        $table->id();
        $table->foreignId('cadet_id')->constrained()->cascadeOnDelete();
        $table->foreignId('event_id')->constrained()->cascadeOnDelete();
        $table->enum('status', ['present', 'absent']);
        $table->timestamps();

        $table->unique(['cadet_id', 'event_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
