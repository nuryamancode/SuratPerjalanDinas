@extends('timppk.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Detail SPJ</h4>
                    <ul class="list-inline">
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span class="font-weight-bold">Pembayaran</span>
                            <span>{{ $formNonPbj->untuk_pembayaran }}</span>
                        </li>

                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Aksi</span>
                            <div>
                                <a href="{{ route('timppk.form-non-pbj.index') }}" class="btn btn-sm btn-warning">Kembali</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-3 justify-content-between">
                        <h4 class="card-title ">Detail Biaya</h4>
                        @if ($formNonPbj->acc_ppk == 0)
                            <a href="{{ route('timppk.form-non-pbj-spj-detail.create', [
                                'spj_uuid' => $formNonPbj->uuid,
                            ]) }}"
                                class="btn btn-primary btn-sm">Tambah
                                Data</a>
                        @endif
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
                                @foreach ($formNonPbj->details as $detail)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $detail->perincian_biaya }}</td>
                                        <td>Rp. {{ number_format($detail->nominal) }}</td>
                                        <td>{{ $detail->keterangan }}</td>
                                        <td>
                                            <a href="{{ $detail->downloadFile() }}" target="_blank"
                                                class="btn btn-success btn-sm">Lihat</a>
                                        </td>
                                        <td>
                                            @if ($formNonPbj->acc_ppk == 0)
                                                <a href="{{ route('timppk.form-non-pbj-spj-detail.edit', $detail->uuid) }}"
                                                    class="btn btn-sm py-2 btn-info">Edit</a>
                                                <form action="javascript:void(0)" method="post" class="d-inline"
                                                    id="formDelete">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                        data-action="{{ route('timppk.form-non-pbj-spj-detail.destroy', $detail->uuid) }}">Hapus</button>
                                                </form>
                                            @else
                                                -
                                            @endif
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
@endsection
<x-Admin.Datatable />
<x-Admin.Sweetalert />
