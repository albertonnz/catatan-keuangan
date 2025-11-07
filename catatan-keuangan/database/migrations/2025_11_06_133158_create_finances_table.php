<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('finances', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->string('judul');
            $table->text('deskripsi')->nullable();

            // pemasukan/pengeluaran
            $table->enum('jenis', ['pemasukan', 'pengeluaran']);

            // nominal uang
            $table->integer('nominal');

            // cover slip / bukti foto (opsional)
            $table->string('cover')->nullable();

            $table->timestamps();

            // foreign key
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('finances');
    }
};
