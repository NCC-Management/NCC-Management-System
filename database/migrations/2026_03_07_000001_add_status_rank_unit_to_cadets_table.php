<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cadets', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('profile_completed');
            $table->string('rank', 100)->nullable()->after('enrollment_no');
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete()->after('user_id');
            $table->string('rejection_reason')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('cadets', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropColumn(['status', 'rank', 'unit_id', 'rejection_reason']);
        });
    }
};
