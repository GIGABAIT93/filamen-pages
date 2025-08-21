<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();

            $table->string('slug', 191)->unique();
            $table->string('template')->nullable()->index();

            $table->string('nav_icon')->nullable();
            $table->string('nav_group', 64)->nullable();
            $table->boolean('nav_blank')->default(false);
            $table->string('page_width', 32)->nullable();

            $table->boolean('is_active')->default(true)->index();
            $table->enum('visibility', ['public', 'auth', 'private'])->default('public')->index();
            $table->unsignedSmallInteger('position')->default(0);

            $table->timestampTz('published_at')->nullable()->index();

            $table->foreignId('created_by')->nullable()
                ->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('updated_by')->nullable()
                ->constrained('users')->cascadeOnUpdate()->nullOnDelete();

            $table->timestampsTz();
            $table->softDeletes();

            $table->index(['visibility', 'is_active', 'published_at', 'position']);
            $table->index(['nav_group', 'position']);
            $table->index('deleted_at');
        });

        Schema::create('page_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')
                ->constrained('pages')->cascadeOnUpdate()->cascadeOnDelete();

            $table->string('locale', 10)->index();
            $table->string('name');
            $table->string('title')->nullable();

            $table->json('content')->nullable();
            $table->longText('content_html')->nullable();

            $table->timestampsTz();

            $table->unique(['page_id', 'locale']);
            $table->index(['title', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_translations');
        Schema::dropIfExists('pages');
    }
};
