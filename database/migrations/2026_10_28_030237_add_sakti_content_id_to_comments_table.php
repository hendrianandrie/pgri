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
        if (Schema::hasTable('comments') && ! Schema::hasColumn('comments', 'sakti_content_id')) {
            Schema::table('comments', function (Blueprint $table) {
                $table->foreignId('sakti_content_id')->nullable()->after('news_id')->constrained('sakti_contents')->cascadeOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('comments') && Schema::hasColumn('comments', 'sakti_content_id')) {
            Schema::table('comments', function (Blueprint $table) {
                $table->dropForeign(['sakti_content_id']);
                $table->dropColumn('sakti_content_id');
            });
        }
    }
};
