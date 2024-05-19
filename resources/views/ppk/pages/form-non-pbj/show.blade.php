@extends('ppk.layouts.app')
@section('content')
<style>
    .back:hover {
        text-decoration: none;
    }
</style>
<a href="{{ route('ppk.pengajuan-form-non-pbj.index') }}" class="back">
    <div class="d-flex align-items-center">
        <i class="mdi mdi-arrow-left-bold-circle  pr-2 pt-1 icon-large"></i>
        <span>Kembali</span>
    </div>
</a>
    <div class="row">
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Detail Approval Permohonan Form Non PBJ</h4>
                    <ul class="list-inline">
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Formulir</span>
                            <span>
                                <a href="{{ $item->getFile() }}" target="_blank" class="btn btn-success btn-sm">Lihat
                                    Formulir</a>
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Tanggal Pembuatan</span>
                            <span>
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Status Pengajuan</span>
                            <span>
                                {{ $item->status }}
                            </span>
                        </li>
                        @if ($item->acc_ppk == 0)
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Aksi</span>
                            <div>
                            </div>
                            <div>
                                <form action="javascript:void(0)" class="d-inline" id="formAcc">
                                    @csrf
                                    <button class="btn btnAcc btn-sm py-2 btn-success"
                                        data-action="{{ route('ppk.pengajuan-form-non-pbj-disposisi.index', $item->id) }}">Terima</button>
                                </form>
                                <a href="#" data-toggle="modal" data-target="#modalKeterangan"
                                    class="btn btn-sm py-2 btnTolak btn-danger">Tolak</a>
                            </div>
                        </li>
                    @endif
                    @if ($item->acc_ppk == 1)
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Aksi</span>
                            <div>
                            </div>
                            <div>
                                <a href="{{ route('ppk.surat-non-pbj-disposisi.index', $item->id) }}"
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
                <form action="{{ route('ppk.surat-non-pbj.tolak', $item->id) }}" method="post">
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
