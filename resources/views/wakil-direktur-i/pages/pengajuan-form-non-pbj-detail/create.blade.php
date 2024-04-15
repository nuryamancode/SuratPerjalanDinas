@extends('pengusul.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Tambah Detail Pengajuan Form Non PBJ</h4>
                    <form action="{{ route('pengusul.pengajuan-form-non-pbj-detail.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="pengajuan_pbj_uuid" value="{{ $pengajuan_pbj->uuid }}">
                        <div class='form-group mb-3'>
                            <label for='kebutuhan_barang' class='mb-2'>Kebutuhan Barang</label>
                            <textarea name='kebutuhan_barang' id='kebutuhan_barang' cols='30' rows='3'
                                class='form-control @error('kebutuhan_barang') is-invalid @enderror'>{{ old('kebutuhan_barang') }}</textarea>
                            @error('kebutuhan_barang')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='volume' class='mb-2'>Volume</label>
                            <input type='text' name='volume' id='volume'
                                class='form-control @error('volume') is-invalid @enderror' value='{{ old('volume') }}'>
                            @error('volume')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='satuan' class='mb-2'>Satuan</label>
                            <input type='text' name='satuan' id='satuan'
                                class='form-control @error('satuan') is-invalid @enderror' value='{{ old('satuan') }}'>
                            @error('satuan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='harga_satuan' class='mb-2'>Harga Satuan</label>
                            <input type='number' name='harga_satuan' id='harga_satuan'
                                class='form-control @error('harga_satuan') is-invalid @enderror'
                                value='{{ old('harga_satuan') }}'>
                            @error('harga_satuan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='jumlah' class='mb-2'>Jumlah</label>
                            <input type='number' name='jumlah' id='jumlah'
                                class='form-control @error('jumlah') is-invalid @enderror' value='{{ old('jumlah') }}'>
                            @error('jumlah')
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
                        <div class="form-group text-right">
                            <a href="{{ route('pengusul.pengajuan-form-non-pbj-detail.index') }}"
                                class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Tambah Detail Pengajuan Form Non PBJ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
