@extends('ppk.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md">
            <style>
                .back:hover {
                    text-decoration: none;
                }
            </style>
            <a href="{{ route('ppk.pengajuan-pbj.index') }}" class="back">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-arrow-left-bold-circle  pr-2 pt-1 icon-large"></i>
                    <span>Kembali</span>
                </div>
            </a>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Detail Pengajuan Form Non PBJ</h4>
                    <ul class="list-inline">
                        <li class="list-item mb-4 d-flex justify-content-between p-1" style="border: 1px solid black">
                            <span>Nomor Surat</span>
                            <span>{{ $item->pengajuan_barang_jasa->nomor_surat }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between p-1" style="border: 1px solid black">
                            <span>Nomor Agenda</span>
                            <span>{{ $item->pengajuan_barang_jasa->nomor_agenda }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between p-1" style="border: 1px solid black">
                            <span>Tanggal</span>
                            <span>{{ \Carbon\Carbon::parse($item->pengajuan_barang_jasa->created_at)->format('d F Y') }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between p-1" style="border: 1px solid black">
                            <span>Perihal</span>
                            <span>{{ $item->pengajuan_barang_jasa->perihal }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between p-1" style="border: 1px solid black">
                            <span>Dokumen surat</span>
                            <span>
                                <a href="{{ $item->pengajuan_barang_jasa->getFileDokumen() }}" target="_blank"
                                    class="btn btn-success btn-sm">Lihat
                                    Dokumen</a>
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between p-1" style="border: 1px solid black">
                            <span>Lampiran</span>
                            <span>
                                <ol class="list-group">
                                    @foreach ($item->pengajuan_barang_jasa->lampiranpbj as $lampiranpbj)
                                        <li>
                                            <a href="{{ $lampiranpbj->getFile() }}" target="_blank"
                                                class="btn btn-success btn-sm mt-2">Lihat Lampiran</a>
                                        </li>
                                    @endforeach
                                </ol>
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between p-1" style="border: 1px solid black">
                            <span>Pengusul</span>
                            <div>
                                <ol class="list-group">
                                    @foreach ($item->pengajuan_barang_jasa->pengusul as $pengusul)
                                        <li>
                                            {{ $pengusul->karyawan->nama }}
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        </li>
                        @if ($item->pengajuan_barang_jasa->acc_ppk == '0')
                            <li class="list-item mb-4 d-flex justify-content-between p-1" style="border: 1px solid black">
                                <span>Aksi</span>
                                <div>
                                </div>
                                <div>
                                    <form action="javascript:void(0)" class="d-inline" id="formAcc">
                                        @csrf
                                        <button class="btn btnAcc btn-sm py-2 btn-success"
                                            data-action="{{ route('ppk.pengajuan-pbj-disposisi.index', $item->id) }}">Terima</button>
                                    </form>
                                    <a href="#" data-toggle="modal" data-target="#modalKeterangan"
                                        class="btn btn-sm py-2 btnTolak btn-danger">Tolak</a>
                                </div>
                            </li>
                        @endif
                        @if ($item->pengajuan_barang_jasa->acc_ppk == '1')
                        <li class="list-item mb-4 d-flex justify-content-between p-1" style="border: 1px solid black">
                            <span>Aksi</span>
                            <div>
                            </div>
                            <div>
                                <a href="{{ route('ppk.pengajuan-pbj-disposisi.index', $item->id) }}"
                                    class="btn btn-sm py-2 btnTolak btn-primary">Lihat Disposisi</a>
                            </div>
                        </li>

                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalKeterangan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Keterangan Penolakan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('wakil-direktur-ii.pengajuan-pbj.tolak', $item->id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <div class='form-group mb-3'>
                            <label for='keterangan' class='mb-2'>Keterangan</label>
                            <textarea name='keterangan' id='keterangan' cols='30' rows='3'
                                class='form-control @error('keterangan') is-invalid @enderror'>{{ old('keterangan') }}</textarea>
                            @error('keterangan')
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
