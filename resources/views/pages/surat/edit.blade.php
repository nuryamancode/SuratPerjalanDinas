@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Edit Surat</h4>
                    <form action="{{ route('surat.update', $item->uuid) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class='form-group mb-3'>
                            <label for='nomor_surat' class='mb-2'>Nomor Surat</label>
                            <input type='text' name='nomor_surat' id='nomor_surat'
                                class='form-control @error('nomor_surat') is-invalid @enderror'
                                value='{{ $item->nomor_surat ?? old('nomor_surat') }}'>
                            @error('nomor_surat')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='perihal' class='mb-2'>Perihal</label>
                            <input type='text' name='perihal' id='perihal'
                                class='form-control @error('perihal') is-invalid @enderror'
                                value='{{ $item->perihal ?? old('perihal') }}'>
                            @error('perihal')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='file' class='mb-2'>File</label>
                            <input type='file' name='file' id='file'
                                class='form-control @error('file') is-invalid @enderror' value='{{ old('file') }}'>
                            @error('file')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='lampiran' class='mb-2'>lampiran <span class="small">(Bisa Lebih dari
                                    1)</span></label>
                            <input type='file' name='lampiran[]' id='lampiran'
                                class='form-control @error('lampiran') is-invalid @enderror' value='{{ old('lampiran') }}'
                                multiple>
                            @error('lampiran')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group'>
                            <label for='pelaksana'>Pelaksana</label>
                            <select name='pelaksana[]' id='pelaksana'
                                class='form-control @error('pelaksana') is-invalid @enderror' multiple>
                                <option value='' disabled>Pilih Pelaksana</option>
                                @foreach ($data_users as $user)
                                    <option value='{{ $user->id }}' @selected(in_array($user->id, old('pelaksana', $selectedUsers ?? [])))>{{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pelaksana')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('surat.index') }}" class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Update Surat</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">List Lampiran</h4>
                    <ul class="list-unstyled">
                        @forelse ($item->lampiran as $lampiran)
                            <li class="mb-2">
                                <a href="{{ asset('storage/' . $lampiran->file) }}" target="_blank"
                                    class="btn btn-sm btn-info">Lihat</a>
                                <form action="javascript:void(0)" method="post" class="d-inline" id="formDelete">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btnDelete btn-sm py-2 btn-link"
                                        data-action="{{ route('lampiran.destroy', $lampiran->uuid) }}">Hapus</button>
                                </form>
                            </li>
                        @empty
                            <li class="text-center">
                                Lampiran Tidak Ada
                            </li>
                        @endforelse
                    </ul>
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
