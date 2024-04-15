@extends('pengusul.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Edit Detail Pengajuan Form Non PBJ</h4>
                    <form action="{{ route('pengusul.pengajuan-form-non-pbj-detail.update', $item->uuid) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class='form-group mb-3'>
                            <label for='kebutuhan_barang' class='mb-2'>Kebutuhan Barang</label>
                            <textarea name='kebutuhan_barang' id='kebutuhan_barang' cols='30' rows='3'
                                class='form-control @error('kebutuhan_barang') is-invalid @enderror'>{{ $item->kebutuhan_barang ?? old('kebutuhan_barang') }}</textarea>
                            @error('kebutuhan_barang')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='volume' class='mb-2'>Volume</label>
                            <input type='text' name='volume' id='volume'
                                class='form-control @error('volume') is-invalid @enderror'
                                value='{{ $item->volume ?? old('volume') }}'>
                            @error('volume')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='satuan' class='mb-2'>Satuan</label>
                            <input type='text' name='satuan' id='satuan'
                                class='form-control @error('satuan') is-invalid @enderror'
                                value='{{ $item->satuan ?? old('satuan') }}'>
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
                                value='{{ $item->harga_satuan ?? old('harga_satuan') }}'>
                            @error('harga_satuan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='jumlah' class='mb-2'>Jumlah</label>
                            <input type='number' name='jumlah' id='jumlah'
                                class='form-control @error('jumlah') is-invalid @enderror'
                                value='{{ $item->jumlah ?? old('jumlah') }}'>
                            @error('jumlah')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='keterangan' class='mb-2'>Keterangan</label>
                            <textarea name='keterangan' id='keterangan' cols='30' rows='3'
                                class='form-control @error('keterangan') is-invalid @enderror'>{{ $item->keterangan ?? old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('pengusul.pengajuan-form-non-pbj.show', $item->pengajuan_barang_jasa->uuid) }}"
                                class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Update Detail Pengajuan Form Non PBJ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
