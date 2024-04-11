@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Buat SPJ</h4>
                    <form action="{{ route('surat-pertanggung-jawaban.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class='form-group'>
                            <label for='pengajuan_form_non_pbj_id'>Pengajuan Form Non PBJ</label>
                            <select name='pengajuan_form_non_pbj_id' id='pengajuan_form_non_pbj_id'
                                class='form-control @error('pengajuan_form_non_pbj_id') is-invalid @enderror'>
                                <option value='' selected disabled>Pilih Pengajuan Form Non PBJ</option>
                                @foreach ($data_pengajuan as $pengajuan)
                                    <option @selected($pengajuan->id == old('pengajuan_form_non_pbj_id')) value='{{ $pengajuan->id }}'>
                                        {{ $pengajuan->perihal }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pengajuan_form_non_pbj_id')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='draft' class='mb-2'>Draf SPJ</label>
                            <input type='file' name='draft' id='draft'
                                class='form-control @error('draft') is-invalid @enderror' value='{{ old('draft') }}'>
                            @error('draft')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div id="dynamic-form">
                            <div class="row mb-2">
                                <div class="col-md">
                                    <button type="button" class="btn btn-primary add-row">Tambah Perincian Dana</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class='form-group mb-3'>
                                        <label for='perincian_biaya' class='mb-2'>Perincian Biaya</label>
                                        <input type='text' name='perincian_biaya[]' class='form-control perincian_biaya'>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class='form-group mb-3'>
                                        <label for='nominal' class='mb-2'>Nominal</label>
                                        <input type='number' name='nominal[]' class='form-control nominal'>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class='form-group mb-3'>
                                        <label for='keterangan' class='mb-2'>Keterangan</label>
                                        <input type='text' name='keterangan[]' class='form-control keterangan'>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class='form-group mb-3'>
                                        <label for='file' class='mb-2'>File Dokumen</label>
                                        <input type='file' name='file[]' class='form-control file'>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group mt-3">
                                        {{-- <button type="button" class="btn btn-danger mt-2 py-3 remove-row">Hapus</button> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('surat-pertanggung-jawaban.index') }}" class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Buat SPJ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Detail SPD Pelaksana</h4>
                    <form action="javascript:void(0)" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class='form-group mb-3'>
                            <label for='tingkat_biaya' class='mb-2'>Tingkat Biaya</label>
                            <input type='text' name='tingkat_biaya' id='tingkat_biaya'
                                class='form-control @error('tingkat_biaya') is-invalid @enderror'
                                value='{{ old('tingkat_biaya') }}' readonly>
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
                                value='{{ old('maksud_perjalanan_dinas') }}' readonly>
                            @error('maksud_perjalanan_dinas')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='tempat_berangkat' class='mb-2'>Tempat Berangkat</label>
                            <input type='text' name='tempat_berangkat' id='tempat_berangkat'
                                class='form-control @error('tempat_berangkat') is-invalid @enderror'
                                value='{{ old('tempat_berangkat') }}' readonly>
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
                                value='{{ old('tempat_tujuan') }}' readonly>
                            @error('tempat_tujuan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
@push('scripts')
    <script>
        $(document).ready(function() {
            // Menambahkan baris form
            $("#dynamic-form").on("click", ".add-row", function() {
                var newRow = '<div class="row">' +
                    '<div class="col-md-3">' +
                    '<div class="form-group mb-3">' +
                    '<label for="tingkat_biaya" class="mb-2">Tingkat Biaya</label>' +
                    '<input type="text" name="perincian_biaya[]" class="form-control perincian_biaya">' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md">' +
                    '<div class="form-group mb-3">' +
                    '<label for="nominal" class="mb-2">Nominal</label>' +
                    '<input type="number" name="nominal[]" class="form-control nominal">' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md">' +
                    '<div class="form-group mb-3">' +
                    '<label for="keterangan" class="mb-2">Keterangan</label>' +
                    '<input type="text" name="keterangan[]" class="form-control keterangan">' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md">' +
                    '<div class="form-group mb-3">' +
                    '<label for="file" class="mb-2">File Dokumen</label>' +
                    '<input type="file" name="file[]" class="form-control file">' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md">' +
                    '<div class="form-group mt-3">' +
                    '<button type="button" class="btn btn-danger mt-3 py-3 remove-row">Hapus</button>' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                $("#dynamic-form").append(newRow);
            });

            // Menghapus baris form
            $("#dynamic-form").on("click", ".remove-row", function() {
                $(this).closest('.row').remove();
            });

            // get detail spd detail
            $('#spd_detail_id').on('change', function() {
                let spd_detail_id = $(this).val();
                $.ajax({
                    url: '{{ route('surat-perjalanan-dinas-detail.getById') }}',
                    type: 'GET',
                    data: {
                        spd_detail_id
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        $('#tingkat_biaya').val(data.tingkat_biaya);
                        $('#maksud_perjalanan_dinas').val(data.maksud_perjalanan_dinas);
                        $('#tempat_berangkat').val(data.tempat_berangkat);
                        $('#tempat_tujuan').val(data.tempat_tujuan);
                    }
                })
            })
        });
    </script>
@endpush
