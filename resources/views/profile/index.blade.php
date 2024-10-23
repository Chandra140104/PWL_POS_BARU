@extends('layout.template')

@section('content')
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>

    <div class="container rounded bg-white border">
        <div class="row" id="profile">
            <!-- Kolom Kiri: Menampilkan dan Mengunggah Foto Profil -->
            <div class="col-md-4 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex flex-column align-items-center text-center p-3">
                        <!-- Tampilkan Foto Profil atau Gambar Default -->
                        @if ($user->file_profil)
                            <img class="rounded mt-3 mb-2" width="250px" 
                                 src="{{ asset('image/profile/' . $user->file_profil) }}" alt="User Image">
                        @else
                            <img class="rounded mt-3 mb-2" width="250px" 
                                 src="{{ asset('image/profile/default.png') }}" alt="Default Image">
                        @endif
                        <span class="font-weight-bold">{{ $user->nama }}</span>
                        <span class="text-black-50">{{ $user->username }}</span>
                    </div>

                    <!-- Form untuk Mengunggah Foto Profil -->
                    <form action="{{ url('/profile/upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mt-3">
                            <label for="file_profil">Upload Foto Profil:</label>
                            <input type="file" class="form-control" name="file_profil">
                            @error('file_profil')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Update Foto</button>
                    </form>
                </div>
            </div>

            <!-- Kolom Kanan: Menampilkan Detail Profil -->
            <div class="col-md-8 border-right">
                <div class="p-3 py-4">
                    <div class="d-flex align-items-center">
                        <h4 class="text-right">Pengaturan Profil</h4>
                    </div>
                    <div class="row mt-3">
                        <table class="table table-bordered table-striped table-hover table-sm">
                            <tr>
                                <th>ID</th>
                                <td>{{ $user->user_id }}</td>
                            </tr>
                            <tr>
                                <th>Level</th>
                                <td>{{ $user->level->level_nama }}</td>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <td>{{ $user->username }}</td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td>{{ $user->nama }}</td>
                            </tr>
                            <tr>
                                <th>Password</th>
                                <td>********</td>
                            </tr>
                        </table>
                    </div>
                    <div class="mt-3 text-center">
                        <button onclick="modalAction('{{ url('/profile/' . session('user_id') . '/edit_ajax') }}')"
                            class="btn btn-primary profile-button">Edit Profil</button>
                    </div>
                </div>
            </div>
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

        var dataUser;
        $(document).ready(function() {
            dataUser = $('#profile').on({
                autoWidth: false,
                serverSide: true,
                ajax: {
                    "url": "{{ url('penjualan/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d.user_id = $('#user_id').val();
                    }
                },
            });

            $('#profile').on('change', function() {
                dataUser.ajax.reload();
            });
        });
    </script>
@endpush
