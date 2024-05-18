@extends('timppk.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Buat SPJ</h4>
                    <form action="{{ route('timppk.surat-non-pbj-spj.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="surat_non_pbj_uuid" value="{{ $suratNonPbj->id }}" hidden>
                        <div class='form-group mb-3'>
                            <label for='nominal' class='mb-2'>Nominal Uang Muka</label>
                            <input type='text' name='nominal' id='nominal'
                                class='form-control @error('nominal') is-invalid @enderror'
                                value='{{ $suratNonPbj->nominal ? 'Rp. ' . number_format($suratNonPbj->nominal) : old('nominal') }}'
                                disabled>
                            @error('nominal')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='untuk_pembayaran' class='mb-2'>Untuk Pembayaran</label>
                            <textarea name='untuk_pembayaran' id='untuk_pembayaran' cols='30' rows='3'
                                class='form-control @error('untuk_pembayaran') is-invalid @enderror'>{{ old('untuk_pembayaran') }}</textarea>
                            @error('untuk_pembayaran')
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
                                        <button type="button" class="btn btn-danger mt-3 py-3 disabled">Hapus</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('timppk.surat-non-pbj.index') }}" class="btn btn-warning">Batal</a>
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
            $('#suratNonPbj_id').on('change', function() {
                let suratNonPbj_id = $(this).val();
                $.ajax({
                    url: '{{ route('surat-perjalanan-dinas-detail.getById') }}',
                    type: 'GET',
                    data: {
                        suratNonPbj_id
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
