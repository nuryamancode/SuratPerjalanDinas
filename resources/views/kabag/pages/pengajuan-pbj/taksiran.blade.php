@extends('kabag.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Tambah Taksiran</h4>
                    <form action="{{ route('kabag.taksiran.store', $item->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class='form-group mb-3'>
                            <label for='nilai_taksiran' class='mb-2'>Nilai Taksiran</label>
                            <input type='number' name='nilai_taksiran' id='nilai_taksiran'
                                class='form-control @error('nilai_taksiran') is-invalid @enderror'
                                value='{{ old('nilai_taksiran') }}'>
                            @error('nilai_taksiran')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('pengadministrasi-umum.pengajuan-form-non-pbj.index') }}"
                                class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Tambah Pengajuan PBJ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
