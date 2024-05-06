@extends('wakil-direktur-i.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Taksiran Surat Non PBJ</h4>
                    </div>
                    <a href="{{ route('wakil-direktur-i.surat-non-pbj.show', $suratNonPbj->uuid) }}"
                        class="btn my-2 mb-3 btn-sm py-2 btn-warning">Kembali</a>
                    <a href="{{ route('wakil-direktur-i.surat-non-pbj-detail.create', [
                        'surat_non_pbj_uuid' => $suratNonPbj->uuid,
                    ]) }}"
                        class="btn my-2 mb-3 btn-sm py-2 btn-primary">Tambah Data</a>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nomor Surat</th>
                                    <th>Kebutuhan Barang</th>
                                    <th>Volume</th>
                                    <th>Harga Satuan</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $suratNonPbj->nomor_surat }}</td>
                                        <td>{{ $item->kebutuhan_barang }}</td>
                                        <td>{{ $item->volume }}</td>
                                        <td>Rp. {{ number_format($item->harga_satuan) }}</td>
                                        <td>{{ $item->jumlah }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td>
                                            <a href="{{ route('wakil-direktur-i.surat-non-pbj-detail.edit', $item->uuid) }}"
                                                class="btn btn-sm py-2 btn-info">Edit</a>
                                            <form action="javascript:void(0)" method="post" class="d-inline"
                                                id="formDelete">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                    data-action="{{ route('wakil-direktur-i.surat-non-pbj-detail.destroy', $item->id) }}">Hapus</button>
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
    </div>
@endsection
<x-Admin.Sweetalert />
<x-Admin.Datatable />
