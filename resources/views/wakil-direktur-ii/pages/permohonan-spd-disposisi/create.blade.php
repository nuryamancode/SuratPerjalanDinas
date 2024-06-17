@extends('wakil-direktur-ii.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <style>
                .back:hover {
                    text-decoration: none;
                }
            </style>
            <a href="{{ route('wakil-direktur-ii.permohonan-spd-disposisi.index', [
                'permohonan_spd_uuid' => $permohonan->id,
            ]) }}"
                class="back">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-arrow-left-bold-circle  pr-2 pt-1 icon-large"></i>
                    <span>Kembali</span>
                </div>
            </a>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Disposisi Permohonan SPD</h4>
                    <form
                        action="{{ route('wakil-direktur-ii.permohonan-spd-disposisi.store', [
                            'permohonan_spd_uuid' => $permohonan->id,
                        ]) }}"
                        method="post">
                        @csrf
                        <input type="hidden" name="tujuan_karyawan_id" value="{{ $ppk->karyawan->id }}">
                        <div class='form-group mb-3'>
                            <label for='tujuan_karyawan' class='mb-2'>Tujuan Karyawan</label>
                            <input type='text' name='tujuan_karyawan' id='tujuan_karyawan'
                                class='form-control @error('tujuan_karyawan') is-invalid @enderror'
                                value='{{ $ppk->karyawan->nama ?? old('tujuan_karyawan') }}' readonly>
                            @error('tujuan_karyawan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='nomor_surat' class='mb-2'>Nomor Surat</label>
                            <input type='text' name='nomor_surat' id='nomor_surat'
                                class='form-control @error('nomor_surat') is-invalid @enderror'
                                value='{{ $permohonan->surat->nomor_surat ?? old('nomor_surat') }}' disabled>
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
                            <label for='tanggal_surat' class='mb-2'>Tanggal Surat</label>
                            <input type='text' name='tanggal_surat' id='tanggal_surat'
                                class='form-control @error('tanggal_surat') is-invalid @enderror'
                                value='{{ \Carbon\Carbon::parse($permohonan->surat->created_at ?? old('tanggal_surat'))->format('Y-m-d') }}'
                                disabled>
                            @error('tanggal_surat')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='asal_surat' class='mb-2'>Asal Surat</label>
                            <input type='text' name='asal_surat' id='asal_surat'
                                class='form-control @error('asal_surat') is-invalid @enderror'
                                value='{{ $permohonan->surat->asal_surat ?? old('asal_surat') }}' disabled>
                            @error('asal_surat')
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
                            <a href="{{ route('wakil-direktur-ii.permohonan-spd-disposisi.index', [
                                'permohonan_spd_uuid' => $permohonan->id,
                            ]) }}"
                                class="btn btn-warning">Batal</a>
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
