@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($stokBarang)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data stok barang yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>ID Stok</th>
                        <td>{{ $stokBarang->stok_id }}</td>
                    </tr>
                    <tr>
                        <th>ID Supplier</th>
                        <td>{{ $stokBarang->supplier->supplier_id }}</td>
                    </tr>
                    <tr>
                        <th>ID Barang</th>
                        <td>{{ $stokBarang->barang->barang_id }}</td>
                    </tr>
                    <tr>
                        <th>ID User</th>
                        <td>{{ $stokBarang->user->user_id }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Stok</th>
                        <td>{{ $stokBarang->stok_tanggal }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Stok</th>
                        <td>{{ $stokBarang->stok_jumlah }}</td>
                    </tr>
                </table>
            @endempty
            <a href="{{ url('stokBarang') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
@endpush
