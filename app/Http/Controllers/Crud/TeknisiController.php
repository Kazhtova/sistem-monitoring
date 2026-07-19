<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teknisi;

class TeknisiController extends Controller
{
    // 1. Tampilkan halaman tabel
    public function index()
    {
        return view('crud.teknisi.index', [
            'teknisi' => Teknisi::latest()->paginate(10)
        ]);
    }

    // 2. Tampilkan form tambah (Kirim objek kosongan)
    public function create()
    {
        return view('crud.teknisi.form', ['teknisi' => new Teknisi()]);
    }

    // 3. Eksekusi simpan data baru
    public function store(Request $request)
    {
        Teknisi::create($request->validate([
            'nama_teknisi' => 'required|string|max:255'
        ]));

        return redirect()->route('teknisi.master-teknisi.index')->with('success', 'Teknisi berhasil ditambahkan!');
    }

    // 4. Tampilkan form edit (Kirim data yang mau diedit)
    public function edit(Teknisi $master_teknisi)
    {
        return view('crud.teknisi.form', ['teknisi' => $master_teknisi]);
    }

    // 5. Eksekusi simpan perubahan
    public function update(Request $request, Teknisi $master_teknisi)
    {
        $master_teknisi->update($request->validate([
            'nama_teknisi' => 'required|string|max:255' . $master_teknisi->id_teknisi . ',id_teknisi'
        ]));

        return redirect()->route('teknisi.master-teknisi.index')->with('success', 'Nama Teknisi berhasil diubah!');
    }

    // 6. Eksekusi hapus data
    public function destroy(Teknisi $master_teknisi)
    {
        $master_teknisi->delete();
        return redirect()->back()->with('success', 'Data Teknisi berhasil dihapus!');
    }
}