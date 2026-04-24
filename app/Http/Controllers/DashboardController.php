<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
{
    // Ambil data dari database
    $totalBahan = DB::table('bahan')->sum('stok') ?? 0;
    $barangMasuk = DB::table('barang_masuk')->count() ?? 0;
    $barangKeluar = DB::table('barang_keluar')->count() ?? 0;
    $totalKategori = DB::table('kategori')->count() ?? 0;

    // Pastikan semua variabel ini masuk ke dalam compact()
    return view('dashboard', compact(
        'totalBahan', 
        'barangMasuk', 
        'barangKeluar', 
        'totalKategori'
    ));
}
}