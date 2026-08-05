<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * `media_items` replaces `gallery_images`: one table for every photo AND video
 * the foundation uploads, whether it lives in the home-page gallery, on a post,
 * or both. Existing gallery rows are copied across before the old table goes.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type')->default('image');   // image | video
            $table->string('path');                     // the photo, or the video file
            $table->string('poster')->nullable();       // still frame shown before a video plays
            $table->string('title')->nullable();
            $table->string('caption')->nullable();
            $table->string('category')->nullable();
            $table->string('span')->default('normal');  // grid emphasis: normal|wide|tall
            $table->boolean('in_gallery')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        if (Schema::hasTable('gallery_images')) {
            foreach (DB::table('gallery_images')->orderBy('id')->cursor() as $row) {
                DB::table('media_items')->insert([
                    'type' => 'image',
                    'path' => $row->image,
                    'title' => $row->title,
                    'caption' => $row->caption,
                    'category' => $row->category,
                    'span' => $row->span,
                    'in_gallery' => true,
                    'sort_order' => $row->sort_order,
                    'is_active' => $row->is_active,
                    'created_at' => $row->created_at,
                    'updated_at' => $row->updated_at,
                ]);
            }

            Schema::drop('gallery_images');
        }
    }

    public function down(): void
    {
        Schema::create('gallery_images', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('caption')->nullable();
            $table->string('image');
            $table->string('category')->nullable();
            $table->string('span')->default('normal');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        foreach (DB::table('media_items')->where('type', 'image')->orderBy('id')->cursor() as $row) {
            DB::table('gallery_images')->insert([
                'title' => $row->title,
                'caption' => $row->caption,
                'image' => $row->path,
                'category' => $row->category,
                'span' => $row->span,
                'sort_order' => $row->sort_order,
                'is_active' => $row->is_active,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
            ]);
        }

        Schema::dropIfExists('media_items');
    }
};
