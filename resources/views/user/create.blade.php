@extends('layout.template') 
 
@section('content') 
  <div class="card card-outline card-primary"> 
    <div class="card-header"> 
      <h3 class="card-title">{{ $page->title }}</h3> 
      <div class="card-tools"></div> 
    </div> 
    <div class="card-body"> 
      <form method="POST" action="{{ url('supplier') }}" class="form-horizontal"> 
        @csrf 
        <div class="form-group row"> 
          <label class="col-1 control-label col-form-label">Level</label> 
          <div class="col-11"> 
            <select class="form-control" id="level_id" name="level_id" required> 
              <option value="">- Pilih Level -</option> 
              @foreach($level as $item) 
                <option value="{{ $item->level_id }}">{{ $item->level_nama }}</option> 
              @endforeach 
            </select> 
            @error('level_id') 
              <small class="form-text text-danger">{{ $message }}</small> 
            @enderror 
          </div> 
        </div> 
        <div class="form-group row"> 
          <label class="col-1 control-label col-form-label">Supplier kode</label> 
          <div class="col-11"> 
            <input type="text" class="form-control" id="supplier_name" name="supplier_kode" value="{{ 
old('supplier_kode') }}" required> 
            @error('supplier_kode') 
              <small class="form-text text-danger">{{ $message }}</small> 
            @enderror 
          </div> 
        </div> 
        <div class="form-group row"> 
          <label class="col-1 control-label col-form-label">Alamat Supplier</label> 
          <div class="col-11"> 
            <input type="text" class="form-control" id="supplier_alamat" name="supplier_alamat" value="{{ old('supplier_alamat')}}" required>
            @error('supplier_alamat') 
              <small class="form-text text-danger">{{ $message }}</small> 
            @enderror 
          </div> 
        </div> 
        <div class="form-group row"> 
          <label class="col-1 control-label col-form-label">No Telp</label> 
          <div class="col-11"> 
            <input type="no_telp" class="form-control" id="no_telp" name="no_telp" required> 
            @error('no_telp') 
              <small class="form-text text-danger">{{ $message }}</small> 
            @enderror 
          </div> 
        </div> 
        <div class="form-group row"> 
          <label class="col-1 control-label col-form-label"></label> 
          <div class="col-11"> 
            <button type="submit" class="btn btn-primary btn-sm">Simpan</button> 
            <a class="btn btn-sm btn-default ml-1" href="{{ url('supplier') }}">Kembali</a> 
          </div> 
        </div> 
     </form> 
    </div> 
  </div> 
@endsection 
@push('css') 
@endpush 
@push('js') 
@endpush 