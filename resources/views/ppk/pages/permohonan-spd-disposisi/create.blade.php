@extends('ppk.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Disposisi Permohonan SPD</h4>
                    <form
                        action="{{ route('ppk.permohonan-spd-disposisi.store', [
                            'permohonan_spd_uuid' => $permohonan->id,
                        ]) }}"
                        method="post">
                        @csrf
                        <div class='form-group mb-3'>
                            <label for='nomor_surat' class='mb-2'>Nomor Surat</label>
                            <input type='text' name='nomor_surat' id='nomor_surat'
                                class='form-control @error('nomor_surat') is-invalid @enderror'
                                value='{{ $permohonan->surat->nomor_surat ?? old('nomor_surat') }}' disabled>
                            @error('nomor_surat')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='nomor_agenda' class='mb-2'>Nomor Agenda</label>
                            <input type='text' name='nomor_agenda' id='nomor_agenda'
                                class='form-control @error('nomor_agenda') is-invalid @enderror'
                                value='{{ old('nomor_agenda') }}'>
                            @error('nomor_agenda')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='tanggal_surat' class='mb-2'>Tanggal Surat</label>
                            <input type='text' name='tanggal_surat' id='tanggal_surat'
                                class='form-control @error('tanggal_surat') is-invalid @enderror'
                                value='{{ \Carbon\Carbon::parse($permohonan->surat->created_at ?? old('tanggal_surat'))->format('Y-m-d') }}' disabled>
                            @error('tanggal_surat')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='asal_surat' class='mb-2'>Asal Surat</label>
                            <input type='text' name='asal_surat' id='asal_surat'
                                class='form-control @error('asal_surat') is-invalid @enderror'
                                value='{{ $permohonan->surat->asal_surat ?? old('asal_surat') }}' disabled>
                            @error('asal_surat')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='perihal' class='mb-2'>Perihal</label>
                            <input type='text' name='perihal' id='perihal'
                                class='form-control @error('perihal') is-invalid @enderror' value='{{ old('perihal') }}'>
                            @error('perihal')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group'>
                            <label for='tipe'>Tipe</label>
                            <select name='tipe' id='tipe' class='form-control @error('tipe') is-invalid @enderror'>
                                <option value='' selected disabled>Pilih tipe</option>
                                <option @selected(old('tipe') === 'Rahasia') value="Rahasia">Rahasia</option>
                                <option @selected(old('tipe') === 'Terbatas Biasa') value="Terbatas Biasa">Terbatas Biasa</option>
                                <option @selected(old('tipe') === 'Segera') value="Segera">Segera</option>
                                <option @selected(old('tipe') === 'Sangat Segera') value="Sangat Segera">Sangat Segera</option>
                            </select>
                            @error('tipe')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group'>
                            <label for='teruskan_ke'>Diteruskan Ke</label>
                            <select name='teruskan_ke' id='teruskan_ke' class='form-control'>
                                <option value='' selected disabled>Pilih Diteruskan</option>
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
                            <a href="{{ route('ppk.permohonan-spd-disposisi.index', $permohonan->id) }}"
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
            $('#tujuan_karyawan_id').select2({
                theme: 'bootstrap',
                placeholder: 'Pilih'
            })
        })
    </script>
@endpush
