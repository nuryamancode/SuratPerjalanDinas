@extends('ppk.layouts.app')
@section('content')
    <style>
        .back:hover {
            text-decoration: none;
        }
    </style>
    <a href="{{ route('ppk.form-non-pbj-spj.index') }}" class="back">
        <div class="d-flex align-items-center">
            <i class="mdi mdi-arrow-left-bold-circle  pr-2 pt-1 icon-large"></i>
            <span>Kembali</span>
        </div>
    </a>
    <div class="card mb-3">
        <h1 class="card-title mt-3 text-center">Detail Surat Non PBJ SPJ</h1>
        <div class="card-body">
            <form action="">
                <div class='form-group mb-3'>
                    <label for='nomor_surat' class='mb-2'>Pengirim</label>
                    <input type='text' name='' id='nomor_surat'
                        class='form-control @error('nomor_surat') is-invalid @enderror' value='{{ $item->karyawan->nama }}'
                        readonly>
                    @error('nomor_surat')
                        <div class='invalid-feedback'>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class='form-group mb-3'>
                    <label for='nomor_surat' class='mb-2'>Tanggal SPJ</label>
                    <input type='text' name='' id='nomor_surat'
                        class='form-control @error('nomor_surat') is-invalid @enderror'
                        value='{{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}' readonly>
                    @error('nomor_surat')
                        <div class='invalid-feedback'>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class='form-group mb-3'>
                    <label for='nomor_surat' class='mb-2'>Status SPJ</label>
                    <input type='text' name='' id='nomor_surat'
                        class='form-control @error('nomor_surat') is-invalid @enderror' value='{!! $item->status() !!}'
                        readonly>
                    @error('nomor_surat')
                        <div class='invalid-feedback'>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        @if ($item->acc_ppk == 0)
            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-5">Aksi SPJ</h4>
                        <ul class="list-inline">
                            <li class="list-item mb-4 ">
                                <form action="{{ route('ppk.form-non-pbj-spj.acc', $item->id) }}" class="d-inline"
                                    id="formAcc" method="post">
                                    @csrf
                                    <button class="btn btnAcc btn-sm py-2 btn-success">Terima</button>
                                </form>
                                <a href="#" data-toggle="modal" data-target="#modalKeterangan"
                                    class="btn btn-sm py-2 btnTolak btn-danger">Tolak</a>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @endif
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-3 justify-content-between">
                        <h4 class="card-title ">Detail Biaya</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Perincian Biaya</th>
                                    <th>Nominal</th>
                                    <th>Keterangan</th>
                                    <th>File Dokumen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($item->details as $detail)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $detail->perincian_biaya }}</td>
                                        <td>{{ number_format($detail->nominal) }}</td>
                                        <td>{{ $detail->keterangan }}</td>
                                        <td>
                                            <a href="{{ $detail->downloadFile() }}" target="_blank"
                                                class="btn btn-success btn-sm">Lihat</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
                <form action="{{ route('ppk.form-non-pbj-spj.tolak', $item->id) }}" method="post">
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
