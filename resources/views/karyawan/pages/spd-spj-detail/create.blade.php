@extends('karyawan.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Buat Biaya SPJ</h4>
                    <form
                        action="{{ route('karyawan.spd-spj-detail.store', [
                            'spj_uuid' => $spj->uuid,
                        ]) }}"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        <div class='form-group mb-3'>
                            <label for='perincian_biaya' class='mb-2'>Perincian Biaya</label>
                            <input type='text' name='perincian_biaya' id='perincian_biaya'
                                class='form-control @error('perincian_biaya') is-invalid @enderror'
                                value='{{ old('perincian_biaya') }}'>
                            @error('perincian_biaya')
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
                        <div class='form-group mb-3'>
                            <label for='keterangan' class='mb-2'>Keterangan</label>
                            <textarea name='keterangan' id='keterangan' cols='30' rows='3'
                                class='form-control @error('keterangan') is-invalid @enderror'>{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='file' class='mb-2'>File Dokumen</label>
                            <input type='file' name='file' id='file'
                                class='form-control @error('file') is-invalid @enderror' value='{{ old('file') }}'>
                            @error('file')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-primary">Buat Biaya SPJ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
