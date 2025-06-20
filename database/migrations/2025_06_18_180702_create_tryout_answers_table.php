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
        Schema::create('tryout_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tryout_question_id')->constrained('tryout_questions')->onDelete('cascade');
            $table->string('option_label', 1);
            $table->text('answer_text');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tryout_answers');
    }
};
