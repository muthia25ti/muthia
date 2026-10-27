<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * NIM 2555301139 -> 4 angka terakhir: 1139 (sama dengan di model Portofolio.php).
     *
     * Satu tabel menampung seluruh isi CV, dibedakan oleh kolom `tipe`:
     *   profil | kontak | pendidikan | skill | pengalaman | proyek
     */
    public function up(): void
    {
        Schema::create('portofolio_1139', function (Blueprint $table) {
            $table->increments('portofolio_id');
            $table->string('tipe', 20);                       // jenis data CV
            $table->string('judul', 150);                     // nama / jurusan / skill / posisi / judul proyek
            $table->string('subjudul', 150)->nullable();      // jabatan / kampus / organisasi / kategori
            $table->string('periode', 50)->nullable();        // 2025 - Sekarang / tahun
            $table->unsignedTinyInteger('level')->nullable(); // khusus skill: 0-100
            $table->text('deskripsi')->nullable();            // bio / detail
            $table->string('link')->nullable();
            $table->string('gambar')->nullable();             // foto profil / gambar proyek
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portofolio_1139');
    }
};
