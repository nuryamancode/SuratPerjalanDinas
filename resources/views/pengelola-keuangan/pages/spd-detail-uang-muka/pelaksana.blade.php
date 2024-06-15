@extends('pengelola-keuangan.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Submit Uang Muka</h4>
                    <form action="{{ route('pengelola-keuangan.uang-muka-spd.store-pelaksana') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="spd_pelaksana" value="{{ $item->id }}">
                        <div class='form-group'>
                            <label for='pelaksana'>Pelaksana Dinas</label>
                            <select name='pelaksana[]' id='pelaksana'
                                class='form-control @error('pelaksana') is-invalid @enderror' multiple>
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
                            <label for='nomor_surat' class='mb-2'>Nomor Surat</label>
                            <input type='text' name='nomor_surat' id='nomor_surat'
                                class='form-control @error('nomor_surat') is-invalid @enderror' readonly
                                value='{{ $item->spd->surat->nomor_surat ?? old('nomor_surat') }}'>
                            @error('nomor_surat')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='perihal' class='mb-2'>Perihal</label>
                            <input type='text' name='perihal' id='perihal'
                                class='form-control @error('perihal') is-invalid @enderror' readonly
                                value='{{ $item->spd->disposisi->perihal_1 }}'>
                            @error('perihal')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='maksud_perjalanan_dinas' class='mb-2'>Maksud Perjalanan Dinas</label>
                            <textarea name='maksud_perjalanan_dinas' id='maksud_perjalanan_dinas' cols='30' rows='3' readonly
                                class='form-control @error('maksud_perjalanan_dinas') is-invalid @enderror'>{{ $item->spd->surat->maksud_perjalanan_dinas }}</textarea>
                            @error('maksud_perjalanan_dinas')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='nominal_pelaksana' class='mb-2'>Nominal</label>
                            <input type='number' name='nominal_pelaksana' id='nominal_pelaksana'
                                class='form-control @error('nominal_pelaksana') is-invalid @enderror' value=''>
                            @error('nominal_pelaksana')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('bendahara-keuangan.permohonan-spd.index') }}" class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Distribusikan</button>
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
