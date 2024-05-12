@extends('wakil-direktur-ii.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <style>
                .back:hover {
                    text-decoration: none;
                }
            </style>
            <a href="{{ route('wakil-direktur-ii.pengajuan-pbj.index', $pengajuan->id) }}" class="back">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-arrow-left-bold-circle  pr-2 pt-1 icon-large"></i>
                    <span>Kembali</span>
                </div>
            </a>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Disposisi Pengajuan PBJ</h4>
                        <a href="{{ route('wakil-direktur-ii.pengajuan-pbj-disposisi.create', $pengajuan->id) }}"
                            class="btn my-2 mb-3 btn-sm py-2 btn-primary">Buat Disposisi</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nomor Surat</th>
                                    <th>Perihal</th>
                                    <th>Asal Surat</th>
                                    <th>Tanggal Surat</th>
                                    <th>Diteruskan Kepada</th>
                                    {{--  <th>Tipe Disposisi</th>
                                    <th>Catatan Disposisi</th>  --}}
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->pengajuan_barang_jasa->nomor_surat }}</td>
                                        <td>{{ $item->pengajuan_barang_jasa->perihal }}</td>
                                        <td>{{ $item->pengajuan_barang_jasa->karyawan->nama }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}</td>
                                        <td>{{ $item->teruskan1->nama }}</td>
                                        <td>
                                            <form action="javascript:void(0)" method="post" class="d-inline"
                                                id="formDelete">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                    data-action="{{ route('wakil-direktur-ii.pengajuan-pbj-disposisi.destroy', $item->id) }}">Hapus</button>
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
