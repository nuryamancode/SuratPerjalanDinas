@extends('ppk.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Pilih Pelaksana</h4>
                    <form
                        action="{{ route('ppk.pengajuan-pbj-pelaksana.store', [
                            'pbj_uuid' => $permohonan->uuid,
                        ]) }}"
                        method="post">
                        @csrf
                        <div class='form-group'>
                            <label for='karyawan_id'>Karyawan</label>
                            <select name='karyawan_id[]' id='karyawan_id'
                                class='form-control @error('karyawan_id') is-invalid @enderror' multiple>
                                @foreach ($data_karyawan as $karyawan)
                                    <option @selected($karyawan->id == old('karyawan_id')) value='{{ $karyawan->id }}'>{{ $karyawan->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('karyawan_id')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('ppk.pengajuan-pbj-pelaksana.index', [
                                'pbj_uuid' => $permohonan->uuid,
                            ]) }}"
                                class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Submit</button>
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
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>
    <script>
        $(function() {
            $('#karyawan_id').select2({
                theme: 'bootstrap',
                placeholder: 'Pilih'
            })
        })
    </script>
@endpush
