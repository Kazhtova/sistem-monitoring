<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Models\Komputer;
use App\Models\Laboratorium;
use Illuminate\Http\Request;

class KomputerController extends Controller
{
    public function index(Request $request)
    {
        $query = Komputer::with('laboratorium');

        if ($request->filled('search')) {
            $query->where('nama_komputer', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('lab') && $request->lab !== 'all') {
            $query->where('id_laboratorium', $request->lab);
        }

        $query->orderBy(
            Laboratorium::select('nama_lab')
                ->whereColumn('laboratorium.id_laboratorium', 'komputer.id_laboratorium')
                ->limit(1), 
            'asc'
        )
        ->orderByRaw('LENGTH(nama_komputer) ASC')
        ->orderBy('nama_komputer', 'asc');

        $komputers = $query->paginate(10)->withQueryString();
        
        $komputers->through(function ($item) {
            $item->nama_komputer = preg_replace_callback('/\d+/', function ($matches) {
                return str_pad($matches[0], 2, '0', STR_PAD_LEFT);
            }, $item->nama_komputer);
            
            return $item;
        });
        
        $daftarLab = Laboratorium::orderBy('nama_lab', 'asc')->get();

        return view('crud.komputer.index', compact('komputers', 'daftarLab'));
    }

    public function create()
    {
        return view('crud.komputer.form', [
            'komputer' => new Komputer(),
            'daftar_lab' => Laboratorium::all() 
        ]);
    }

    public function store(Request $request)
    {
        Komputer::create($request->validate([
            'nama_komputer'   => 'required|string|max:255',
            'id_laboratorium' => 'required|exists:laboratorium,id_laboratorium'
        ]));

        return redirect()->route('teknisi.master-komputer.index')->with('success', 'Data Komputer berhasil ditambahkan!');
    }

    public function edit(Komputer $master_komputer)
    {
        return view('crud.komputer.form', [
            'komputer'   => $master_komputer,
            'daftar_lab' => Laboratorium::all()
        ]);
    }

    public function update(Request $request, Komputer $master_komputer)
    {
        $master_komputer->update($request->validate([
            'nama_komputer'   => 'required|string|max:255',
            'id_laboratorium' => 'required|exists:laboratorium,id_laboratorium'
        ]));

        return redirect()->route('teknisi.master-komputer.index')->with('success', 'Data Komputer berhasil diperbarui!');
    }

    public function destroy(Komputer $master_komputer)
    {
        $master_komputer->delete();
        return redirect()->back()->with('success', 'Data Komputer berhasil dihapus!');
    }
}