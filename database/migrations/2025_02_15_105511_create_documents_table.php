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
            $table->string('no_dokumen');
            $table->integer('nik_nasabah');
            $table->string('nama_nasabah');
            $table->text('alamat_nasabah');
            $table->integer('telp_nasabah');
            $table->string('pekerjaan_nasabah');
            $table->integer('rekening_nasabah');
            $table->string('instansi');
            $table->string('cabang');
            $table->date('akad');
            $table->decimal('pinjaman', 15, 2);
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
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
