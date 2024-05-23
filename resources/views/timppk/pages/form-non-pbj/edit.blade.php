@extends('timppk.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Edit Pengajuan Form Non PBJ</h4>
                    <form action="{{ route('timppk.form-non-pbj.update', $item->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class='form-group mb-3'>
                            <label for='form_file' class='mb-2'>File</label>
                            <input type='file' name='form_file' id='form_file'
                                class='form-control @error('form_file') is-invalid @enderror'
                                value='{{ old('form_file') }}'>
                            @error('form_file')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <a href="{{ $item->getFile() }}" target="_blank" class="btn btn-success btn-sm">Lihat
                            Formulir</a>
                        <div class="form-group text-right">
                            <a href="{{ route('karyawan.form-non-pbj.index') }}" class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Kirim Ulang Pengajuan Form Non PBJ</button>
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
            $('#pelaksana').select2({
                placeholder: 'Pilih Pelaksana'
            });
        })
    </script>
@endpush
