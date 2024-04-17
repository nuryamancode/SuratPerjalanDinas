@extends('bendahara-keuangan.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Submit Uang Muka</h4>
                    <form action="{{ route('bendahara-keuangan.spd-uang-muka.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="spd_uuid" value="{{ $permohonan->uuid }}">
                        <div class='form-group mb-3'>
                            <label for='surat_perihal' class='mb-2'>Nomor Surat</label>
                            <input type='text' name='surat_perihal' id='surat_perihal'
                                class='form-control @error('surat_perihal') is-invalid @enderror'
                                value='{{ $permohonan->surat->nomor_surat ?? old('surat_perihal') }}' readonly>
                            @error('surat_perihal')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='surat_nomor_surat' class='mb-2'>Maksud Perjalanan Dinas</label>
                            <input type='text' name='surat_nomor_surat' id='surat_nomor_surat'
                                class='form-control @error('surat_nomor_surat') is-invalid @enderror'
                                value='{{ $permohonan->surat->maksud_perjalanan_dinas ?? old('surat_nomor_surat') }}'
                                readonly>
                            @error('surat_nomor_surat')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='tempat_berangkat' class='mb-2'>Tempat Berangkat</label>
                            <input type='text' name='tempat_berangkat' id='tempat_berangkat'
                                class='form-control @error('tempat_berangkat') is-invalid @enderror'
                                value='{{ $permohonan->surat->tempat_berangkat ?? old('tempat_berangkat') }}' readonly>
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
                                value='{{ $permohonan->surat->tempat_tujuan ?? old('tempat_tujuan') }}' readonly>
                            @error('tempat_tujuan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='nominal' class='mb-2'>Nominal</label>
                            <input type='number' name='nominal' id='nominal'
                                class='form-control @error('nominal') is-invalid @enderror'
                                value='{{ $permohonan->uang_muka->nominal ?? old('nominal') }}'>
                            @error('nominal')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('bendahara-keuangan.permohonan-spd.index') }}"
                                class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
