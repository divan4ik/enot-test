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
        Schema::create('one_time_passwords', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userId')->unsigned();
            $table->char('code', 36);
            $table->smallInteger('attempts')->unsigned();
            //$table->smallInteger('maxAttempts'); можно было бы задавать максимальное количество и вообще не зависеть от хардкода константы
            $table->boolean('expired')->default(0)->unsigned();
            $table->datetime('createdAt')->nullable();

            $table->foreign('userId')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('one_time_passwords');
    }
};
