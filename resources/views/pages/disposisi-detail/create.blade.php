@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Disposisi Surat Perjalanan Dinas</h4>
                    <form
                        action="{{ route('disposisi-detail.store', [
                            'disposisi_id' => $disposisi->id,
                        ]) }}"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        <div class='form-group'>
                            <label for='tujuan_karyawan_id'>Diteruskan Ke</label>
                            <select name='tujuan_karyawan_id' id='tujuan_karyawan_id'
                                class='form-control @error('tujuan_karyawan_id') is-invalid @enderror'>
                                <option value='' selected disabled>Pilih Karyawan</option>
                                @foreach ($data_karyawan as $karyawan)
                                    <option value='{{ $karyawan->id }}'>
                                        {{ $karyawan->nama . ' | ' . $karyawan->jabatan->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tujuan_karyawan_id')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='catatan' class='mb-2'>Catatan</label>
                            <textarea name='catatan' id='catatan' cols='30' rows='3'
                                class='form-control @error('catatan') is-invalid @enderror'>{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('surat-perjalanan-dinas.index') }}" class="btn btn-warning">Batal</a>
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
@endpush
@push('scripts')
    <script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>
    <script>
        $(function() {
            $('#surat_id').on('change', function() {
                let surat_id = $(this).val();
                $.ajax({
                    url: '{{ route('surat.detail') }}',
                    data: {
                        surat_id
                    },
                    dataType: 'JSON',
                    type: 'GET',
                    success: function(res) {
                        if (res) {
                            $('#nomor_surat').val(res.nomor_surat);
                            $('#perihal').val(res.perihal);
                        }
                    }
                })
            })
        })
    </script>
@endpush
