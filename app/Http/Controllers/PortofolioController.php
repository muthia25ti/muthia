<?php

namespace App\Http\Controllers;

use App\Models\Portofolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PortofolioController extends Controller
{
    /**
     * Halaman publik: tampilan CV/portofolio (semua isi diambil dari database).
     */
    public function tampil()
    {
        $semua = Portofolio::orderBy('portofolio_id')->get()->groupBy('tipe');

        return view('portofolio.tampil', [
            'profil'     => optional($semua->get('profil'))->first(),
            'kontak'     => $semua->get('kontak', collect()),
            'pendidikan' => $semua->get('pendidikan', collect()),
            'skill'      => $semua->get('skill', collect()),
            'pengalaman' => $semua->get('pengalaman', collect()),
            'proyek'     => $semua->get('proyek', collect()),
        ]);
    }

    /**
     * Daftar data (admin), bisa difilter per tipe: /portofolio?tipe=skill
     */
    public function index(Request $request)
    {
        $tipe = $request->query('tipe');

        $dataPortofolio = Portofolio::when($tipe, fn ($q) => $q->where('tipe', $tipe))
            ->orderBy('tipe')
            ->orderBy('portofolio_id')
            ->get();

        return view('admin.portofolio.index', compact('dataPortofolio'));
    }

    /**
     * Form tambah.
     */
    public function create()
    {
        return view('admin.portofolio.create');
    }

    /**
     * Simpan data baru.
     */
    public function store(Request $request)
    {
        $data = $this->validasi($request);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('portofolio', 'public');
        }

        Portofolio::create($data);

        return redirect()->route('portofolio.index')->with('success', 'Penambahan Data Berhasil!');
    }

    /**
     * Form edit.
     */
    public function edit(string $id)
    {
        $dataPortofolio = Portofolio::findOrFail($id);
        return view('admin.portofolio.edit', compact('dataPortofolio'));
    }

    /**
     * Simpan perubahan.
     */
    public function update(Request $request, string $id)
    {
        $portofolio = Portofolio::findOrFail($id);
        $data = $this->validasi($request);

        if ($request->hasFile('gambar')) {
            // ganti gambar: hapus file lama, simpan yang baru
            if ($portofolio->gambar) {
                Storage::disk('public')->delete($portofolio->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('portofolio', 'public');
        } elseif ($request->boolean('hapus_gambar')) {
            // hanya hapus gambar
            if ($portofolio->gambar) {
                Storage::disk('public')->delete($portofolio->gambar);
            }
            $data['gambar'] = null;
        }

        $portofolio->update($data);

        return redirect()->route('portofolio.index')->with('success', 'Perubahan Data Berhasil!');
    }

    /**
     * Hapus data (beserta file gambarnya).
     */
    public function destroy(string $id)
    {
        $portofolio = Portofolio::findOrFail($id);

        if ($portofolio->gambar) {
            Storage::disk('public')->delete($portofolio->gambar);
        }

        $portofolio->delete();

        return redirect()->route('portofolio.index')->with('success', 'Data Berhasil Dihapus!');
    }

    /**
     * Aturan validasi dipakai bersama oleh store() dan update().
     */
    private function validasi(Request $request): array
    {
        return $request->validate([
            'tipe'      => ['required', Rule::in(array_keys(Portofolio::TIPE))],
            'judul'     => 'required|string|max:150',
            'subjudul'  => 'nullable|string|max:150',
            'periode'   => 'nullable|string|max:50',
            'level'     => 'nullable|integer|between:0,100',
            'deskripsi' => 'nullable|string',
            'link'      => 'nullable|url|max:255',
            'gambar'    => 'nullable|image|max:2048',
        ]);
    }
}
