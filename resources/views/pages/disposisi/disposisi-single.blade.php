@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Disposisi Surat Perjalanan Dinas</h4>
                    <form action="{{ route('surat-perjalanan-dinas.disposisi-single-submit', $item->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class='form-group'>
                            <label for='disposisi_karyawan_id'>Diteruskan Ke</label>
                            <select name='disposisi_karyawan_id' id='disposisi_karyawan_id'
                                class='form-control @error('disposisi_karyawan_id') is-invalid @enderror'>
                                <option value='' selected disabled>Pilih Karyawan</option>
                                @foreach ($data_karyawan as $karyawan)
                                    <option @selected($karyawan->id == $item->disposisi_karyawan_id) value='{{ $karyawan->id }}'>
                                        {{ $karyawan->nama . ' | ' . $karyawan->jabatan->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('disposisi_karyawan_id')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group'>
                            <label for='tipe'>Tipe</label>
                            <select name='tipe' id='tipe' class='form-control @error('tipe') is-invalid @enderror'>
                                <option value='' selected disabled>Pilih tipe</option>
                                <option @selected($item->tipe === 'Rahasia') value="Rahasia">Rahasia</option>
                                <option @selected($item->tipe === 'Terbatas Biasa') value="Terbatas Biasa">Terbatas Biasa</option>
                                <option @selected($item->tipe === 'Segera') value="Segera">Segera</option>
                                <option @selected($item->tipe === 'Sangat Segera') value="Sangat Segera">Sangat Segera</option>
                            </select>
                            @error('tipe')
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
