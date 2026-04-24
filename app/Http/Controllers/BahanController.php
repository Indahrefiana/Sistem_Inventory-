<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BahanController extends Controller
{
    public function index() {
        $bahan = DB::table('bahan')->orderBy('id', 'asc')->get();
        return view('bahan.index', compact('bahan'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama_bahan' => 'required',
            'kategori_id' => 'required|numeric',
            'satuan' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);

        DB::table('bahan')->insert([
            'nama_bahan' => $request->nama_bahan,
            'kategori_id' => $request->kategori_id,
            'satuan' => $request->satuan,
            'stok' => $request->stok,
            'stok_sekarang' => $request->stok, // Otomatis
            'stok_minimal' => 10,              // Otomatis
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->back()->with('success', 'Data berhasil ditambah!');
    }

    public function update(Request $request, $id) {
        DB::table('bahan')->where('id', $id)->update([
            'nama_bahan' => $request->nama_bahan,
            'kategori_id' => $request->kategori_id,
            'satuan' => $request->satuan,
            'stok' => $request->stok,
            'updated_at' => now(),
        ]);
        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id) {
        DB::table('bahan')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}