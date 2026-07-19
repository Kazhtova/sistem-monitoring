<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Models\Laboratorium;
use App\Models\Teknisi;
use Illuminate\Http\Request;

class LabController extends Controller
{
    public function index()
    {
        // KUNCI PERFORMA: with('teknisi') adalah Eager Loading mencegah lambatnya database
        return view('crud.lab.index', [
            'labs' => Laboratorium::with('teknisi')->latest()->paginate(10)
        ]);
    }

    public function create()
    {
        // Kirim objek Lab kosong dan daftar semua Teknisi untuk opsi Dropdown
        return view('crud.lab.form', [
            'lab' => new Laboratorium(),
            'daftar_teknisi' => Teknisi::all()
        ]);
    }

    public function store(Request $request)
    {
        Laboratorium::create($request->validate([
            'nama_lab'        => 'required|string|max:255|unique:laboratorium,nama_lab',
            'id_teknisi'      => 'required|exists:teknisi,id_teknisi',
        ]));

        $validated['jumlah_komputer'] = 0;

        Laboratorium::create($validated);

        return redirect()->route('teknisi.master-lab.index')->with('success', 'Data Lab berhasil ditambahkan!');
    }

    public function edit(Laboratorium $master_lab)
    {
        return view('crud.lab.form', [
            'lab' => $master_lab,
            'daftar_teknisi' => Teknisi::all()
        ]);
    }

    public function update(Request $request, Laboratorium $master_lab)
    {
        $master_lab->update($request->validate([
            'nama_lab'        => 'required|string|max:255|unique:laboratorium,nama_lab,' . $master_lab->id_laboratorium . ',id_laboratorium',
            'id_teknisi'      => 'required|exists:teknisi,id_teknisi',
        ]));

        return redirect()->route('teknisi.master-lab.index')->with('success', 'Data Lab berhasil diperbarui!');
    }

    public function destroy(Laboratorium $master_lab)
    {
        $master_lab->delete();
        return redirect()->back()->with('success', 'Data Lab berhasil dihapus!');
    }
}