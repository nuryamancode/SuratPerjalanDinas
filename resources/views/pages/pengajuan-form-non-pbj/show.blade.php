@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md">
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
                            <span>{{ $item->nomor_agenda }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Tanggal</span>
                            <span>{{ $item->tanggal }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Perihal</span>
                            <span>{{ $item->perihal }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Pelaksana</span>
                            <div>
                                <ol class="list-group">
                                    @foreach ($item->pelaksana as $pelaksana)
                                        <li>
                                            {{ $pelaksana->karyawan->nama }}
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Aksi</span>
                            <div>
                                <a href="{{ route('pengajuan-form-non-pbj.index') }}"
                                    class="btn btn-sm btn-warning">Kembali</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @can('Pengajuan Form Non PBJ Detail Index')
            <div class="col-md mt-2">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mb-3">Detail </h4>
                            @can('Pengajuan Form Non PBJ Detail Create')
                                <a href="{{ route('pengajuan-form-non-pbj-detail.create', [
                                    'pengajuan_pbj_uuid' => $item->uuid,
                                ]) }}"
                                    class="btn my-2 mb-3 btn-sm py-2 btn-primary">Tambah
                                    Detail</a>
                            @endcan
                        </div>
                        <div class="table-responsive">
                            <table class="table dtTable table-hover">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Kebutuhan Barang</th>
                                        <th>Volume</th>
                                        <th>Satuan</th>
                                        <th>Harga Satuan</th>
                                        <th>Jumlah</th>
                                        <th>Total Harga</th>
                                        @canany(['Pengajuan Form Non PBJ Detail Edit', 'Pengajuan Form Non PBJ Detail Delete'])
                                            <th>Aksi</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($item->details as $detail)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $detail->kebutuhan_barang }}</td>
                                            <td>{{ $detail->volume }}</td>
                                            <td>{{ $detail->satuan }}</td>
                                            <td>Rp. {{ number_format($detail->harga_satuan) }}</td>
                                            <td>{{ $detail->jumlah }}</td>
                                            <td>Rp. {{ number_format($detail->total_harga) }}</td>
                                            @canany([
                                                'Pengajuan Form Non PBJ Detail Edit',
                                                'Pengajuan Form Non PBJ Detail
                                                Delete',
                                                ])
                                                <td>
                                                    @can('Pengajuan Form Non PBJ Detail Edit')
                                                        <a href="{{ route('pengajuan-form-non-pbj-detail.edit', $detail->uuid) }}"
                                                            class="btn btn-sm py-2 btn-info">Edit</a>
                                                    @endcan
                                                    @can('Pengajuan Form Non PBJ Detail Delete')
                                                        <form action="javascript:void(0)" method="post" class="d-inline"
                                                            id="formDelete">
                                                            @csrf
                                                            @method('delete')
                                                            <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                                data-action="{{ route('pengajuan-form-non-pbj-detail.destroy', $detail->uuid) }}">Hapus</button>
                                                        </form>
                                                    @endcan
                                                </td>
                                            @endcanany
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
@endsection
<x-Admin.Sweetalert />
<x-Admin.Datatable />
