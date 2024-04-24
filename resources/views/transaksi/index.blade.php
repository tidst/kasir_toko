@extends('layouts.main', ['title' => 'Transaksi'])

@section('title-content')
    <i class="fas fa-cash-register mr-2"></i>
    Transaksi
@endsection

@section('content') {{-- Menambahkan bagian content --}}

    <div class="card card-orange card-outline">
        <div class="card-header form-inline">
            <a href="{{ route('transaksi.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i> Buat Transaksi Baru
            </a>
            <form action="{{ url()->current() }}" method="get" class="ml-auto"> {{-- Menggunakan url()->current() untuk menentukan URL saat ini --}}
                <div class="input-group">
                    <input type="text" class="form-control" name="search" value="{{ request()->input('search') }}"
                    placeholder="Nomor Transaksi"> {{-- Menggunakan request()->input('search') untuk mendapatkan nilai input --}}
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body p-0">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nomor Transaksi</th>
                        <th>Pelanggan</th>
                        <th>Kasir</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penjualans as $key => $penjualan)
                    <tr>
                        <td>{{ $loop->iteration }}</td> {{-- Menggunakan $loop->iteration untuk nomor iterasi --}}
                        <td>{{ $penjualan->nomor_transaksi }}</td>
                        <td>{{ $penjualan->nama_pelanggan }}</td>
                        <td>{{ $penjualan->nama_kasir }}</td>
                        <td>{{ $penjualan->total }}</td>
                        <td>
                            <i class="fas {{ $penjualan->status == 'selesai' ? 'fa-check text-success' : 'fa-times text-danger' }}"></i>
                        </td>
                        <td> {{ date('d/m/Y H:i:s', strtotime($penjualan->tanggal)) }} </td>
                        <td class="text-right">
                            <a href="{{ route('transaksi.show', ['transaksi' => $penjualan->id]) }}"
                                class="btn btn-xs btn-success">
                                <i class="fas fa-file-invoice mr-1"></i> Invoice
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $penjualans->links('vendor.pagination.bootstrap-4') }} {{-- Menggunakan 'links' bukan 'Links' --}}
        </div>
    </div>

@endsection {{-- Akhir dari bagian content --}}
