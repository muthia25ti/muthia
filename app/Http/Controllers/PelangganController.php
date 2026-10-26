<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $data['dataPelanggan'] = Pelanggan::all();
    return view('admin.pelanggan.index', $data);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    return view('admin.pelanggan.create');
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // 1. Validasi Input
    $validated = $request->validate([
        'first_name' => 'required',
        'last_name'  => 'required',
        'birthday'   => 'required|date',
        'gender'     => 'required|in:Male,Female',
        'email'      => 'required|email',
        'phone'      => 'required|numeric',
    ]);

   
    Pelanggan::create($validated);

    return redirect()->route('pelanggan.index')->with('success', 'Data Pelanggan Berhasil Ditambahkan!');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
{
    $data['dataPelanggan'] = Pelanggan::findOrFail($id);
    return view('admin.pelanggan.edit', $data);
}

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, string $id)
{
    // 1. Validasi Input[cite: 14]
    $validated = $request->validate([
        'first_name' => 'required',
        'last_name'  => 'required',
        'birthday'   => 'required|date',
        'gender'     => 'required|in:Male,Female',
        'email'      => 'required|email',
        'phone'      => 'required|numeric',
    ]);

    // 2. Update Data[cite: 14]
    $pelanggan = Pelanggan::findOrFail($id);
    $pelanggan->update($validated);

    return redirect()->route('pelanggan.index')->with('success', 'Perubahan Data Berhasil!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    $pelanggan = Pelanggan::findOrFail($id);
    $pelanggan->delete();

    return redirect()->route('pelanggan.index')->with('success', 'Penghapusan Data Berhasil!');
}
}
