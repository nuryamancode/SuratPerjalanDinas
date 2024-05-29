@extends('wakil-direktur-ii.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <style>
                .back:hover {
                    text-decoration: none;
                }
            </style>
            <a href="{{ route('wakil-direktur-ii.pengajuan-belanja.index') }}" class="back">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-arrow-left-bold-circle  pr-2 pt-1 icon-large"></i>
                    <span>Kembali</span>
                </div>
            </a>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Disposisi Surat Non PBJ</h4>
                        @if ($pengajuan->verifikasi_wadir2 == 0)
                            <a href="{{ route('wakil-direktur-ii.surat-non-pbj-disposisi.create', $pengajuan->id) }}"
                                class="btn my-2 mb-3 btn-sm py-2 btn-primary">Buat Disposisi</a>
                        @endif
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
                                    @if ($pengajuan->verifikasi_wadir2 == 0)
                                        <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->surat_non_pbj->nomor_surat }}</td>
                                        <td>{{ $item->surat_non_pbj->perihal }}</td>
                                        <td>{{ $item->surat_non_pbj->karyawan->nama }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->surat_non_pbj->created_at)->format('d F Y') }}
                                        </td>
                                        <td>
                                            {{ $item->teruskan1->nama }}
                                        </td>
                                        @if ($pengajuan->verifikasi_wadir2 == 0)
                                            <td>
                                                @if ($pengajuan->acc_ppk == '2')
                                                    <a href="{{ route('wakil-direktur-ii.surat-non-pbj-disposisi.edit', $item->id) }}"
                                                        class="btn btn-sm py-2 btn-warning">Kirim Ulang</a>
                                                @else
                                                    <a href="{{ route('wakil-direktur-ii.surat-non-pbj-disposisi.edit', $item->id) }}"
                                                        class="btn btn-sm py-2 btn-warning">Edit</a>
                                                @endif
                                            </td>
                                        @endif
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
