@extends('layout.template')
@section('content')
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" 
    data-keyboard="false" data-width="75%" aria-hidden="true"></div>
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/stokBarang/import') }}')" class="btn btn-info">Import Data Stok Barang</button> 
                <a href="{{ url('/stokBarang/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export Data Stok Barang (Excel)</a> 
                <a href="{{ url('/stokBarang/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export Data Stok Barang (PDF)</a> 
                <button onclick="modalAction('{{ url('stokBarang/create_ajax') }}')" class="btn btn-success mt-1">Tambah Stok Barang (Ajax)</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select class="form-control" id="filter_supplier_id" name="supplier_id" required>
                                <option value="">- Semua Supplier -</option>
                                {{-- @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                                @endforeach --}}
                            </select>
                            <small class="form-text text-muted">Filter berdasarkan Supplier</small>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="table_stokBarang">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ID Stok</th>
                        <th>ID Supplier</th>
                        <th>ID Barang</th>
                        <th>ID User</th>
                        <th>Tanggal Stok</th>
                        <th>Jumlah Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }
        var dataStokBarang;
        $(document).ready(function() {
             dataStokBarang = $('#table_stokBarang').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('stokBarang/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d){
                        d.supplier_id = $('#filter_supplier_id').val();
                    }
                },
                columns: [{
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "stok_id",
                    className: "",
                    // width: "10%",
                    orderable: true,
                    searchable: true
                },{
                    data: "supplier.supplier_id", // Ambil nama supplier dari relasi
                    className: "",
                    orderable: true,
                    searchable: true
                },{
                    data: "barang.barang_id", // Ambil nama barang dari relasi
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "user.user_id", // Ambil nama user dari relasi
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "stok_tanggal", // Tanggal stok
                    className: "text-center",
                    orderable: true,
                    searchable: true
                }, {
                    data: "stok_jumlah", // Jumlah stok
                    className: "text-right",
                    orderable: true,
                    searchable: true
                },{
                    data: "aksi",
                    className: "",
                    orderable: false,
                    searchable: false
                }]
            });
            $('#filter_supplier_id').on('change', function(){
              dataStokBarang.ajax.reload();
            });
        });
    </script>
@endpush
