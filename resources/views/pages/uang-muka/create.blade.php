@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Tambah Uang Muka</h4>
                    <form action="{{ route('uang-muka.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class='form-group'>
                            <label for='surat_perjalanan_dinas_id'>Surat Perjalanan Dinas</label>
                            <select name='surat_perjalanan_dinas_id' id='surat_perjalanan_dinas_id'
                                class='form-control @error('surat_perjalanan_dinas_id') is-invalid @enderror'>
                                <option value='' selected disabled>Pilih Surat Perjalanan Dinas</option>
                                @foreach ($data_surat_perjalanan_dinas as $spd)
                                    <option @selected($spd->id == old('surat_perjalanan_dinas_id')) value='{{ $spd->id }}'>
                                        {{ $spd->surat->perihal }}
                                    </option>
                                @endforeach
                            </select>
                            @error('surat_perjalanan_dinas_id')
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
                            <a href="{{ route('uang-muka.index') }}" class="btn btn-warning">Batal</a>
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
            $('#surat_perjalanan_dinas_id').on('change', function() {
                let spd_id = $(this).val();
                $.ajax({
                    url: '{{ route('surat-perjalanan-dinas.getById') }}',
                    data: {
                        spd_id
                    },
                    dataType: 'JSON',
                    type: 'GET',
                    success: function(data) {
                        $('#surat_perihal').val(data.surat.perihal);
                        $('#surat_nomor_surat').val(data.surat.nomor_surat);
                        $('#surat_no_agenda').val(data.surat.no_agenda);
                    }
                })
            })
        })
    </script>
@endpush
