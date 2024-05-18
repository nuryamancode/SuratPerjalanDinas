@extends('ppk.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <style>
                .back:hover {
                    text-decoration: none;
                }
            </style>
            <a href="{{ route('ppk.surat-non-pbj.index') }}" class="back">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-arrow-left-bold-circle  pr-2 pt-1 icon-large"></i>
                    <span>Kembali</span>
                </div>
            </a>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Disposisi Surat Non PBJ</h4>
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
                                    @if ($item->surat_non_pbj->acc_ppk === '0')
                                        <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $item->surat_non_pbj->nomor_surat }}</td>
                                    <td>{{ $item->surat_non_pbj->perihal }}</td>
                                    <td>{{ $item->surat_non_pbj->karyawan->nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->surat_non_pbj->created_at)->format('d F Y') }}
                                    </td>
                                    <td>
                                        @if ($item->teruskan2 == null || $item->teruskan2->nama == null)
                                            {{ $item->teruskan1->nama }}
                                        @else
                                            {{ $item->teruskan2->nama }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->surat_non_pbj->acc_ppk === '0')
                                            <a href="{{ route('ppk.surat-non-pbj-disposisi.create', $item->id) }}"
                                                class="btn btn-sm py-2 btnTolak btn-primary">Tambahkan</a>
                                        @endif
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
