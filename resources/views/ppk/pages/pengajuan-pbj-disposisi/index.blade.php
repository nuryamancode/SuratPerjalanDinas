@extends('ppk.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <style>
                .back:hover {
                    text-decoration: none;
                }
            </style>
            <a href="{{ route('ppk.pengajuan-pbj.index', $items->id) }}" class="back">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-arrow-left-bold-circle  pr-2 pt-1 icon-large"></i>
                    <span>Kembali</span>
                </div>
            </a>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Disposisi Pengajuan PBJ</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>Nomor Surat</th>
                                    <th>Perihal</th>
                                    <th>Asal Surat</th>
                                    <th>Tanggal Surat</th>
                                    <th>Diteruskan Kepada</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $items->pengajuan_barang_jasa->nomor_surat }}</td>
                                    <td>{{ $items->pengajuan_barang_jasa->perihal }}</td>
                                    <td>{{ $items->pengajuan_barang_jasa->karyawan->nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($items->pengajuan_barang_jasa->created_at)->format('d F Y') }}
                                    </td>
                                    <td>
                                        @if ($items->teruskan2 == null || $items->teruskan2->nama == null)
                                            {{ $items->teruskan1->nama }}
                                        @else
                                            {{ $items->teruskan2->nama }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($items->pengajuan_barang_jasa->acc_ppk == 0)
                                            <a href="{{ route('ppk.pengajuan-pbj-disposisi.edit', $items->id) }}"
                                                class="btn btn-sm py-2 btnTolak btn-primary">Tambahkan</a>
                                        @endif
                                        <form action="javascript:void(0)" method="post" class="d-inline" id="formDelete">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                data-action="{{ route('wakil-direktur-ii.pengajuan-pbj-disposisi.destroy', $items->id) }}">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
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
