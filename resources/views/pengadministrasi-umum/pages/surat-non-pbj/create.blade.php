@extends('pengadministrasi-umum.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Tambah Surat Non PBJ</h4>
                    <form action="{{ route('pengadministrasi-umum.surat-non-pbj.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class='form-group mb-3'>
                            <label for='nomor_surat' class='mb-2'>Nomor Surat</label>
                            <input type='text' name='nomor_surat' id='nomor_surat'
                                class='form-control @error('nomor_surat') is-invalid @enderror'
                                value='{{ old('nomor_surat') }}'>
                            @error('nomor_surat')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='nomor_agenda' class='mb-2'>Nomor Agenda</label>
                            <input type='text' name='nomor_agenda' id='nomor_agenda'
                                class='form-control @error('nomor_agenda') is-invalid @enderror'
                                value='{{ old('nomor_agenda') }}'>
                            @error('nomor_agenda')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='tanggal' class='mb-2'>Tanggal</label>
                            <input type='date' name='tanggal' id='tanggal'
                                class='form-control @error('tanggal') is-invalid @enderror' value='{{ old('tanggal') }}'>
                            @error('tanggal')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='perihal' class='mb-2'>Perihal</label>
                            <input type='text' name='perihal' id='perihal'
                                class='form-control @error('perihal') is-invalid @enderror' value='{{ old('perihal') }}'>
                            @error('perihal')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='file' class='mb-2'>File</label>
                            <input type='file' name='file' id='file'
                                class='form-control @error('file') is-invalid @enderror' value='{{ old('file') }}'>
                            @error('file')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group'>
                            <label for='pelaksana'>Pengusul</label>
                            <select name='pelaksana[]' id='pelaksana'
                                class='form-control @error('pelaksana') is-invalid @enderror' multiple required>
                                <option value='' disabled>Pilih Pengusul</option>
                                @foreach ($data_karyawan as $karyawan)
                                    <option @selected($karyawan->id == old('pelaksana')) value='{{ $karyawan->id }}'>
                                        {{ $karyawan->nama . ' - ' . $karyawan->jabatan->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pelaksana')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group'>
                            <label for='karyawan_id'>Diteruskan Ke</label>
                            <select name='karyawan_id' id='karyawan_id'
                                class='form-control @error('karyawan_id') is-invalid @enderror' required>
                                <option value='' disabled>Pilih Karyawan</option>
                                @foreach ($data_karyawan2 as $karyawan)
                                    <option @selected($karyawan->id == old('karyawan_id')) value='{{ $karyawan->id }}'>
                                        {{ $karyawan->nama . ' - ' . $karyawan->jabatan->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('karyawan_id')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('pengadministrasi-umum.surat-non-pbj.index') }}"
                                class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Tambah Surat Non PBJ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2/select2.min.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>
    <script>
        $(function() {
            $('#pelaksana').select2({
                placeholder: 'Pilih Pengusul'
            });
        })
    </script>
@endpush
