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
        Schema::create('content_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'news' or 'sakti'
            $table->string('sakti_category')->nullable(); // 'pembelajaran_mendalam', 'rumah_pendidikan', 'pid', 'koding_kka'
            $table->string('badge')->nullable(); // 'SD', 'SMP', 'SMA', 'SMK', 'Umum'
            $table->string('title');
            $table->text('summary')->nullable();
            $table->longText('content');
            $table->string('author_name');
            $table->string('author_email');
            $table->string('author_phone')->nullable();
            $table->string('school_origin')->nullable();
            $table->string('image')->nullable();
            $table->string('file_url')->nullable();
            $table->date('event_date')->nullable();
            $table->string('status')->default('pending')->index(); // 'pending', 'approved', 'rejected'
            $table->text('admin_notes')->nullable();
            $table->foreignId('published_news_id')->nullable()->constrained('news')->nullOnDelete();
            $table->foreignId('published_sakti_id')->nullable()->constrained('sakti_contents')->nullOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_submissions');
    }
};
