@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Tambah Uang Muka Form Non PBJ</h4>
                    <form action="{{ route('pengajuan-form-non-pbj.uang-muka.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class='form-group'>
                            <label for='pengajuan_barang_jasa_id'>Pengajuan Form Non PBJ</label>
                            <select name='pengajuan_barang_jasa_id' id='pengajuan_barang_jasa_id'
                                class='form-control @error('pengajuan_barang_jasa_id') is-invalid @enderror'>
                                <option value='' selected disabled>Pilih Pengajuan Form Non PBJ</option>
                                @foreach ($data_pengajuan_form_non_pbj as $non_pbj)
                                    <option @selected($non_pbj->id == old('pengajuan_barang_jasa_id')) value='{{ $non_pbj->id }}'>
                                        {{ $non_pbj->perihal }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pengajuan_barang_jasa_id')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='surat_perihal' class='mb-2'>Perihal</label>
                            <input type='text' name='surat_perihal' id='surat_perihal'
                                class='form-control @error('surat_perihal') is-invalid @enderror'
                                value='{{ old('surat_perihal') }}' readonly>
                            @error('surat_perihal')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='surat_nomor_surat' class='mb-2'>No.Surat</label>
                            <input type='text' name='surat_nomor_surat' id='surat_nomor_surat'
                                class='form-control @error('surat_nomor_surat') is-invalid @enderror'
                                value='{{ old('surat_nomor_surat') }}' readonly>
                            @error('surat_nomor_surat')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='surat_no_agenda' class='mb-2'>No. Agenda</label>
                            <input type='text' name='surat_no_agenda' id='surat_no_agenda'
                                class='form-control @error('surat_no_agenda') is-invalid @enderror'
                                value='{{ old('surat_no_agenda') }}' readonly>
                            @error('surat_no_agenda')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='nominal' class='mb-2'>Nominal</label>
                            <input type='number' name='nominal' id='nominal'
                                class='form-control @error('nominal') is-invalid @enderror' value='{{ old('nominal') }}'>
                            @error('nominal')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('pengajuan-form-non-pbj.uang-muka.index') }}"
                                class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Tambah Uang Muka</button>
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
            $('#pengajuan_barang_jasa_id').on('change', function() {
                let id = $(this).val();
                $.ajax({
                    url: '{{ route('pengajuan-form-non-pbj.getById') }}',
                    data: {
                        id
                    },
                    dataType: 'JSON',
                    type: 'GET',
                    success: function(data) {
                        $('#surat_perihal').val(data.perihal);
                        $('#surat_nomor_surat').val(data.nomor_surat);
                        $('#surat_no_agenda').val(data.nomor_agenda);
                    }
                })
            })
        })
    </script>
@endpush
