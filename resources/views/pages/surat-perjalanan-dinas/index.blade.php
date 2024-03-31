@extends('layouts.app')
@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Filter</h4>
                    <form action="" method="get">
                        <div class='form-group'>
                            <select name='surat_perjalanan_dinas_id' id='surat_perjalanan_dinas_id'
                                class='form-control @error('surat_perjalanan_dinas_id') is-invalid @enderror'>
                                <option value='' selected disabled>Pilih Surat Perjalanan Dinas</option>
                                @foreach ($data_surat_perjalanan_dinas as $spd)
                                    <option @selected($spd->id == request('surat_perjalanan_dinas_id')) value='{{ $spd->id }}'>
                                        {{ $spd->surat->perihal }}
                                    </option>
                                @endforeach
                            </select>
                            @error('surat_perjalanan_dinas_id')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary">Filter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-3 justify-content-between">
                        <h4 class="card-title mb-3">Surat Perjalanan Dinas
                        </h4>
                        @if (count($items) > 0)
                            @if ($items[0]->surat_perjalanan_dinas->validasi_pemberangkatan == 0)
                                @can('Surat Perjalanan Dinas Verifikasi')
                                    <form
                                        action="{{ route('surat-perjalanan-dinas.validasi-pemberangkatan', request('surat_perjalanan_dinas_id')) }}"
                                        method="post">
                                        @csrf
                                        <div class="form-group">
                                            <button class="btn btn-success">Verifikasi</button>
                                        </div>

                                    </form>
                                @endcan
                            @endif
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Pelaksana</th>
                                    <th>Tempat Berangkat</th>
                                    <th>Tempat Tujuan</th>
                                    <th>Lama Perjalanan Dinas</th>
                                    <th>Tanggal Berangkat</th>
                                    <th>Tanggal Harus Pulang</th>
                                    <th>Catatan Lain-Lain</th>
                                    @canany(['Surat Perjalanan Dinas Detail Supir', 'Surat Perjalanan Dinas Detail Edit'])
                                        <th>Aksi</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->karyawan->nama }}</td>
                                        <td>{{ $item->tempat_berangkat ?? '-' }}</td>
                                        <td>{{ $item->tempat_tujuan ?? '-' }}</td>
                                        <td>{{ $item->lama_perjalanan ?? '-' }}</td>
                                        <td>{{ $item->tanggal_berangkat ?? '-' }}</td>
                                        <td>{{ $item->tanggal_harus_kembali ?? '-' }}</td>
                                        <td>{{ $item->keterangan_lain_lain ?? '-' }}</td>
                                        @canany(['Surat Perjalanan Dinas Detail Supir', 'Surat Perjalanan Dinas Detail
                                            Edit'])
                                            <td>
                                                @can('Surat Perjalanan Dinas Detail Supir')
                                                    <a href="{{ route('surat-perjalanan-dinas-supir.index', [
                                                        'surat_perjalanan_dinas_detail_id' => $item->id,
                                                    ]) }}"
                                                        class="btn btn-primary  py-2">Supir</a>
                                                @endcan
                                                @can('Surat Perjalanan Dinas Detail Edit')
                                                    <a href="{{ route('surat-perjalanan-dinas-detail.edit', $item->id) }}"
                                                        class="btn btn-sm py-2 btn-info">Edit</a>
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
