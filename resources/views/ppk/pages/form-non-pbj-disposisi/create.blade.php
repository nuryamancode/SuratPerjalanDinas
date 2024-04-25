@extends('ppk.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Disposisi Pengajuan Form Non Pbj</h4>
                    <form action="{{ route('ppk.form-non-pbj-disposisi.store', $item->uuid) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
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
                        <div class='form-group'>
                            <label for='tujuan_karyawan_id'>Diteruskan Ke</label>
                            <select name='tujuan_karyawan_id' id='tujuan_karyawan_id'
                                class='form-control @error('tujuan_karyawan_id') is-invalid @enderror'>
                                <option value="" selected>Pilih Karyawan</option>
                                @foreach ($data_karyawan as $karyawan)
                                    <option @selected($karyawan->id == old('tujuan_karyawan_id')) value='{{ $karyawan->id }}'>
                                        {{ $karyawan->nama . ' | ' . $karyawan->jabatan->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tujuan_karyawan_id')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group'>
                            <label for='tipe'>Tipe</label>
                            <select name='tipe' id='tipe' class='form-control @error('tipe') is-invalid @enderror'>
                                <option value='' selected disabled>Pilih tipe</option>
                                <option @selected(old('tipe') === 'Rahasia') value="Rahasia">Rahasia</option>
                                <option @selected(old('tipe') === 'Terbatas Biasa') value="Terbatas Biasa">Terbatas Biasa</option>
                                <option @selected(old('tipe') === 'Segera') value="Segera">Segera</option>
                                <option @selected(old('tipe') === 'Sangat Segera') value="Sangat Segera">Sangat Segera</option>
                            </select>
                            @error('tipe')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='catatan' class='mb-2'>Catatan</label>
                            <textarea name='catatan' id='catatan' cols='30' rows='3'
                                class='form-control @error('catatan') is-invalid @enderror'>{{ old('catatan') }}</textarea>
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
