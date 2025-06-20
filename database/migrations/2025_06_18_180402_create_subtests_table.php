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
        Schema::create('subtests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('tryout_packages')->onDelete('cascade');
            $table->string('name');
            $table->integer('total_questions');
            $table->integer('duration_minutes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subtests');
    }
};
