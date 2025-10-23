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
        Schema::create('pengukuran', function (Blueprint $table) {
            $table->id();
            $table->integer('resiko_id')->unsigned()->nullable();
            $table->text('dampak')->nullable();
            $table->text('strategi')->nullable();
            $table->text('prosedur')->nullable();
            $table->integer('inhern_dampak_id')->unsigned()->nullable();
            $table->integer('inhern_kemungkinan_id')->unsigned()->nullable();
            $table->integer('inhern_nilai')->unsigned()->nullable();
            $table->integer('inhern_bobot_id')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengukuran');
    }
};
