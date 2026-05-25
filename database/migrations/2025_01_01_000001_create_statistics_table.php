<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->string('label');                 // e.g. "Children Reached"
            $table->unsignedBigInteger('value');      // e.g. 12000
            $table->string('suffix')->nullable();     // e.g. "+"
            $table->string('prefix')->nullable();     // e.g. "₦"
            $table->string('icon')->nullable();       // heroicon key
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statistics');
    }
};
