@extends('pengadministrasi-umum.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Edit Surat Tugas</h4>
                    <form action="{{ route('pengadministrasi-umum.surat.update', $item->uuid) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class='form-group mb-3'>
                            <label for='nomor_surat' class='mb-2'>Nomor Surat</label>
                            <input type='text' name='nomor_surat' id='nomor_surat'
                                class='form-control @error('nomor_surat') is-invalid @enderror'
                                value='{{ $item->nomor_surat ?? old('nomor_surat') }}'>
                            @error('nomor_surat')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='tanggal_surat' class='mb-2'>Tanggal Surat</label>
                            <input type='date' name='tanggal_surat' id='tanggal_surat'
                                class='form-control @error('tanggal_surat') is-invalid @enderror'
                                value='{{ $item->tanggal_surat ?? old('tanggal_surat') }}'>
                            @error('tanggal_surat')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group'>
                            <label for='pelaksana'>Pelaksana</label>
                            <select name='pelaksana[]' id='pelaksana'
                                class='form-control @error('pelaksana') is-invalid @enderror' multiple>
                                <option value='' disabled>Pilih Pelaksana</option>
                                @foreach ($data_karyawan as $karyawan)
                                    <option value='{{ $karyawan->id }}' @selected(in_array($karyawan->id, old('pelaksana', $selectedKaryawan ?? [])))>{{ $karyawan->nama }}
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
                            <label for='maksud_perjalanan_dinas' class='mb-2'>Maksud Perjalanan Dinas</label>
                            <textarea name='maksud_perjalanan_dinas' id='maksud_perjalanan_dinas' cols='30' rows='3'
                                class='form-control @error('maksud_perjalanan_dinas') is-invalid @enderror'>{{ $item->maksud_perjalanan_dinas ?? old('maksud_perjalanan_dinas') }}</textarea>
                            @error('maksud_perjalanan_dinas')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='tanggal_mulai' class='mb-2'>Tanggal Mulai Perjalanan Dinas</label>
                            <input type='date' name='tanggal_mulai' id='tanggal_mulai'
                                class='form-control @error('tanggal_mulai') is-invalid @enderror'
                                value='{{ $item->tanggal_mulai ?? old('tanggal_mulai') }}'>
                            @error('tanggal_mulai')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='tanggal' class='mb-2'>Tanggal Sampai Perjalanan
                                Dinas</label>
                            <input type='date' name='tanggal' id='tanggal'
                                class='form-control @error('tanggal') is-invalid @enderror'
                                value='{{ $item->tanggal_sampai ?? old('tanggal') }}'>
                            @error('tanggal')
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
                            <label for='file' class='mb-2'>File</label>
                            <input type='file' name='file' id='file'
                                class='form-control @error('file') is-invalid @enderror' value='{{ old('file') }}'>
                            @error('file')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        {{-- <div class='form-group mb-3'>
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
                        </div> --}}
                        {{-- <div class="form-group ml-4">
                            <div class="form-check">
                                <input type="checkbox" name="antar" value="1" class="form-check-input" id="antar"
                                    id="antar">
                                <label class="form-check-label" for="antar">Diantar/Dijemput</label>
                            </div>
                        </div> --}}
                        @if ($item->antar)
                            <div class='form-group mb-3'>
                                <label for='no_surat_jalan_dinas' class='mb-2'>No. Surat Jalan Dinas</label>
                                <input type='text' name='no_surat_jalan_dinas' id='no_surat_jalan_dinas'
                                    class='form-control @error('no_surat_jalan_dinas') is-invalid @enderror'
                                    value='{{ $item->no_surat_jalan_dinas ?? old('no_surat_jalan_dinas') }}'>
                                @error('no_surat_jalan_dinas')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label for='lampiran_surat_tugas' class='mb-2'>Lampiran Surat Tugas</label>
                                <input type='file' name='lampiran_surat_tugas' id='lampiran_surat_tugas'
                                    class='form-control @error('lampiran_surat_tugas') is-invalid @enderror'
                                    value='{{ old('lampiran_surat_tugas') }}'>
                                @error('lampiran_surat_tugas')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label for='tanggal_surat_jalan' class='mb-2'>Tanggal Surat Jalan</label>
                                <input type='date' name='tanggal_surat_jalan' id='tanggal_surat_jalan'
                                    class='form-control @error('tanggal_surat_jalan') is-invalid @enderror'
                                    value='{{ $item->tanggal_surat_jalan ?? old('tanggal_surat_jalan') }}'>
                                @error('tanggal_surat_jalan')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group'>
                                <label for='supir_karyawan_id'>Pengemudi</label>
                                <select name='supir_karyawan_id' id='supir_karyawan_id'
                                    class='form-control @error('supir_karyawan_id') is-invalid @enderror'>
                                    <option value='' selected disabled>Pilih Pengemudi</option>
                                    @foreach ($data_karyawan as $karyawan)
                                        <option @selected($karyawan->id == $item->supir_karyawan_id) value='{{ $karyawan->id }}'>
                                            {{ $karyawan->nama . ' - ' . 'Jabatan : ' . $karyawan->jabatan->nama ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('supir_karyawan_id')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group'>
                                <label for='uraian_tugas'>Uraian Tugas</label>
                                <select name='uraian_tugas' id='uraian_tugas'
                                    class='form-control @error('uraian_tugas') is-invalid @enderror'>
                                    <option value='' selected disabled>Pilih Uraian Tugas</option>
                                    <option @selected($item->uraian_tugas === 'Mengantar Menginap') value="Mengantar Menginap">Mengantar Menginap
                                    </option>
                                    <option @selected($item->uraian_tugas === 'Mengantar dan Menjemput') value="Mengantar dan Menjemput">Mengantar dan
                                        Menjemput
                                    </option>
                                    <option @selected($item->uraian_tugas === 'Mengantar') value="Mengantar">Mengantar</option>
                                    <option @selected($item->uraian_tugas === 'Menjemput') value="Menjemput">Menjemput</option>
                                </select>
                                @error('uraian_tugas')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label for='tanggal_mulai_tugas' class='mb-2'>Tanggal Mulai Tugas</label>
                                <input type='date' name='tanggal_mulai_tugas' id='tanggal_mulai_tugas'
                                    class='form-control @error('tanggal_mulai_tugas') is-invalid @enderror'
                                    value='{{ $item->tanggal_mulai_tugas ?? old('tanggal_mulai_tugas') }}'>
                                @error('tanggal_mulai_tugas')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label for='sampai_tanggal_tugas' class='mb-2'>Sampai Tanggal Tugas</label>
                                <input type='date' name='sampai_tanggal_tugas' id='sampai_tanggal_tugas'
                                    class='form-control @error('sampai_tanggal_tugas') is-invalid @enderror'
                                    value='{{ $item->tanggal_sampai_tugas ?? old('sampai_tanggal_tugas') }}'>
                                @error('sampai_tanggal_tugas')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        @endif
                        <div class="form-group text-right">
                            <a href="{{ route('pengadministrasi-umum.surat.index') }}" class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Update Surat Tugas</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">List Lampiran</h4>
                    <ul class="list-unstyled">
                        @forelse ($item->lampiran as $lampiran)
                            <li class="mb-2">
                                <a href="{{ asset('storage/' . $lampiran->file) }}" target="_blank"
                                    class="btn btn-sm btn-info">Lihat</a>
                                <form action="javascript:void(0)" method="post" class="d-inline" id="formDelete">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btnDelete btn-sm py-2 btn-link"
                                        data-action="{{ route('lampiran.destroy', $lampiran->uuid) }}">Hapus</button>
                                </form>
                            </li>
                        @empty
                            <li class="text-center">
                                Lampiran Tidak Ada
                            </li>
                        @endforelse
                    </ul>
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
