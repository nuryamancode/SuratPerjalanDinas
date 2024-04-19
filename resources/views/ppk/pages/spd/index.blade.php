@extends('ppk.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-3 justify-content-between">
                        <h4 class="card-title mb-3">Surat Perjalanan Dinas</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Pelaksana</th>
                                    <th>Tempat Berangkat</th>
                                    <th>Tempat Tujuan</th>
                                    <th>Tanggal Berangkat</th>
                                    <th>Tanggal Harus Pulang</th>
                                    <th>Nominal Uang Muka</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->karyawan->nama }}</td>
                                        <td>{{ $item->tempat_berangkat ?? '-' }}</td>
                                        <td>{{ $item->tempat_tujuan ?? '-' }}</td>
                                        <td>{{ $item->tanggal_berangkat ?? '-' }}</td>
                                        <td>{{ $item->tanggal_harus_kembali ?? '-' }}</td>
                                        <td>{{ $item->uang_muka ? 'Rp. ' . number_format($item->uang_muka->nominal) : '-' }}
                                        </td>
                                        <td>
                                            @if ($item->spj)
                                                <a href="{{ route('ppk.spd-spj.show', $item->spj->uuid) }}"
                                                    class="btn btn-info  py-2">Lihat SPJ</a>
                                            @else
                                                <a href="{{ route('ppk.spd-spj.create', [
                                                    'spd_detail_uuid' => $item->uuid,
                                                ]) }}"
                                                    class="btn btn-primary  py-2">Buat SPJ</a>
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
<x-Admin.Sweetalert />
<x-Admin.Datatable />
