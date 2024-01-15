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
        Schema::create('medias', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->text('title')->nullable();
            $table->string('url');
            $table->string('ext')->nullable();
            $table->string('type')->default('images');
            $table->integer('priority')->default(0);
            $table->boolean('is_check')->default(0);
            $table->timestamps();
        });

        Schema::create('mediabbles', function (Blueprint $table) {
            $table->foreignId('media_id');
            $table->foreignId('mediabble_id');
            $table->string('mediabble_type');

            $table->primary(['media_id', 'mediabble_id', 'mediabble_type'], 'media_id_mediabble_id_type');

            $table->foreign('media_id')->references('id')->on('medias')->onDelete('cascade')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
        Schema::dropIfExists('mediabbles');
    }
};
