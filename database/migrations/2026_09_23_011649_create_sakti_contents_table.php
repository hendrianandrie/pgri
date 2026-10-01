<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sakti_contents', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['pembelajaran_mendalam', 'rumah_pendidikan', 'pid', 'koding_kka']);
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary');
            $table->longText('content');
            $table->string('author')->default('Pengurus PGRI');
            $table->string('image')->nullable();
            $table->string('file_url')->nullable();
            $table->string('badge')->nullable();
            $table->integer('views')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sakti_contents');
    }
};
