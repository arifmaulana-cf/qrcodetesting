<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qr_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('content');
            $table->string('type')->default('text');
            $table->string('foreground_color')->default('#000000');
            $table->string('background_color')->default('#ffffff');
            $table->integer('size')->default(300);
            $table->string('format')->default('png');
            $table->string('filename')->nullable();
            $table->integer('scan_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qr_codes');
    }
};
