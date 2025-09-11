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
        Schema::create('app_divisi', function (Blueprint $table) {
            $table->id();
            $table->year('tahun')->nullable();
            $table->integer('divisi_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->text('app_status')->nullable();
            $table->text('app_kadiv')->nullable();
            $table->text('app_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_divisi');
    }
};
