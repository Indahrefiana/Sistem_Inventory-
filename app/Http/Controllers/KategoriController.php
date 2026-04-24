<?php

namespace App\Http\Controllers; // PERBAIKAN: Gunakan satu App saja

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller; // Pastikan ini terhubung ke base controller

class KategoriController extends Controller
{
    public function index() 
{
    // Ambil data, urutkan berdasarkan apa saja (biasanya id atau created_at)
    $kategori = DB::table('kategori')->orderBy('id', 'asc')->get();
    return view('kategori.index', compact('kategori'));
}

    public function store(Request $request) 
    {
        // Validasi input
        $request->validate([
            'nama_kategori' => 'required|max:255'
        ]);
        
        DB::table('kategori')->insert([
            'nama_kategori' => $request->nama_kategori,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambah!');
    }

    public function update(Request $request, $id) 
    {
        // Validasi input
        $request->validate([
            'nama_kategori' => 'required|max:255'
        ]);

        DB::table('kategori')->where('id', $id)->update([
            'nama_kategori' => $request->nama_kategori,
            'updated_at'    => now(),
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil diupdate!');
    }

    public function destroy($id) 
    {
        // Hapus data berdasarkan ID
        DB::table('kategori')->where('id', $id)->delete();
        
        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}