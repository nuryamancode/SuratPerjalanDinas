@extends('wakil-direktur-ii.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Upload TTE</h4>
                    @if (auth()->user()->karyawan->tte_file)
                        <div class="mb-3">
                            <a target="_blank" href="{{ auth()->user()->karyawan->tte() }}"
                                class="btn btn-warning  btn-sm">Lihat
                                TTE</a>
                            <form action="{{ route('wakil-direktur-ii.tte.destroy') }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus TTE</button>
                            </form>
                        </div>
                    @endif
                    <form action="{{ route('wakil-direktur-ii.tte.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class='form-group mb-3'>
                            <label for='tte_file' class='mb-2'>File TTE (PNG)</label>
                            <input type='file' name='tte_file' id='tte_file'
                                class='form-control @error('tte_file') is-invalid @enderror' value='{{ old('tte_file') }}'>
                            @error('tte_file')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-primary" name="jenis" value="">Update Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
