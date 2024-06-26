@extends('pelaksana-belanja.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Detail SPJ</h4>
                    <ul class="list-inline">
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Via</span>
                            <span>{{ $item->spjFormNonPbj->via }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Status</span>
                            <span>
                                {!! $item->spjFormNonPbj->status() !!}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-3 justify-content-between">
                        <h4 class="card-title ">Detail Biaya</h4>
                        <a href="{{ route('pelaksana-belanja.pengajuan-form-non-pbj-spj-detail.create', [
                            'spj_uuid' => $item->spjFormNonPbj->uuid,
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
                                @foreach ($item->spjFormNonPbj->details as $detail)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $detail->perincian_biaya }}</td>
                                        <td>{{ number_format($detail->nominal) }}</td>
                                        <td>{{ $detail->keterangan }}</td>
                                        <td>
                                            <a href="{{ $detail->downloadFile() }}" target="_blank"
                                                class="btn btn-success btn-sm">Lihat</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('pelaksana-belanja.pengajuan-form-non-pbj-spj-detail.edit', $detail->uuid) }}"
                                                class="btn btn-sm py-2 btn-info">Edit</a>
                                            <form action="javascript:void(0)" method="post" class="d-inline"
                                                id="formDelete">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                    data-action="{{ route('pelaksana-belanja.pengajuan-form-non-pbj-spj-detail.destroy', $detail->uuid) }}">Hapus</button>
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
