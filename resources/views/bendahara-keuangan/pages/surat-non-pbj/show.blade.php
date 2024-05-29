@extends('bendahara-keuangan.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md">
            <style>
                .back:hover {
                    text-decoration: none;
                }
            </style>
            <a href="{{ route('bendahara-keuangan.surat-non-pbj.index') }}" class="back">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-arrow-left-bold-circle  pr-2 pt-1 icon-large"></i>
                    <span>Kembali</span>
                </div>
            </a>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Detail Pengajuan Form Non PBJ</h4>
                    <ul class="list-inline">
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Nomor Surat</span>
                            <span>{{ $item->nomor_surat }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Nomor Agenda</span>
                            <span>{{ $item->nomor_agenda ?? '-' }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Tanggal</span>
                            <span>{{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Perihal</span>
                            <span>{{ $item->perihal }}</span>
                        </li>
                        @if ($item->nilai_taksiran != null)
                            <li class="list-item mb-4 d-flex justify-content-between">
                                <span>Nilai Taksiran</span>
                                <span>{{ $item->nilai_taksiran ? 'Rp. ' . number_format($item->nilai_taksiran, 0, ',', '.') : '' }}</span>
                            </li>
                        @endif
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Dokumen surat</span>
                            <span>
                                <a href="{{ $item->getFileDokumen() }}" target="_blank" class="btn btn-success btn-sm">Lihat
                                    Dokumen</a>
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Lampiran</span>
                            <span>
                                <ol class="list-group">
                                    @foreach ($item->lampiransnpbj as $lampiransnpbj)
                                        <li>
                                            <a href="{{ $lampiransnpbj->getFile() }}" target="_blank"
                                                class="btn btn-success btn-sm mt-2">Lihat Lampiran</a>
                                        </li>
                                    @endforeach
                                </ol>
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Pengusul</span>
                            <div>
                                <ol class="list-group">
                                    @foreach ($item->pengusul as $pengusul)
                                        <li>
                                            {{ $pengusul->karyawan->nama }}
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        </li>
                        @if ($item->uang_muka == null || $item->uang_muka->acc_bendahara == 0)
                            <li class="list-item mb-4 d-flex justify-content-between">
                                <span>Aksi</span>
                                <div>
                                    <a href="#" data-toggle="modal" data-target="#modalTanggapi{{ $item->id }}"
                                        class="btn btn-sm btn-primary">Tanggapi Disposisi</a>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalTanggapi{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tanggapi Disposisi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('bendahara-keuangan.surat-non-pbj.store_tanggapi', $item->id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <div class='form-group mb-3'>
                            <div class='form-group mb-3'>
                                <label for='uang_muka' class='mb-2'>Uang Muka</label>
                                <input type='number' name='uang_muka' id='uang_muka'
                                    class='form-control @error('uang_muka') is-invalid @enderror'
                                    value='{{ old('uang_muka') }}'>
                                @error('uang_muka')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class='form-group'>
                            <label for='teruskan_ke'>Diteruskan</label>
                            <select name='teruskan_ke' id='teruskan_ke'
                                class='form-control @error('teruskan_ke') is-invalid @enderror'>
                                <option value='' selected disabled>Pilih Diteruskan</option>
                                @foreach ($data_karyawans as $karyawan)
                                    <option @selected($karyawan->id == old('teruskan_ke')) value='{{ $karyawan->id }}'>
                                        {{ $karyawan->nama . ' - ' . $karyawan->jabatan->nama ?? '' }}
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btnSubmit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
<x-Admin.Datatable />
