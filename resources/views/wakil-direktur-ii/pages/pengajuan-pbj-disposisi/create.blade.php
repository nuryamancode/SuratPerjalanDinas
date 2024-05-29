@extends('wakil-direktur-ii.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <style>
                .back:hover {
                    text-decoration: none;
                }
            </style>
            <a href="{{ route('wakil-direktur-ii.pengajuan-pbj-disposisi.index', $item->id) }}" class="back">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-arrow-left-bold-circle  pr-2 pt-1 icon-large"></i>
                    <span>Kembali</span>
                </div>
            </a>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Disposisi Pengajuan PBJ</h4>
                    <form action="{{ route('wakil-direktur-ii.pengajuan-pbj-disposisi.store', $item->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="pbj_id" value="{{ $item->id }}">
                        <div class='form-group mb-3'>
                            <label for='nomor_surat' class='mb-2'>Nomor Surat</label>
                            <input type='text' name='' id='nomor_surat'
                                class='form-control @error('nomor_surat') is-invalid @enderror'
                                value='{{ $item->nomor_surat }}' readonly>
                            @error('nomor_surat')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='nomor_agenda' class='mb-2'>Nomor Agenda</label>
                            <input type='text' name='' id='nomor_agenda'
                                class='form-control @error('nomor_agenda') is-invalid @enderror'
                                value='{{ $item->nomor_agenda }}' readonly>
                            @error('nomor_agenda')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='created_at' class='mb-2'>Tanggal Surat</label>
                            <input type='text' name='' id='created_at'
                                class='form-control @error('created_at') is-invalid @enderror'
                                value='{{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}' readonly>
                            @error('created_at')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='created_at' class='mb-2'>Asal Surat</label>
                            <input type='text' name='' id='created_at'
                                class='form-control @error('created_at') is-invalid @enderror'
                                value='{{ $item->karyawan->nama }} - {{ $item->karyawan->jabatan->nama }}' readonly>
                            @error('created_at')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='perihal' class='mb-2'>Perihal</label>
                            <input type='text' name='' id='perihal'
                                class='form-control @error('perihal') is-invalid @enderror' value='{{ $item->perihal }}'
                                readonly>
                            @error('perihal')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group'>
                            <label for='teruskan_ke'>Diteruskan Ke</label>
                            <select name='teruskan_ke' id='teruskan_ke' class='form-control'>
                                <option value='' selected disabled>Pilih PPK</option>
                                @foreach ($data_karyawan as $items)
                                    <option value='{{ $items->id }}'>{{ $items->nama }} - {{ $items->jabatan->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('teruskan_ke')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group'>
                            <label for='tipe_diposisi'>Tipe Disposisi</label>
                            <select name='tipe_disposisi' id='tipe_disposisi'
                                class='form-control @error('tipe_disposisi') is-invalid @enderror'>
                                <option value='' selected disabled>Pilih tipe</option>
                                <option @selected(old('tipe_disposisi') === 'Rahasia') value="Rahasia">Rahasia</option>
                                <option @selected(old('tipe_disposisi') === 'Terbatas Biasa') value="Terbatas Biasa">Terbatas Biasa</option>
                                <option @selected(old('tipe_disposisi') === 'Segera') value="Segera">Segera</option>
                                <option @selected(old('tipe_disposisi') === 'Sangat Segera') value="Sangat Segera">Sangat Segera</option>
                            </select>
                            @error('tipe_disposisi')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='catatan_disposisi' class='mb-2'>Catatan Disposisi</label>
                            <textarea name='catatan_disposisi' id='catatan_disposisi' cols='30' rows='3' placeholder="isi jika ada"
                                class='form-control @error('catatan_disposisi') is-invalid @enderror'>{{ old('catatan_disposisi') }}</textarea>
                            @error('catatan_disposisi')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('wakil-direktur-ii.pengajuan-pbj.index') }}"
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
            $('#pbj_id').on('change', function() {
                let pbj_id = $(this).val();
                $.ajax({
                    url: '{{ route('wakil-direktur-ii.pengajuan-pbj.detail') }}',
                    data: {
                        pbj_id
                    },
                    dataType: 'JSON',
                    type: 'GET',
                    success: function(res) {
                        if (res) {
                            $('#nomor_agenda').val(res.nomor_agenda);
                            $('#nomor_surat').val(res.nomor_surat);
                            $('#tanggal_surat').val(res.tanggal_surat);
                            $('#perihal').val(res.perihal);
                        }
                    }
                })
            })
        })
    </script>
@endpush
