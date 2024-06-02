@extends('pengadministrasi-umum.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Tambah Surat Tugas</h4>
                    <form action="{{ route('pengadministrasi-umum.surat.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class='form-group mb-3'>
                            <label for='nomor_surat' class='mb-2'>Nomor Surat</label>
                            <input type='text' name='nomor_surat' id='nomor_surat'
                                class='form-control @error('nomor_surat') is-invalid @enderror'
                                value='{{ old('nomor_surat') }}'>
                            @error('nomor_surat')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        {{--  <div class='form-group mb-3'>
                            <label for='tanggal_surat' class='mb-2'>Tanggal Surat</label>
                            <input type='date' name='tanggal_surat' id='tanggal_surat'
                                class='form-control @error('tanggal_surat') is-invalid @enderror'
                                value='{{ old('tanggal_surat') }}'>
                            @error('tanggal_surat')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>  --}}
                        <div class='form-group'>
                            <label for='pelaksana'>Pelaksana</label>
                            <select name='pelaksana[]' id='pelaksana'
                                class='form-control @error('pelaksana') is-invalid @enderror' multiple>
                                <option value='' disabled>Pilih Pelaksana</option>
                                @foreach ($data_pelaksana as $karyawan)
                                    <option @selected($karyawan->id == old('pelaksana')) value='{{ $karyawan->id }}'>
                                        {{ $karyawan->nama . ' | ' . $karyawan->jabatan->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pelaksana')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='maksud_perjalanan_dinas' class='mb-2'>Maksud Perjalanan Dinas</label>
                            <textarea name='maksud_perjalanan_dinas' id='maksud_perjalanan_dinas' cols='30' rows='3'
                                class='form-control @error('maksud_perjalanan_dinas') is-invalid @enderror'>{{ old('maksud_perjalanan_dinas') }}</textarea>
                            @error('maksud_perjalanan_dinas')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='lama_hari' class='mb-2'>Lama Hari</label>
                            <input type='number' name='lama_hari' id='lama_hari'
                            class='form-control @error('lama_hari') is-invalid @enderror'
                            value='{{ old('lama_hari') }}'>
                            @error('lama_hari')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='tanggal_mulai' class='mb-2'>Tanggal Mulai Perjalanan Dinas</label>
                            <input type='date' name='tanggal_mulai' id='tanggal_mulai'
                                class='form-control @error('tanggal_mulai') is-invalid @enderror'
                                value='{{ old('tanggal_mulai') }}'>
                            @error('tanggal_mulai')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='tanggal_sampai' class='mb-2'>Tanggal Sampai Perjalanan Dinas</label>
                            <input type='date' name='tanggal_sampai' id='tanggal_sampai'
                                class='form-control @error('tanggal_sampai') is-invalid @enderror'
                                value='{{ old('tanggal_sampai') }}'>
                            @error('tanggal_sampai')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='tempat_berangkat' class='mb-2'>Tempat Berangkat</label>
                            <input type='text' name='tempat_berangkat' id='tempat_berangkat'
                                class='form-control @error('tempat_berangkat') is-invalid @enderror'
                                value='{{ old('tempat_berangkat') }}'>
                            @error('tempat_berangkat')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='tempat_tujuan' class='mb-2'>Tempat Tujuan</label>
                            <input type='text' name='tempat_tujuan' id='tempat_tujuan'
                                class='form-control @error('tempat_tujuan') is-invalid @enderror'
                                value='{{ old('tempat_tujuan') }}'>
                            @error('tempat_tujuan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='file' class='mb-2'>File</label>
                            <input type='file' name='file' id='file'
                                class='form-control @error('file') is-invalid @enderror' value='{{ old('file') }}'>
                            @error('file')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='lampiran' class='mb-2'>lampiran <span class="small">(Bisa Lebih dari
                                    1)</span></label>
                            <input type='file' name='lampiran[]' id='lampiran'
                                class='form-control @error('lampiran') is-invalid @enderror' value='{{ old('lampiran') }}'
                                multiple>
                            @error('lampiran')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group ml-4">
                            <div class="form-check">
                                <input type="checkbox" name="antar" value="1" class="form-check-input"
                                    id="antar" id="antar">
                                <label class="form-check-label" for="antar">Diantar/Dijemput</label>
                            </div>
                        </div>
                        <div class="d-antar d-none">
                            <div class='form-group mb-3'>
                                <label for='no_surat_jalan_dinas' class='mb-2'>No. Surat Jalan Dinas</label>
                                <input type='text' name='no_surat_jalan_dinas' id='no_surat_jalan_dinas'
                                    class='form-control @error('no_surat_jalan_dinas') is-invalid @enderror'
                                    value='{{ old('no_surat_jalan_dinas') }}'>
                                @error('no_surat_jalan_dinas')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label for='lampiran_surat_tugas' class='mb-2'>Lampiran Surat Tugas</label>
                                <input type='file' name='lampiran_surat_tugas' id='lampiran_surat_tugas'
                                    class='form-control @error('lampiran_surat_tugas') is-invalid @enderror'
                                    value='{{ old('lampiran_surat_tugas') }}'>
                                @error('lampiran_surat_tugas')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label for='tanggal_surat_jalan' class='mb-2'>Tanggal Surat Jalan</label>
                                <input type='date' name='tanggal_surat_jalan' id='tanggal_surat_jalan'
                                    class='form-control @error('tanggal_surat_jalan') is-invalid @enderror'
                                    value='{{ old('tanggal_surat_jalan') }}'>
                                @error('tanggal_surat_jalan')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group'>
                                <label for='supir_karyawan_id'>Pengemudi</label>
                                <select name='supir_karyawan_id' id='supir_karyawan_id'
                                    class='form-control @error('supir_karyawan_id') is-invalid @enderror'>
                                    <option value='' selected disabled>Pilih Pengemudi</option>
                                    @foreach ($data_karyawan as $karyawan)
                                        <option @selected($karyawan->id == old('supir_karyawan_id')) value='{{ $karyawan->id }}'>
                                            {{ $karyawan->nama . ' - ' . 'Jabatan : ' . $karyawan->jabatan->nama ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('supir_karyawan_id')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group'>
                                <label for='uraian_tugas'>Uraian Tugas</label>
                                <select name='uraian_tugas' id='uraian_tugas'
                                    class='form-control @error('uraian_tugas') is-invalid @enderror'>
                                    <option value='' selected disabled>Pilih Uraian Tugas</option>
                                    <option value="Mengantar Menginap">Mengantar Menginap</option>
                                    <option value="Mengantar dan Menjemput">Mengantar dan Menjemput</option>
                                    <option value="Mengantar">Mengantar</option>
                                    <option value="Menjemput">Menjemput</option>
                                </select>
                                @error('uraian_tugas')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label for='lama_hari_tugas' class='mb-2'>Lama Hari Tugas</label>
                                <input type='number' name='lama_hari_tugas' id='lama_hari_tugas'
                                class='form-control @error('lama_hari_tugas') is-invalid @enderror'
                                value='{{ old('lama_hari_tugas') }}'>
                                @error('lama_hari_tugas')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label for='mulai_tanggal_tugas' class='mb-2'>Tanggal Mulai Tugas</label>
                                <input type='date' name='mulai_tanggal_tugas' id='mulai_tanggal_tugas'
                                    class='form-control @error('mulai_tanggal_tugas') is-invalid @enderror'
                                    value='{{ old('mulai_tanggal_tugas') }}'>
                                @error('mulai_tanggal_tugas')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label for='sampai_tanggal_tugas' class='mb-2'>Sampai Tanggal Tugas</label>
                                <input type='date' name='sampai_tanggal_tugas' id='sampai_tanggal_tugas'
                                    class='form-control @error('sampai_tanggal_tugas') is-invalid @enderror'
                                    value='{{ old('sampai_tanggal_tugas') }}'>
                                @error('sampai_tanggal_tugas')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('pengadministrasi-umum.surat.index') }}" class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Tambah Surat Tugas</button>
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
            $('#pelaksana').select2({
                placeholder: 'Pilih Pelaksana'
            });

            $('#antar').on('click', function() {
                let antar = $(this).prop('checked');
                if (antar == 1) {
                    $('.d-antar').removeClass('d-none');
                } else {
                    $('.d-antar').addClass('d-none');

                }
            })
        })
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const lamaHariField = document.getElementById('lama_hari');
            const tanggalMulaiField = document.getElementById('tanggal_mulai');
            const tanggalSampaiField = document.getElementById('tanggal_sampai');

            function updateTanggalSampai() {
                const lamaHari = parseInt(lamaHariField.value, 10);
                const tanggalMulai = new Date(tanggalMulaiField.value);

                if (!isNaN(lamaHari) && tanggalMulai instanceof Date && !isNaN(tanggalMulai)) {
                    const tanggalSampai = new Date(tanggalMulai);
                    tanggalSampai.setDate(tanggalMulai.getDate() + lamaHari);

                    const year = tanggalSampai.getFullYear();
                    const month = String(tanggalSampai.getMonth() + 1).padStart(2, '0');
                    const day = String(tanggalSampai.getDate()).padStart(2, '0');

                    tanggalSampaiField.value = `${year}-${month}-${day}`;
                }
            }

            lamaHariField.addEventListener('input', updateTanggalSampai);
            tanggalMulaiField.addEventListener('input', updateTanggalSampai);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const lamaHariTugasField = document.getElementById('lama_hari_tugas');
            const tanggalMulaiTugasField = document.getElementById('mulai_tanggal_tugas');
            const tanggalSampaiTUgasField = document.getElementById('sampai_tanggal_tugas');

            function updateTanggalSampai() {
                const lamaHariTugas = parseInt(lamaHariTugasField.value, 10);
                const tanggalMulaiTugas = new Date(tanggalMulaiTugasField.value);

                if (!isNaN(lamaHariTugas) && tanggalMulaiTugas instanceof Date && !isNaN(tanggalMulaiTugas)) {
                    const tanggalSampaiTugas = new Date(tanggalMulaiTugas);
                    tanggalSampaiTugas.setDate(tanggalMulaiTugas.getDate() + lamaHariTugas);

                    const year = tanggalSampaiTugas.getFullYear();
                    const month = String(tanggalSampaiTugas.getMonth() + 1).padStart(2, '0');
                    const day = String(tanggalSampaiTugas.getDate()).padStart(2, '0');

                    tanggalSampaiTUgasField.value = `${year}-${month}-${day}`;
                }
            }

            lamaHariTugasField.addEventListener('input', updateTanggalSampai);
            tanggalMulaiTugasField.addEventListener('input', updateTanggalSampai);
        });
    </script>
@endpush
