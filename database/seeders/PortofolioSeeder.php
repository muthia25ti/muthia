<?php

namespace Database\Seeders;

use App\Models\Portofolio;
use Illuminate\Database\Seeder;

/**
 * Data contoh supaya halaman CV langsung terisi.
 * Semuanya bisa diubah/dihapus lewat halaman admin (/portofolio).
 *
 * Jalankan: php artisan db:seed --class=PortofolioSeeder
 */
class PortofolioSeeder extends Seeder
{
    public function run(): void
    {
        // jangan menimpa kalau tabel sudah ada isinya
        if (Portofolio::count() > 0) {
            return;
        }

        $data = [
            // ---- profil (1 data) ----
            [
                'tipe'      => 'profil',
                'judul'     => 'Muthia Syafitri Kamal',
                'subjudul'  => 'Mahasiswa Teknik Informatika',
                'deskripsi' => 'Mahasiswa Teknik Informatika yang tertarik pada pengembangan web. Terbiasa membangun aplikasi dengan Laravel dan MySQL, serta senang belajar teknologi baru.',
            ],

            // ---- kontak ----
            ['tipe' => 'kontak', 'judul' => 'Alamat lengkap, Kota',  'subjudul' => 'Alamat'],
            ['tipe' => 'kontak', 'judul' => 'email@contoh.com',      'subjudul' => 'Email'],
            ['tipe' => 'kontak', 'judul' => '+62 812 3456 7890',     'subjudul' => 'Telepon'],
            ['tipe' => 'kontak', 'judul' => '@username',             'subjudul' => 'Sosmed'],

            // ---- pendidikan ----
            ['tipe' => 'pendidikan', 'judul' => 'Teknik Informatika', 'subjudul' => 'Nama Kampus',  'periode' => '2025 - Sekarang'],
            ['tipe' => 'pendidikan', 'judul' => 'Nama Jurusan',       'subjudul' => 'Nama SMA/SMK', 'periode' => '2022 - 2025'],

            // ---- skill ----
            ['tipe' => 'skill', 'judul' => 'Laravel',      'level' => 75],
            ['tipe' => 'skill', 'judul' => 'HTML & CSS',   'level' => 85],
            ['tipe' => 'skill', 'judul' => 'MySQL',        'level' => 70],
            ['tipe' => 'skill', 'judul' => 'PHP',          'level' => 75],

            // ---- pengalaman ----
            [
                'tipe'      => 'pengalaman',
                'judul'     => 'Anggota Divisi Kegiatan',
                'subjudul'  => 'Nama Organisasi',
                'periode'   => '2026',
                'deskripsi' => 'Membantu menyiapkan dan menjalankan kegiatan kampus.',
            ],
            [
                'tipe'      => 'pengalaman',
                'judul'     => 'Peserta Pelatihan Web',
                'subjudul'  => 'Nama Penyelenggara',
                'periode'   => '2025',
            ],

            // ---- proyek ----
            [
                'tipe'      => 'proyek',
                'judul'     => 'Website Data Pelanggan',
                'subjudul'  => 'Web Development',
                'periode'   => '2026',
                'deskripsi' => 'Aplikasi CRUD data pelanggan dengan Laravel dan template Volt.',
            ],
            [
                'tipe'      => 'proyek',
                'judul'     => 'Website Portofolio Pribadi',
                'subjudul'  => 'Web Development',
                'periode'   => '2026',
                'deskripsi' => 'Halaman CV dinamis dengan upload gambar proyek.',
            ],
        ];

        foreach ($data as $row) {
            Portofolio::create($row);
        }
    }
}
