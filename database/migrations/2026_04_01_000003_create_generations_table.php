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
        Schema::create('generations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->enum('source_type', ['text', 'docx']);
            $table->string('source_file_path')->nullable();
            $table->enum('provider', ['openai', 'grok']);
            $table->enum('status', ['draft', 'processing', 'completed', 'failed'])->default('draft');
            $table->longText('input_text')->nullable();
            $table->longText('output_payload')->nullable();
            $table->longText('speaker_notes')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
            $table->index(['provider', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generations');
    }
};
