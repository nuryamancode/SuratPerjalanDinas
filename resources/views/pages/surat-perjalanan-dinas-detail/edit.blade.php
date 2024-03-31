@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Edit Surat Perjalanan Dinas Detail</h4>
                    <form action="{{ route('surat-perjalanan-dinas-detail.update', $item->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class='form-group mb-3'>
                            <label for='tingkat_biaya' class='mb-2'>Tingkat Biaya</label>
                            <input type='text' name='tingkat_biaya' id='tingkat_biaya'
                                class='form-control @error('tingkat_biaya') is-invalid @enderror'
                                value='{{ $item->tingkat_biaya ?? old('tingkat_biaya') }}'>
                            @error('tingkat_biaya')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='maksud_perjalanan_dinas' class='mb-2'>Maksud Perjalanan Dinas</label>
                            <input type='text' name='maksud_perjalanan_dinas' id='maksud_perjalanan_dinas'
                                class='form-control @error('maksud_perjalanan_dinas') is-invalid @enderror'
                                value='{{ $item->maksud_perjalanan_dinas ?? old('maksud_perjalanan_dinas') }}'>
                            @error('maksud_perjalanan_dinas')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='alat_angkut' class='mb-2'>Alat Angkut</label>
                            <input type='text' name='alat_angkut' id='alat_angkut'
                                class='form-control @error('alat_angkut') is-invalid @enderror'
                                value='{{ $item->alat_angkut ?? old('alat_angkut') }}'>
                            @error('alat_angkut')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='tempat_berangkat' class='mb-2'>Tempat Berangkat</label>
                            <input type='text' name='tempat_berangkat' id='tempat_berangkat'
                                class='form-control @error('tempat_berangkat') is-invalid @enderror'
                                value='{{ $item->tempat_berangkat ?? old('tempat_berangkat') }}'>
                            @error('tempat_berangkat')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='tempat_tujuan' class='mb-2'>Tempat Tujuan</label>
                            <input type='text' name='tempat_tujuan' id='tempat_tujuan'
                                class='form-control @error('tempat_tujuan') is-invalid @enderror'
                                value='{{ $item->tempat_tujuan ?? old('tempat_tujuan') }}'>
                            @error('tempat_tujuan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='lama_perjalanan' class='mb-2'>Lama Perjalanan</label>
                            <input type='number' name='lama_perjalanan' id='lama_perjalanan'
                                class='form-control @error('lama_perjalanan') is-invalid @enderror'
                                value='{{ $item->lama_perjalanan ?? old('lama_perjalanan') }}'>
                            @error('lama_perjalanan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='tanggal_berangkat' class='mb-2'>Tanggal Berangkat</label>
                            <input type='date' name='tanggal_berangkat' id='tanggal_berangkat'
                                class='form-control @error('tanggal_berangkat') is-invalid @enderror'
                                value='{{ $item->tanggal_berangkat ?? old('tanggal_berangkat') }}'>
                            @error('tanggal_berangkat')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='pembebasan_anggaran' class='mb-2'>Pembebasan Anggaran</label>
                            <input type='text' name='pembebasan_anggaran' id='pembebasan_anggaran'
                                class='form-control @error('pembebasan_anggaran') is-invalid @enderror'
                                value='{{ $item->pembebasan_anggaran ?? old('pembebasan_anggaran') }}'>
                            @error('pembebasan_anggaran')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='instansi' class='mb-2'>Instansi</label>
                            <input type='text' name='instansi' id='instansi'
                                class='form-control @error('instansi') is-invalid @enderror'
                                value='{{ $item->instansi ?? old('instansi') }}'>
                            @error('instansi')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='mata_anggaran_kegiatan' class='mb-2'>Mata Anggaran Kegiatan</label>
                            <input type='text' name='mata_anggaran_kegiatan' id='mata_anggaran_kegiatan'
                                class='form-control @error('mata_anggaran_kegiatan') is-invalid @enderror'
                                value='{{ $item->mata_anggaran_kegiatan ?? old('mata_anggaran_kegiatan') }}'>
                            @error('mata_anggaran_kegiatan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='keterangan_lain_lain' class='mb-2'>Keterangan Lain-Lain</label>
                            <textarea name='keterangan_lain_lain' id='keterangan_lain_lain' cols='30' rows='3'
                                class='form-control @error('keterangan_lain_lain') is-invalid @enderror'>{{ $item->keterangan_lain_lain ?? old('keterangan_lain_lain') }}</textarea>
                            @error('keterangan_lain_lain')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('surat-perjalanan-dinas.index', [
                                'surat_perjalanan_dinas_id' => $item->surat_perjalanan_dinas_id,
                            ]) }}"
                                class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary" name="jenis" value="">Update Data</button>
                            <button class="btn btn-primary" name="jenis" value="all">Update Keseluruhan</button>
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
                placeholder: 'Pilih Pelaksana'
            });
        })
    </script>
@endpush
