@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Edit Surat Perjalanan Dinas Supir</h4>
                    <form action="{{ route('surat-perjalanan-dinas-supir.update', $spd_detail->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class='form-group'>
                            <label for='karyawan_id'>Supir</label>
                            <select name='karyawan_id[]' id='karyawan_id'
                                class='form-control @error('karyawan_id') is-invalid @enderror' multiple>
                                @foreach ($data_karyawan as $karyawan)
                                    <option @if ($selectedKaryawan->contains($karyawan->id)) selected @endif value='{{ $karyawan->id }}'>
                                        {{ $karyawan->nama . ' | ' . $karyawan->nip }}
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
                            <a href="{{ route('surat-perjalanan-dinas.index', [
                                'surat_perjalanan_dinas_id' => $spd_detail->surat_perjalanan_dinas_id,
                            ]) }}"
                                class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary" name="jenis" value="">Update Data</button>
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
            $('#karyawan_id').select2({
                placeholder: 'Pilih Supir'
            });
        })
    </script>
@endpush
