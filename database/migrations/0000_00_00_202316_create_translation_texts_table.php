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
        Schema::create('translation_texts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('translatable_id')
                ->nullable()
                ->unsigned();
            $table->foreign('translatable_id')
                ->references('id')
                ->on('translations')
                ->cascadeOnDelete();
            $table->unsignedBigInteger('locale_id');
            $table->foreign('locale_id')
                ->references('id')
                ->on('languages');
            $table->longText('translation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translation_texts');
    }
};
