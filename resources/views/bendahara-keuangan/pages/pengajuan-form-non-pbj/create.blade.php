@extends('bendahara-keuangan.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Tambah Pengajuan Form Non PBJ</h4>
                    <form action="{{ route('bendahara-keuangan.pengajuan-form-non-pbj.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class='form-group mb-3'>
                            <label for='form_file' class='mb-2'>Formulir</label>
                            <input type='file' name='form_file' id='form_file'
                                class='form-control @error('form_file') is-invalid @enderror' value='{{ old('form_file') }}'>
                            @error('form_file')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                            <span><small>Silahkan untuk mengisi formulir dengan format PDF</small></span>
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
