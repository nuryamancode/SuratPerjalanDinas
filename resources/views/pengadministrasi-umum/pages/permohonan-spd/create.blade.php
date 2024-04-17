@extends('pengadministrasi-umum.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Pengajuan Surat Perjalanan Dinas</h4>
                    <form action="{{ route('pengadministrasi-umum.permohonan-spd.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class='form-group'>
                            <label for='surat_id'>Surat</label>
                            <select name='surat_id' id='surat_id'
                                class='form-control @error('surat_id') is-invalid @enderror'>
                                <option value='' selected disabled>Pilih Surat</option>
                                @foreach ($data_surat as $surat)
                                    <option @selected($surat->id == old('surat_id')) value='{{ $surat->id }}'>
                                        {{ $surat->nomor_surat }}
                                    </option>
                                @endforeach
                            </select>
                            @error('surat_id')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='nomor_surat' class='mb-2'>Nomor Surat</label>
                            <input type='text' name='' id='nomor_surat'
                                class='form-control @error('nomor_surat') is-invalid @enderror'
                                value='{{ old('nomor_surat') }}' readonly>
                            @error('nomor_surat')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='maksud_perjalanan_dinas' class='mb-2'>Maksud Perjalanan Dnas</label>
                            <input type='text' name='' id='maksud_perjalanan_dinas'
                                class='form-control @error('maksud_perjalanan_dinas') is-invalid @enderror'
                                value='{{ old('maksud_perjalanan_dinas') }}' readonly>
                            @error('maksud_perjalanan_dinas')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='tanggal_surat' class='mb-2'>Tanggal Surat</label>
                            <input type='text' name='tanggal_surat' id='tanggal_surat'
                                class='form-control @error('tanggal_surat') is-invalid @enderror'
                                value='{{ old('tanggal_surat') }}' disabled>
                            @error('tanggal_surat')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('pengadministrasi-umum.permohonan-spd.index') }}"
                                class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Ajukan Surat Perjalanan Dinas</button>
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
            $('#surat_id').on('change', function() {
                let surat_id = $(this).val();
                $.ajax({
                    url: '{{ route('surat.detail') }}',
                    data: {
                        surat_id
                    },
                    dataType: 'JSON',
                    type: 'GET',
                    success: function(res) {
                        if (res) {
                            $('#nomor_surat').val(res.nomor_surat);
                            $('#maksud_perjalanan_dinas').val(res.maksud_perjalanan_dinas);
                            $('#nomor_surat').val(res.nomor_surat);
                            $('#tanggal_surat').val(res.tanggal_surat);
                        }
                    }
                })
            })
        })
    </script>
@endpush
