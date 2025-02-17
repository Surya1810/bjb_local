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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('rfid_number')->unique()->references('rfid_number')->on('tags');
            $table->string('cif');
            $table->integer('nik_nasabah');
            $table->string('nama_nasabah');
            $table->text('alamat_nasabah');
            $table->integer('telp_nasabah');
            $table->string('pekerjaan_nasabah');
            $table->integer('rekening_nasabah');
            $table->string('instansi');

            $table->string('no_dokumen');
            $table->string('segmen');
            $table->string('cabang');
            $table->date('akad');
            $table->date('jatuh_tempo');
            $table->integer('lama');
            $table->decimal('pinjaman', 15, 2);

            $table->string('room');
            $table->string('row');
            $table->string('rack');
            $table->string('box');

            $table->string('status')->nullable(); //dipinjam, dijual, dihibahkan dsb
            $table->text('desc')->nullable(); //kolom tambahan bila diperlukan
            $table->boolean('is_there')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
