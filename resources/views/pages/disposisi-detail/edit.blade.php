@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Disposisi Surat Perjalanan Dinas</h4>
                    <form action="{{ route('disposisi-detail.update', $item->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class='form-group mb-3'>
                            <label for='tujuan' class='mb-2'>Tujuan</label>
                            <input type='text' name='tujuan' id='tujuan'
                                class='form-control @error('tujuan') is-invalid @enderror'
                                value='{{ $item->tujuan->nama ?? old('tujuan') }}' readonly>
                            @error('tujuan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='catatan' class='mb-2'>Catatan</label>
                            <textarea name='catatan' id='catatan' cols='30' rows='3'
                                class='form-control @error('catatan') is-invalid @enderror'>{{ $item->catatan ?? old('catatan') }}</textarea>
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
