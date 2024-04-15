@extends('bendahara-keuangan.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Uang Muka Form Non PBJ</h4>
                    <form action="{{ route('bendahara-keuangan.pengajuan-form-non-pbj-uang-muka.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="pengajuan_uuid" value="{{ $pengajuan->uuid }}">
                        <div class='form-group mb-3'>
                            <label for='surat_perihal' class='mb-2'>Perihal</label>
                            <input type='text' name='surat_perihal' id='surat_perihal'
                                class='form-control @error('surat_perihal') is-invalid @enderror'
                                value='{{ $pengajuan->perihal ?? old('surat_perihal') }}' readonly>
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
                                value='{{ $pengajuan->nomor_surat ?? old('surat_nomor_surat') }}' readonly>
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
                                value='{{ $pengajuan->nomor_agenda ?? old('surat_no_agenda') }}' readonly>
                            @error('surat_no_agenda')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='nominal' class='mb-2'>Nominal</label>
                            <input type='number' name='nominal' id='nominal'
                                class='form-control @error('nominal') is-invalid @enderror'
                                value='{{ $pengajuan->uang_muka->nominal ?? old('nominal') }}'>
                            @error('nominal')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('bendahara-keuangan.pengajuan-form-non-pbj.index') }}"
                                class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Submit Uang Muka</button>
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
