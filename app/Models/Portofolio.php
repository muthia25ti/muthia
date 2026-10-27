<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model
{
    // NIM 2555301139 -> 4 angka terakhir: 1139 (sama dengan di migration)
    protected $table = 'portofolio_1139';
    protected $primaryKey = 'portofolio_id';

    /**
     * Jenis data CV: kode => nama yang tampil.
     */
    public const TIPE = [
        'profil'     => 'Profil',
        'kontak'     => 'Kontak',
        'pendidikan' => 'Pendidikan',
        'skill'      => 'Skill',
        'pengalaman' => 'Pengalaman',
        'proyek'     => 'Proyek Portofolio',
    ];

    protected $fillable = [
        'tipe',
        'judul',
        'subjudul',
        'periode',
        'level',
        'deskripsi',
        'link',
        'gambar',
    ];
}
