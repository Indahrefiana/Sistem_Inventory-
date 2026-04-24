<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    public function index()
    {
        // Mengambil riwayat dengan join ke tabel bahan
        $barangMasuk = DB::table('barang_masuk')
            ->join('bahan', 'barang_masuk.barang_id', '=', 'bahan.id')
            ->select('barang_masuk.*', 'bahan.nama_bahan')
            ->orderBy('barang_masuk.created_at', 'desc')
            ->get();

        $bahan = DB::table('bahan')->get();
        return view('barang_masuk.index', compact('barangMasuk', 'bahan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required',
            'jumlah_masuk' => 'required|numeric|min:1',
        ]);

        // Simpan data & tambah stok
        DB::table('barang_masuk')->insert([
            'barang_id' => $request->barang_id,
            'jumlah_masuk' => $request->jumlah_masuk,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('bahan')->where('id', $request->barang_id)->increment('stok', $request->jumlah_masuk);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'barang_id' => 'required',
            'jumlah_masuk' => 'required|numeric|min:1',
        ]);

        $oldData = DB::table('barang_masuk')->where('id', $id)->first();
        
        // Sesuaikan stok di tabel bahan (kurangi jumlah lama, tambah jumlah baru)
        DB::table('bahan')->where('id', $oldData->barang_id)->decrement('stok', $oldData->jumlah_masuk);
        DB::table('bahan')->where('id', $request->barang_id)->increment('stok', $request->jumlah_masuk);

        // Update data barang masuk
        DB::table('barang_masuk')->where('id', $id)->update([
            'barang_id' => $request->barang_id,
            'jumlah_masuk' => $request->jumlah_masuk,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $data = DB::table('barang_masuk')->where('id', $id)->first();
        
        if ($data) {
            // Kurangi stok bahan sebelum data dihapus
            DB::table('bahan')->where('id', $data->barang_id)->decrement('stok', $data->jumlah_masuk);
            DB::table('barang_masuk')->where('id', $id)->delete();
        }

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}