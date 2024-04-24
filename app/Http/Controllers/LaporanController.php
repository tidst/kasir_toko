<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use DB;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.form');
    }

    public function harian(Request $request)
    {
        $penjualan = Penjualan::join('users', 'users.id', 'penjualans.user_id')
            ->join('pelanggans', 'pelanggans.id', 'penjualans.pelanggan_id')
            ->whereDate('tanggal', $request->tanggal)
            ->where('status','selesai')
            ->select('penjualans.*', 'pelanggans.nama as nama_pelanggan', 'users.nama as nama_kasir')
            ->orderBy('id')
            ->get();

        return view('laporan.harian', [
            'penjualan' => $penjualan
        ]);
    }

    public function bulanan(Request $request)
{
    $penjualan = Penjualan::select(
        DB::raw('COUNT(id) as jumlah_transaksi'),
        DB::raw('SUM(total) as jumlah_total'),
        DB::raw("DATE_FORMAT(tanggal, '%d/%m/%Y') as tgl"),
        'total' // Menambahkan kolom total ke dalam seleksi
    )
        ->whereMonth('tanggal', $request->bulan)
        ->whereYear('tanggal', $request->tahun)
        ->where('status','selesai')
        ->groupBy('tgl', 'total') // Menambahkan 'total' ke dalam klausa GROUP BY
        ->get();

    $nama_bulan = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 
        'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    $bulan = isset($nama_bulan[$request->bulan - 1]) ? $nama_bulan[$request->bulan - 1] : null;

    return view('laporan.bulanan', [
        'penjualan' => $penjualan,
        'bulan' => $bulan
    ]);
}
}
