@extends('bendahara-keuangan.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Uang Muka Surat Non PBJ</h4>
                    <form action="{{ route('bendahara-keuangan.surat-non-pbj-uang-muka.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="surat_non_pbj_uuid" value="{{ $suratNonPbj->uuid }}">
                        <div class='form-group mb-3'>
                            <label for='surat_perihal' class='mb-2'>Perihal</label>
                            <input type='text' name='surat_perihal' id='surat_perihal'
                                class='form-control @error('surat_perihal') is-invalid @enderror'
                                value='{{ $suratNonPbj->perihal ?? old('surat_perihal') }}' readonly>
                            @error('surat_perihal')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='surat_no_agenda' class='mb-2'>No. Agenda</label>
                            <input type='text' name='surat_no_agenda' id='surat_no_agenda'
                                class='form-control @error('surat_no_agenda') is-invalid @enderror'
                                value='{{ $suratNonPbj->nomor_agenda ?? old('surat_no_agenda') }}' readonly>
                            @error('surat_no_agenda')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group'>
                            <label for='karyawan_id'>Pelaksana</label>
                            <select name='karyawan_id' id='karyawan_id'
                                class='form-control @error('karyawan_id') is-invalid @enderror'>
                                <option value='' selected disabled>Pilih Pelaksana</option>
                                @foreach ($data_tim_ppk as $timppk)
                                    <option @selected($timppk->karyawan->id == isset($suratNonPbj->uang_muka) ? $suratNonPbj->uang_muka->karyawan_id : old('karyawan_id')) value='{{ $timppk->karyawan->id }}'>
                                        {{ $timppk->karyawan->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('karyawan_id')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='nominal' class='mb-2'>Nominal</label>
                            <input type='number' name='nominal' id='nominal'
                                class='form-control @error('nominal') is-invalid @enderror'
                                value='{{ $suratNonPbj->uang_muka->nominal ?? old('nominal') }}'>
                            @error('nominal')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('bendahara-keuangan.surat-non-pbj.index') }}"
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
