@extends('pengadministrasi-umum.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            {{--  <style>
                .back:hover {
                    text-decoration: none;
                }
            </style>
            <a href="{{ route('pengadministrasi-umum.pengajuan-surat-non-pbj.index') }}" class="back">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-arrow-left-bold-circle  pr-2 pt-1 icon-large"></i>
                    <span>Kembali</span>
                </div>
            </a>  --}}
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Tambah Pengajuan Surat Non PBJ</h4>
                    <form action="{{ route('pengadministrasi-umum.pengajuan-surat-non-pbj.store') }}" method="post"
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
                            <label for='dokumen_surat' class='mb-2'>Dokumen Surat</label>
                            <input type='file' name='dokumen_surat' id='dokumen_surat'
                                class='form-control @error('dokumen_surat') is-invalid @enderror'
                                value='{{ old('dokumen_surat') }}'>
                            @error('dokumen_surat')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='lampiran' class='mb-2'>lampiran <span class="small">(Bisa Lebih dari
                                    1)</span></label>
                            <input type='file' name='lampiran[]' id='lampiran'
                                class='form-control @error('lampiran') is-invalid @enderror' value='{{ old('lampiran') }}'
                                multiple>
                            @error('lampiran')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group'>
                            <label for='pengusul'>Pengusul</label>
                            <select name='pengusul[]' id='pengusul'
                                class='form-control @error('pengusul') is-invalid @enderror' multiple>
                                <option value='' disabled>Pilih Pengusul</option>
                                @foreach ($data_karyawan as $karyawan)
                                    <option @selected($karyawan->id == old('pengusul')) value='{{ $karyawan->id }}'>
                                        {{ $karyawan->nama . ' - ' . $karyawan->jabatan->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pengusul')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('pengadministrasi-umum.pengajuan-surat-non-pbj.index') }}"
                                class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Tambah Pengajuan PBJ</button>
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
            $('#pengusul').select2({
                placeholder: 'Pilih Pengusul'
            });
        })
    </script>
@endpush
