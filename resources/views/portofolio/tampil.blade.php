@php
    // inisial untuk avatar kalau belum ada foto
    $inisial = $profil
        ? \Illuminate\Support\Str::upper(\Illuminate\Support\Str::of($profil->judul)->explode(' ')->filter()->map(fn ($k) => \Illuminate\Support\Str::substr($k, 0, 1))->take(2)->implode(''))
        : '?';

    // ikon kontak berdasarkan jenis (kolom subjudul)
    $ikonKontak = function ($jenis) {
        $jenis = \Illuminate\Support\Str::lower((string) $jenis);
        if (\Illuminate\Support\Str::contains($jenis, ['alamat', 'lokasi', 'domisili'])) return '📍';
        if (\Illuminate\Support\Str::contains($jenis, ['email', 'mail'])) return '✉️';
        if (\Illuminate\Support\Str::contains($jenis, ['telepon', 'telp', 'hp', 'wa', 'whatsapp', 'phone'])) return '📞';
        return '🔗';
    };
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $profil ? 'CV - ' . $profil->judul : 'CV & Portofolio' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&family=Playfair+Display:ital,wght@1,600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #e9e4dc;
            --card: #f4f1ec;
            --accent: #d49a80;
            --accent-dark: #b9795c;
            --title: #8a3f33;
            --text: #4b4540;
            --muted: #7b736b;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Nunito', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
            padding: 32px 16px;
        }

        .page {
            max-width: 900px;
            margin: 0 auto 24px;
            background: var(--card);
            box-shadow: 0 8px 30px rgba(0, 0, 0, .12);
        }

        /* ---------- Header ---------- */
        .header {
            display: flex;
            align-items: center;
            gap: 24px;
            padding: 36px 40px 28px;
        }
        .profil { display: flex; align-items: center; gap: 24px; flex: 1.2; }
        .header .nama {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: 2.4rem;
            color: var(--title);
            line-height: 1.1;
        }
        .header .jabatan { font-size: 1.15rem; color: var(--muted); margin-top: 4px; }
        .header .bio { flex: 1; font-size: .9rem; color: var(--muted); }
        .avatar {
            width: 120px; height: 120px; border-radius: 50%;
            background: var(--accent); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 2.6rem; font-weight: 700; flex-shrink: 0;
            border: 5px solid #fff; overflow: hidden;
        }
        .avatar img { width: 100%; height: 100%; object-fit: cover; }

        /* ---------- Bar kontak ---------- */
        .kontak {
            background: var(--accent);
            color: #fff;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px 24px;
            padding: 18px 40px;
            font-size: .9rem;
        }

        /* ---------- Isi ---------- */
        .isi {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
            padding: 32px 40px;
        }
        .isi h3, .galeri h3 {
            font-size: .95rem;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--title);
            margin-bottom: 14px;
        }
        .item { margin-bottom: 16px; }
        .item .tahun { font-weight: 700; font-size: .85rem; }
        .item .judul { font-weight: 600; }
        .item .sub { color: var(--muted); font-size: .85rem; }
        .item .desk { color: var(--muted); font-size: .82rem; margin-top: 2px; }

        .skill { margin-bottom: 12px; }
        .skill .label { display: flex; justify-content: space-between; font-size: .85rem; margin-bottom: 4px; }
        .bar { height: 8px; background: #ddd5ca; border-radius: 99px; overflow: hidden; }
        .bar > span { display: block; height: 100%; background: var(--accent-dark); border-radius: 99px; }

        .kosong { color: var(--muted); font-size: .85rem; }

        /* ---------- Galeri portofolio ---------- */
        .galeri { padding: 8px 40px 40px; }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 20px;
        }
        .kartu {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .08);
            display: flex;
            flex-direction: column;
        }
        .kartu .gambar {
            height: 170px;
            background: #e4ddd2;
            display: flex; align-items: center; justify-content: center;
            color: var(--muted); font-size: .85rem;
        }
        .kartu .gambar img { width: 100%; height: 100%; object-fit: cover; }
        .kartu .badan { padding: 14px 16px 18px; }
        .kartu .tahun { font-weight: 700; font-size: .8rem; color: var(--accent-dark); }
        .kartu .judul { font-weight: 700; margin: 2px 0; }
        .kartu .kategori { font-size: .8rem; color: var(--muted); }
        .kartu .desk { font-size: .85rem; margin-top: 8px; }
        .kartu a { display: inline-block; margin-top: 10px; font-size: .85rem; color: var(--title); font-weight: 700; text-decoration: none; }
        .kartu a:hover { text-decoration: underline; }

        /* ---------- Tombol bawah ---------- */
        .aksi { text-align: center; font-size: .85rem; display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
        .aksi a, .aksi button {
            font: inherit; font-weight: 700; cursor: pointer;
            color: var(--title); text-decoration: none;
            background: transparent; border: 1.5px solid var(--accent);
            border-radius: 99px; padding: 6px 18px;
        }
        .aksi a:hover, .aksi button:hover { background: var(--accent); color: #fff; }

        @media (max-width: 720px) {
            .header { flex-direction: column; text-align: center; padding: 28px 20px; }
            .profil { flex-direction: column; }
            .kontak { grid-template-columns: 1fr; padding: 16px 20px; }
            .isi { grid-template-columns: 1fr; padding: 24px 20px; }
            .galeri { padding: 8px 20px 32px; }
        }

        @media print {
            body { background: #fff; padding: 0; }
            .page { box-shadow: none; max-width: none; margin: 0; }
            .aksi { display: none; }
            .kontak, .bar > span, .avatar {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .kartu { break-inside: avoid; }
        }
    </style>
</head>

<body>
    <div class="page">

        <!-- ===== HEADER (tipe: profil) ===== -->
        <div class="header">
            @if ($profil)
                <div class="profil">
                    <div class="avatar">
                        @if ($profil->gambar)
                            <img src="{{ asset('storage/' . $profil->gambar) }}" alt="Foto {{ $profil->judul }}">
                        @else
                            {{ $inisial }}
                        @endif
                    </div>
                    <div>
                        <div class="nama">{{ $profil->judul }}</div>
                        @if ($profil->subjudul)
                            <div class="jabatan">{{ $profil->subjudul }}</div>
                        @endif
                    </div>
                </div>
                @if ($profil->deskripsi)
                    <p class="bio">{{ $profil->deskripsi }}</p>
                @endif
            @else
                <p class="kosong">
                    Data profil belum diisi. Tambahkan data bertipe <b>Profil</b> lewat halaman admin.
                </p>
            @endif
        </div>

        <!-- ===== KONTAK (tipe: kontak) ===== -->
        @if ($kontak->isNotEmpty())
            <div class="kontak">
                @foreach ($kontak as $k)
                    <div>{{ $ikonKontak($k->subjudul) }} {{ $k->judul }}</div>
                @endforeach
            </div>
        @endif

        <!-- ===== PENDIDIKAN / SKILL / PENGALAMAN ===== -->
        <div class="isi">
            <div>
                <h3>Pendidikan</h3>
                @forelse ($pendidikan as $p)
                    <div class="item">
                        @if ($p->periode)
                            <div class="tahun">{{ $p->periode }}</div>
                        @endif
                        <div class="judul">{{ $p->judul }}</div>
                        @if ($p->subjudul)
                            <div class="sub">{{ $p->subjudul }}</div>
                        @endif
                    </div>
                @empty
                    <p class="kosong">Belum ada data.</p>
                @endforelse
            </div>

            <div>
                <h3>Skill</h3>
                @forelse ($skill as $s)
                    <div class="skill">
                        <div class="label">
                            <span>{{ $s->judul }}</span>
                            <span>{{ (int) $s->level }}%</span>
                        </div>
                        <div class="bar"><span style="width: {{ (int) $s->level }}%"></span></div>
                    </div>
                @empty
                    <p class="kosong">Belum ada data.</p>
                @endforelse
            </div>

            <div>
                <h3>Pengalaman</h3>
                @forelse ($pengalaman as $e)
                    <div class="item">
                        @if ($e->periode)
                            <div class="tahun">{{ $e->periode }}</div>
                        @endif
                        <div class="judul">{{ $e->judul }}</div>
                        @if ($e->subjudul)
                            <div class="sub">{{ $e->subjudul }}</div>
                        @endif
                        @if ($e->deskripsi)
                            <div class="desk">{{ $e->deskripsi }}</div>
                        @endif
                    </div>
                @empty
                    <p class="kosong">Belum ada data.</p>
                @endforelse
            </div>
        </div>

        <!-- ===== PORTOFOLIO (tipe: proyek) ===== -->
        <div class="galeri">
            <h3>Portofolio Saya</h3>

            @if ($proyek->isEmpty())
                <p class="kosong">Belum ada proyek.</p>
            @else
                <div class="grid">
                    @foreach ($proyek as $item)
                        <div class="kartu">
                            <div class="gambar">
                                @if ($item->gambar)
                                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}">
                                @else
                                    Tanpa gambar
                                @endif
                            </div>
                            <div class="badan">
                                @if ($item->periode)
                                    <div class="tahun">{{ $item->periode }}</div>
                                @endif
                                <div class="judul">{{ $item->judul }}</div>
                                @if ($item->subjudul)
                                    <div class="kategori">{{ $item->subjudul }}</div>
                                @endif
                                @if ($item->deskripsi)
                                    <p class="desk">{{ \Illuminate\Support\Str::limit($item->deskripsi, 110) }}</p>
                                @endif
                                @if ($item->link)
                                    <a href="{{ $item->link }}" target="_blank" rel="noopener">Lihat proyek &rarr;</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="aksi">
        <button type="button" onclick="window.print()">Cetak / Simpan PDF</button>
        <a href="{{ route('portofolio.index') }}">Kelola Isi CV (Admin)</a>
    </div>
</body>

</html>
