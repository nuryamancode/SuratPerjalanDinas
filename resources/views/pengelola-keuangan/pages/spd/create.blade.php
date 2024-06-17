@extends('pengelola-keuangan.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <style>
                .back:hover {
                    text-decoration: none;
                }
            </style>
            <a href="{{ route('pengadministrasi-umum.surat.index') }}" class="back">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-arrow-left-bold-circle  pr-2 pt-1 icon-large"></i>
                    <span>Kembali</span>
                </div>
            </a>
            <div class="card">
                @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $item)
                            {{ $item }}
                        @endforeach
                    </ul>
                @endif
                <div class="card-body">
                    <h4 class="card-title mb-5">Buat SPD</h4>
                    <form action="{{ route('pengelola-keuangan.buat-spd.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_spd" value="{{ $spd->id }}">
                        <div class='form-group'>
                            <label for='pelaksana'>Pelaksana Dinas</label>
                            <select name='pelaksana[]' id='pelaksana'
                                class='form-control @error('pelaksana') is-invalid @enderror' multiple>
                                <option value='' disabled>Pilih Pelaksana</option>
                                @foreach ($data_karyawan as $karyawan)
                                    <option value='{{ $karyawan->id }}' @selected(in_array($karyawan->id, old('pelaksana', $selectedKaryawan ?? [])))>
                                        {{ $karyawan->nama . ' | ' . $karyawan->jabatan->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pelaksana')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='tingkat_biaya' class='mb-2'>Tingkat Biaya</label>
                            <input type='text' name='tingkat_biaya' id='tingkat_biaya'
                                class='form-control @error('tingkat_biaya') is-invalid @enderror'
                                value='{{ old('tingkat_biaya') }}'>
                            @error('tingkat_biaya')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='maksud_perjalanan_dinas' class='mb-2'>Maksud Perjalanan Dinas</label>
                            <textarea name='maksud_perjalanan_dinas' id='maksud_perjalanan_dinas' cols='30' rows='3' readonly
                                class='form-control @error('maksud_perjalanan_dinas') is-invalid @enderror'>{{ $spd->surat->maksud_perjalanan_dinas }}</textarea>
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
                                value='{{ old('alat_angkut') }}'>
                            @error('alat_angkut')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='tempat_berangkat' class='mb-2'>Tempat Berangkat</label>
                            <input type='text' name='tempat_berangkat' id='tempat_berangkat' readonly
                                class='form-control @error('tempat_berangkat') is-invalid @enderror'
                                value='{{ $spd->surat->tempat_berangkat }}'>
                            @error('tempat_berangkat')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='tempat_tujuan' class='mb-2'>Tempat Tujuan</label>
                            <input type='text' name='tempat_tujuan' id='tempat_tujuan' readonly
                                class='form-control @error('tempat_tujuan') is-invalid @enderror'
                                value='{{ $spd->surat->tempat_tujuan }}'>
                            @error('tempat_tujuan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='lama_hari' class='mb-2'>Lama Perjalanan</label>
                            <input type='number' name='lama_hari' id='lama_hari' readonly
                                class='form-control @error('lama_hari') is-invalid @enderror'
                                value='{{ $spd->surat->lama_hari }}'>
                            @error('lama_hari')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='tanggal_mulai' class='mb-2'>Tanggal Berangkat</label>
                            <input type='text' name='tanggal_mulai' id='tanggal_mulai' readonly
                                class='form-control @error('tanggal_mulai') is-invalid @enderror'
                                value='{{ $spd->surat->tanggal_mulai }}'>
                            @error('tanggal_mulai')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='pembebanan_anggaran' class='mb-2'>Pembebanan Anggaran</label>
                            <input type='text' name='pembebanan_anggaran' id='pembebanan_anggaran'
                                class='form-control @error('pembebanan_anggaran') is-invalid @enderror'
                                value='{{ old('pembebanan_anggaran') }}'>
                            @error('pembebanan_anggaran')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='instansi' class='mb-2'>Instansi</label>
                            <input type='text' name='instansi' id='instansi'
                                class='form-control @error('instansi') is-invalid @enderror'
                                value='{{ old('instansi') }}'>
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
                                value='{{ old('mata_anggaran_kegiatan') }}'>
                            @error('mata_anggaran_kegiatan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='dikeluarkan_di' class='mb-2'>Dikeluarkan Di</label>
                            <input type='text' name='dikeluarkan_di' id='dikeluarkan_di'
                                class='form-control @error('dikeluarkan_di') is-invalid @enderror'
                                value='{{ old('dikeluarkan_di') }}'>
                            @error('mata_anggaran_kegiatan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='keterangan_lainnya' class='mb-2'>Keterangan Lain-Lain</label>
                            <textarea name='keterangan_lainnya' id='keterangan_lainnya' cols='30' rows='3'
                                class='form-control @error('keterangan_lainnya') is-invalid @enderror'>{{ old('keterangan_lainnya') }}</textarea>
                            @error('keterangan_lainnya')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('pengadministrasi-umum.surat.index') }}" class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary"> Buat SPD</button>
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
        $(document).ready(function() {
            $('#pelaksana').select2({
                placeholder: "Pilih Pelaksana"
            });
            $('#pelaksana').prop('disabled', true);
        });
    </script>
@endpush
