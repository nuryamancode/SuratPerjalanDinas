@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Edit SPJ</h4>
                    <form action="{{ route('spj-form-non-pbj.update', $item->uuid) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class='form-group mb-3'>
                            <label for='draft' class='mb-2'>Draf SPJ <a href="{{ $item->downloadFile() }}"
                                    class="btn btn-sm btn-success" target="_blank"> Lihat</a></label>
                            <input type='file' name='draft' id='draft'
                                class='form-control @error('draft') is-invalid @enderror' value='{{ old('draft') }}'>
                            @error('draft')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('spj-form-non-pbj.index') }}" class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Update SPJ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
