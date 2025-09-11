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
        Schema::create('pengendalian', function (Blueprint $table) {
            $table->id();
            $table->integer('resiko_id')->unsigned()->nullable();
            $table->text('rencana')->nullable();
            $table->integer('exp_kemungkinan_id')->unsigned()->nullable();
            $table->integer('exp_dampak_id')->unsigned()->nullable();
            $table->integer('exp_nilai')->unsigned()->nullable();
            $table->integer('exp_bobot_id')->unsigned()->nullable();
            $table->text('pic')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengendalian');
    }
};
