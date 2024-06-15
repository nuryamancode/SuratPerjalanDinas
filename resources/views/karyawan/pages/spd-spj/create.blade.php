@extends('karyawan.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger" role="alert">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif
                    <h4 class="card-title mb-5">Buat SPJ</h4>
                    <form action="{{ route('karyawan.spd-spj.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="spd_id" value="{{ $spdpelaksana->id }}" hidden>
                        <div class='form-group mb-3'>
                            <label for='nominal' class='mb-2'>Nominal Uang Muka</label>
                            <input type='text' name='nominal' id='nominal'
                                class='form-control @error('nominal') is-invalid @enderror'
                                value='{{ $spdpelaksana->uang_muka ? 'Rp. ' . number_format($spdpelaksana->uang_muka->nominal) : old('nominal') }}'
                                disabled>
                            @error('nominal')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='draft' class='mb-2'>Draf SPJ</label>
                            <input type='file' name='draft' id='draft'
                                class='form-control @error('draft') is-invalid @enderror' value='{{ old('draft') }}'
                                required>
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
                                <div class="col-md">
                                    <div class='form-group mb-3'>
                                        <label for='perincian_biaya' class='mb-2'>Perincian Biaya</label>
                                        <input type='text' name='perincian_biaya[]' class='form-control perincian_biaya'
                                            required>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class='form-group mb-3'>
                                        <label for='nominal' class='mb-2'>Nominal</label>
                                        <input type='number' name='nominal[]' class='form-control nominal' required>
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
                                        <input type='file' name='file[]' class='form-control file' required>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group mt-3">
                                        <button type="button" class="btn btn-danger mt-3 py-3 disabled">Hapus</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('karyawan.spd.index') }}" class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Buat SPJ</button>
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
                    '<div class="col-md">' +
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
