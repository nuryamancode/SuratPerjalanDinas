@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Detail SPJ</h4>
                    <ul class="list-inline">
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Tingkat Biaya</span>
                            <span>{{ $item->spd_detail->tingkat_biaya }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Maksud Perjalana Dinas</span>
                            <span>{{ $item->maksud_perjalanan_dinas }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>File Draft</span>
                            <span>
                                <a href="{{ $item->downloadFile() }}" target="_blank"
                                    class="btn btn-success btn-sm">Lihat</a>
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Status</span>
                            <span>
                                {!! $item->status() !!}
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Aksi</span>
                            <div>
                                <a href="{{ route('surat-pertanggung-jawaban.index') }}"
                                    class="btn btn-sm btn-warning">Kembali</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-3 justify-content-between">
                        <h4 class="card-title ">Detail Biaya</h4>
                        <a href="{{ route('surat-pertanggung-jawaban-detail.create', [
                            'spj_id' => $item->id,
                        ]) }}"
                            class="btn btn-primary btn-sm">Tambah
                            Data</a>
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
                                    <th>Aksi</th>
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
                                            <a href="{{ $item->downloadFile() }}" target="_blank"
                                                class="btn btn-success btn-sm">Lihat</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('surat-pertanggung-jawaban-detail.edit', $detail->uuid) }}"
                                                class="btn btn-sm py-2 btn-info">Edit</a>
                                            <form action="javascript:void(0)" method="post" class="d-inline"
                                                id="formDelete">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                    data-action="{{ route('surat-pertanggung-jawaban-detail.destroy', $detail->uuid) }}">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    <x-Admin.Sweetalert />
