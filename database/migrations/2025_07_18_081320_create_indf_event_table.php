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
        Schema::create('indf_event', function (Blueprint $table) {
            $table->id();
            $table->integer('sasaran_id')->unsigned()->nullable();
            $table->integer('tujuan_id')->unsigned()->nullable();
            $table->text('event_nama')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indf_event');
    }
};
