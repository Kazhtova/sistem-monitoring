<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function index()
    {
        return view('crud.dosen.index', [
            'dosen' => Dosen::all()
        ]);
    }

    // 2. Tampilkan form tambah (Kirim objek kosongan)
    public function create()
    {
        return view('crud.dosen.form', ['dosen' => new Dosen()]);
    }

    // 3. Eksekusi simpan data baru
    public function store(Request $request)
    {
        Dosen::create($request->validate([
            'nama_dosen' => 'required|string|max:255'
        ]));

        return redirect()->route('teknisi.master-dosen.index')->with('success', 'Dosen berhasil ditambahkan!');
    }

    // 4. Tampilkan form edit (Kirim data yang mau diedit)
    public function edit(Dosen $master_dosen)
    {
        return view('crud.dosen.form', ['dosen' => $master_dosen]);
    }

    // 5. Eksekusi simpan perubahan
    public function update(Request $request, Dosen $master_dosen)
    {
        $master_dosen->update($request->validate([
            'nama_dosen' => 'required|string|max:255' . $master_dosen->id_dosen . ',id_dosen'
        ]));

        return redirect()->route('teknisi.master-dosen.index')->with('success', 'Nama Dosen berhasil diubah!');
    }

    // 6. Eksekusi hapus data
    public function destroy(Dosen $master_dosen)
    {
        $master_dosen->delete();
        return redirect()->back()->with('success', 'Data Dosen berhasil dihapus!');
    }
}