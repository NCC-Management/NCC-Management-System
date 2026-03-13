<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('units', function (Blueprint $table) {
            $table->string('officer_name')->nullable()->after('state');
            $table->string('location')->nullable()->after('officer_name');
            $table->string('contact', 20)->nullable()->after('location');
        });
    }

    public function down(): void
    {
        Schema::table('units', function (Blueprint $table) {
            $table->dropColumn(['officer_name', 'location', 'contact']);
        });
    }
};
