@extends('ppk.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Tambah Proses PBJ</h4>
                    <form action="{{ route('ppk.pengajuan-pbj-proses.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="pbj_uuid" value="{{ $pbj->uuid }}">
                        <div class='form-group'>
                            <label for='tahapan_pbj_id'>Tahapan</label>
                            <select name='tahapan_pbj_id' id='tahapan_pbj_id'
                                class='form-control @error('tahapan_pbj_id') is-invalid @enderror'>
                                <option value='' selected disabled>Pilih tahapan</option>
                                @foreach ($data_tahapan as $tahapan)
                                    <option value="{{ $tahapan->id }}">{{ $tahapan->nama }}</option>
                                @endforeach
                            </select>
                            @error('tahapan_pbj_id')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('ppk.pengajuan-pbj-proses.index', [
                                'pbj_uuid' => $pbj->uuid,
                            ]) }}"
                                class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Tambah Proses PBJ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
