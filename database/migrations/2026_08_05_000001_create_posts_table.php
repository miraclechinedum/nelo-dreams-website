<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->nullable();   // Outreach, School Campaign, Event…
            $table->string('location')->nullable();
            $table->string('period')->nullable();     // display string, e.g. "12 June 2025"
            $table->date('happened_on')->nullable();  // sortable date
            $table->text('summary');
            $table->longText('body')->nullable();     // plain text, rendered with line breaks
            $table->string('cover_image')->nullable();
            $table->string('hashtags')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
