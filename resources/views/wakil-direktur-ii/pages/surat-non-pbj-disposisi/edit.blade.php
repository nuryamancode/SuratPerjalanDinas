@extends('wakil-direktur-ii.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <style>
                .back:hover {
                    text-decoration: none;
                }
            </style>
            <a href="{{ route('wakil-direktur-ii.surat-non-pbj-disposisi.index', $item->id) }}" class="back">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-arrow-left-bold-circle  pr-2 pt-1 icon-large"></i>
                    <span>Kembali</span>
                </div>
            </a>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Edit Disposisi Pengajuan Surat Non Pbj</h4>
                    <form action="{{ route('wakil-direktur-ii.surat-non-pbj-disposisi.update', $item->surat_non_pbj->id) }}"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        <div class='form-group mb-3'>
                            <label for='nomor_surat' class='mb-2'>Nomor Surat</label>
                            <input type='text' name='' id='nomor_surat'
                                class='form-control @error('nomor_surat') is-invalid @enderror'
                                value='{{ $item->surat_non_pbj->nomor_surat }}' readonly>
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
                                value='{{ $item->surat_non_pbj->nomor_agenda }}' readonly>
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
                                value='{{ \Carbon\Carbon::parse($item->surat_non_pbj->created_at)->format('d F Y') }}'
                                readonly>
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
                                value='{{ $item->surat_non_pbj->karyawan->nama }} - {{ $item->surat_non_pbj->karyawan->jabatan->nama }}'
                                readonly>
                            @error('created_at')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='perihal' class='mb-2'>Perihal</label>
                            <input type='text' name='' id='perihal'
                                class='form-control @error('perihal') is-invalid @enderror'
                                value='{{ $item->surat_non_pbj->perihal }}' readonly>
                            @error('perihal')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group'>
                            <label for='tipe_disposisi_1'>Tipe Disposisi</label>
                            <select name='tipe_disposisi_1' id='tipe_disposisi_1'
                                class='form-control @error('tipe_disposisi_1') is-invalid @enderror'>
                                <option value='' selected disabled>Pilih tipe</option>
                                <option @selected($item->tipe_disposisi_1) === 'Rahasia') value="Rahasia">Rahasia</option>
                                <option @selected($item->tipe_disposisi_1) === 'Terbatas Biasa') value="Terbatas Biasa">Terbatas
                                    Biasa</option>
                                <option @selected($item->tipe_disposisi_1) === 'Segera') value="Segera">Segera</option>
                                <option @selected($item->tipe_disposisi_1) === 'Sangat Segera') value="Sangat Segera">Sangat
                                    Segera</option>
                            </select>
                            @error('tipe_disposisi_1')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group ml-4">
                            <div class="form-check">
                                <input type="checkbox" name="taksiran" value="1" class="form-check-input"
                                    id="taksiran" id="taksiran">
                                <label class="form-check-label" for="taksiran">Ada Nilai Taksiran</label>
                            </div>
                        </div>
                        <div class="d-taksiran_1">
                            <div class='form-group'>
                                <label for='teruskan_ke'>Diteruskan</label>
                                <select name='teruskan_ke' id='teruskan_ke'
                                    class='form-control @error('teruskan_ke') is-invalid @enderror'>
                                    <option value="" selected disabled>Pilih Diteruskan</option>
                                    @foreach ($data_karyawans as $karyawans)
                                        <option value="{{ $karyawans->id }}">
                                            {{ $karyawans->nama . ' - ' . 'Jabatan : ' . ($karyawans->jabatan->nama ?? '') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('teruskan_ke')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-taksiran_2 d-none">
                            <div class='form-group'>
                                <label for='teruskan_ke'>Diteruskan</label>
                                <select name='teruskan_ke' id='teruskan_ke'
                                    class='form-control @error('teruskan_ke') is-invalid @enderror'>
                                    <option value="" selected disabled>Pilih Diteruskan</option>
                                    @foreach ($data_karyawan as $karyawan)
                                        <option @selected($karyawan->id == ($item->teruskan1->id ?? '')) value="{{ $karyawan->id }}">
                                            {{ $karyawan->nama . ' - ' . 'Jabatan : ' . ($karyawan->jabatan->nama ?? '') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('teruskan_ke')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class='form-group mb-3'>
                            <label for='catatan_disposisi_1' class='mb-2'>Catatan Disposisi</label>
                            <textarea name='catatan_disposisi_1' id='catatan_disposisi_1' cols='30' rows='3'
                                placeholder="isi jika ada" class='form-control @error('catatan_disposisi_1') is-invalid @enderror'>{{ $item->catatan_disposisi_1 }}</textarea>
                            @error('catatan_disposisi_1')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('wakil-direktur-ii.pengajuan-pbj.index') }}"
                                class="btn btn-warning">Batal</a>
                            @if ($item->surat_non_pbj->acc_ppk == 2)
                                <button class="btn btn-primary">Kirim Ulang</button>
                            @else
                                <button class="btn btn-primary">Submit</button>
                            @endif
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
            $('#penerus').select2({
                placeholder: 'Pilih Karyawan'
            });
        })

        $('#taksiran').on('click', function() {
            let taksiran = $(this).prop('checked');
            if (taksiran == 1) {
                $('.d-taksiran_2').removeClass('d-none');
                $('.d-taksiran_1').addClass('d-none');
            } else {
                $('.d-taksiran_2').addClass('d-none');
                $('.d-taksiran_1').removeClass('d-none');

            }
        })
    </script>
@endpush
