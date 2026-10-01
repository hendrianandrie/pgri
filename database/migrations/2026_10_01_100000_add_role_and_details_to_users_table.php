<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('guru')->after('password'); // admin, pengurus, guru
            $table->string('phone')->nullable()->after('role');
            $table->string('school_origin')->nullable()->after('phone'); // asal sekolah / instansi
            $table->boolean('is_active')->default(true)->after('school_origin');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'school_origin', 'is_active']);
        });
    }
};
