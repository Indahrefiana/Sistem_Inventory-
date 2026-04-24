<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    public function index()
    {
        // Mengambil data riwayat barang keluar dengan join ke tabel bahan
        $barangKeluar = DB::table('barang_keluar')
            ->join('bahan', 'barang_keluar.bahan_id', '=', 'bahan.id')
            ->select('barang_keluar.*', 'bahan.nama_bahan')
            ->orderBy('barang_keluar.created_at', 'desc')
            ->get();

        // Mengambil senarai bahan untuk dropdown di borang tambah
        $bahan = DB::table('bahan')->get();

        return view('barang-keluar.index', compact('barangKeluar', 'bahan'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'bahan_id' => 'required',
            'jumlah_keluar' => 'required|numeric|min:1',
        ]);

        // Simpan ke database sesuai struktur pangkalan data anda
        DB::table('barang_keluar')->insert([
            'bahan_id' => $request->bahan_id,
            'jumlah_keluar' => $request->jumlah_keluar,
            'keterangan' => $request->keterangan,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Secara automatik mengurangkan stok di tabel bahan
        DB::table('bahan')->where('id', $request->bahan_id)->decrement('stok', $request->jumlah_keluar);

        return redirect()->back()->with('success', 'Data barang keluar berjaya disimpan!');
    }

    public function destroy($id)
    {
        DB::table('barang_keluar')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Data berjaya dipadam!');
    }
}