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
        Schema::create('communications', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->string('tracking_number')->nullable();
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->text('file')->nullable();
            $table->enum('status', ['in_coming', 'out_going'])->default('in_coming');
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communications');
    }
};
