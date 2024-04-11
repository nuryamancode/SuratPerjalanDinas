@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-3 justify-content-between">
                        <h4 class="card-title mb-3">SPJ Form Non PBJ
                        </h4>
                        @can('SPJ Form Non PBJ Create')
                            <a href="{{ route('spj-form-non-pbj.create') }}" class="btn btn-primary">Tambah SPJ</a>
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tingkat Biaya</th>
                                    <th>Maksud Perjalanan Dinas</th>
                                    <th>Tempat Berangkat</th>
                                    <th>Tempat Tujuan</th>
                                    <th>Pelaksana</th>
                                    <th>Draf SPJ</th>
                                    <th>Total Biaya</th>
                                    <th>Status</th>
                                    @canany([
                                        'SPJ Form Non PBJ Verifikasi',
                                        'SPJ Form Non PBJ Show',
                                        'SPJ Form Non PBJ
                                        Edit',
                                        'SPJ Form Non PBJ Delete',
                                        ])
                                        <th>Aksi</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->spd_detail->tingkat_biaya }}</td>
                                        <td>{{ $item->spd_detail->maksud_perjalanan_dinas }}</td>
                                        <td>{{ $item->spd_detail->tempat_berangkat }}</td>
                                        <td>{{ $item->spd_detail->tempat_tujuan }}</td>
                                        <td>{{ $item->spd_detail->karyawan->nama }}</td>
                                        <td>
                                            <a href="{{ $item->downloadFile() }}" class="btn btn-sm btn-success"
                                                target="_blank">Lihat</a>
                                        </td>
                                        <td>Rp. {{ number_format($item->details()->sum('nominal')) ?? '-' }}</td>
                                        <td>{!! $item->status() !!}</td>
                                        @canany([
                                            'SPJ Form Non PBJ Verifikasi',
                                            'SPJ Form Non PBJ Show',
                                            'SPJ Form Non PBJ
                                            Edit',
                                            'SPJ Form Non PBJ Delete',
                                            ])
                                            <td>

                                                @can('SPJ Form Non PBJ Verifikasi')
                                                    @if ($item->status != 1)
                                                        <a href="{{ route('sjp-barang-jasa.verifikasi', [
                                                            'uuid' => $item->uuid,
                                                            'status' => 1,
                                                        ]) }}"
                                                            class="btn btn-success  py-2">Setujui</a>
                                                    @else
                                                        <a href="{{ route('sjp-barang-jasa.verifikasi', [
                                                            'uuid' => $item->uuid,
                                                            'status' => 2,
                                                        ]) }}"
                                                            class="btn btn-danger  py-2">Tolak</a>
                                                    @endif
                                                @endcan
                                                @can('SPJ Form Non PBJ Show')
                                                    <a href="{{ route('sjp-barang-jasa.show', $item->uuid) }}"
                                                        class="btn btn-warning  py-2">Detail</a>
                                                @endcan
                                                @can('SPJ Form Non PBJ Edit')
                                                    <a href="{{ route('sjp-barang-jasa.edit', $item->uuid) }}"
                                                        class="btn btn-sm py-2 btn-info">Edit</a>
                                                @endcan
                                                @can('SPJ Form Non PBJ Delete')
                                                    <form action="javascript:void(0)" method="post" class="d-inline"
                                                        id="formDelete">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                            data-action="{{ route('sjp-barang-jasa.destroy', $item->uuid) }}">Hapus</button>
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
    </div>
@endsection
<x-Admin.Sweetalert />
<x-Admin.Datatable />
