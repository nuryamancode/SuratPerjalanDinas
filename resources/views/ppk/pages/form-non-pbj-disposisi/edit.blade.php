@extends('ppk.layouts.app')
@section('content')
    <style>
        .back:hover {
            text-decoration: none;
        }
    </style>
    <a href="{{ route('ppk.pengajuan-form-non-pbj-disposisi.index', $item->form_non_pbj->id) }}" class="back">
        <div class="d-flex align-items-center">
            <i class="mdi mdi-arrow-left-bold-circle  pr-2 pt-1 icon-large"></i>
            <span>Kembali</span>
        </div>
    </a>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Edit Disposisi Pengajuan Form Non Pbj</h4>
                    <form action="{{ route('ppk.pengajuan-form-non-pbj-disposisi.update', $item->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class='form-group mb-3'>
                            <label for='no_surat' class='mb-2'>Nomor Surat</label>
                            <input type='text' name='no_surat' id='no_surat'
                                class='form-control @error('no_surat') is-invalid @enderror' value='{{ $item->no_surat }}'>
                            @error('no_surat')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='no_agenda' class='mb-2'>Nomor Agenda</label>
                            <input type='text' name='no_agenda' id='no_agenda'
                                class='form-control @error('no_agenda') is-invalid @enderror'
                                value='{{ $item->no_agenda }}'>
                            @error('no_agenda')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='perihal' class='mb-2'>Perihal</label>
                            <input type='text' name='perihal' id='perihal'
                                class='form-control @error('perihal') is-invalid @enderror' value='{{ $item->perihal }}'>
                            @error('perihal')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group'>
                            <label for='teruskan_ke'>Diteruskan Ke</label>
                            <select name='teruskan_ke' id='teruskan_ke'
                                class='form-control @error('teruskan_ke') is-invalid @enderror'>
                                <option value="" selected>Pilih Karyawan</option>
                                @foreach ($data_karyawan as $karyawan)
                                    <option  value='{{ $karyawan->id }}'>
                                        {{ $karyawan->nama . ' | ' . $karyawan->jabatan->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('teruskan_ke')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group'>
                            <label for='tipe_disposisi'>Tipe Disposisi</label>
                            <select name='tipe_disposisi' id='tipe_disposisi'
                                class='form-control @error('tipe_disposisi') is-invalid @enderror'>
                                <option value='' selected disabled>Pilih Tipe Disposisi</option>
                                <option @selected($item->tipe_disposisi === 'Rahasia') value="Rahasia">Rahasia</option>
                                <option @selected($item->tipe_disposisi === 'Terbatas Biasa') value="Terbatas Biasa">Terbatas Biasa</option>
                                <option @selected($item->tipe_disposisi === 'Segera') value="Segera">Segera</option>
                                <option @selected($item->tipe_disposisi === 'Sangat Segera') value="Sangat Segera">Sangat Segera</option>
                            </select>
                            @error('tipe_disposisi')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='catatan_disposisi' class='mb-2'>Catatan</label>
                            <textarea name='catatan_disposisi' id='catatan' cols='30' rows='3'
                                class='form-control @error('catatan') is-invalid @enderror'>{{ $item->catatan_disposisi }}</textarea>
                            @error('catatan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('ppk.form-non-pbj.index') }}" class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Submit</button>
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
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>
    <script>
        $(function() {
            $('#tujuan_karyawan_id').select2({
                theme: 'bootstrap',
                placeholder: 'Pilih'
            })
        })
    </script>
@endpush
