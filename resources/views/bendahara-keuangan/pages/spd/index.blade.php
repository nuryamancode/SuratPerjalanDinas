@extends('bendahara-keuangan.layouts.app')
@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Filter</h4>
                    <form action="" method="get">
                        <div class='form-group'>
                            <select name='spd_uuid' id='spd_uuid'
                                class='form-control @error('spd_uuid') is-invalid @enderror'>
                                <option value='' selected disabled>Pilih Surat Perjalanan Dinas</option>
                                @foreach ($data_permohonan as $permohonan)
                                    <option @selected($permohonan->uuid == request('spd_uuid')) value='{{ $permohonan->uuid }}'>
                                        {{ $permohonan->surat->nomor_surat }}
                                    </option>
                                @endforeach
                            </select>
                            @error('spd_uuid')
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
                                    <th>Lama Perjalanan Dinas</th>
                                    <th>Tanggal Berangkat</th>
                                    <th>Tanggal Harus Pulang</th>
                                    <th>Catatan Lain-Lain</th>
                                    <th>Status Uang Muka</th>
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
                                        <td>{{ $item->lama_perjalanan ?? '-' }}</td>
                                        <td>{{ $item->tanggal_berangkat ?? '-' }}</td>
                                        <td>{{ $item->tanggal_harus_kembali ?? '-' }}</td>
                                        <td>{{ $item->keterangan_lain_lain ?? '-' }}</td>
                                        <td>{{ $item->statusUangMuka() }}</td>
                                        <td>
                                            {{-- <a href="{{ route('bendahara-keuangan.spd-detail-supir.index', [
                                                'spd_detail_uuid' => $item->uuid,
                                            ]) }}"
                                                class="btn btn-primary  py-2">Supir</a> --}}
                                            @if ($item->notEmpty())
                                                <a href="{{ route('bendahara-keuangan.spd-detail.print', $item->uuid) }}"
                                                    class="btn btn-sm py-2 btn-secondary">Print</a>
                                            @endif
                                            <a href="{{ route('bendahara-keuangan.spd-detail.edit', $item->uuid) }}"
                                                class="btn btn-sm py-2 btn-info">Isi SPD</a>
                                            @if ($item->karyawan_id == auth()->user()->karyawan->id)
                                                @if ($item->spj)
                                                    <a href="{{ route('bendahara-keuangan.spd-spj.show', $item->spj->uuid) }}"
                                                        class="btn btn-info  py-2">Lihat SPJ</a>
                                                @else
                                                    <a href="{{ route('bendahara-keuangan.spd-spj.create', [
                                                        'spd_detail_uuid' => $item->uuid,
                                                    ]) }}"
                                                        class="btn btn-primary  py-2">Buat SPJ</a>
                                                @endif
                                            @endif
                                            @if (!$item->uang_muka && $item->surat_perjalanan_dinas->verifikasi_ppk)
                                                <a href="{{ route('bendahara-keuangan.spd-detail-uang-muka.index', [
                                                    'spd_detail_uuid' => $item->uuid,
                                                ]) }}"
                                                    class="btn btn-primary  py-2">Input Uang Muka</a>
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
