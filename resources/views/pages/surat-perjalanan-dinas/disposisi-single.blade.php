@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Pengajuan Surat Perjalanan Dinas</h4>
                    <form action="{{ route('surat-perjalanan-dinas.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class='form-group'>
                            <label for='karyawan_disposisi_id'>Disposisi Single</label>
                            <select name='karyawan_disposisi_id' id='karyawan_disposisi_id'
                                class='form-control @error('karyawan_disposisi_id') is-invalid @enderror'>
                                <option value='' selected disabled>Pilih Disposisi Single</option>
                                @foreach ($items as $item)
                                    <option @selected($item->id == old('karyawan_disposisi_id')) value='{{ $item->id }}'>{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('karyawan_disposisi_id')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('surat-perjalanan-dinas.index') }}" class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Ajukan Surat Perjalanan Dinas</button>
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
