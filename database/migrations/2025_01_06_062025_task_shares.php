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
        Schema::create('task_shares', function (Blueprint $table) {
            $table->id();
            $table->integer('task_id')->references('id')->on('task');
            $table->integer('shared_with')->references('id')->on('users');
            $table->enum('permission', ['view', 'edit']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_shares');
    }
};
