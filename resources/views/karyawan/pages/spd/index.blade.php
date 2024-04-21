@extends('karyawan.layouts.app')
@section('content')
    {{-- <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Filter</h4>
                    <form action="" method="get">
                        <div class='form-group'>
                            <select name='surat_perjalanan_dinas_id' id='surat_perjalanan_dinas_id'
                                class='form-control @error('surat_perjalanan_dinas_id') is-invalid @enderror'>
                                <option value='' selected disabled>Pilih Surat Perjalanan Dinas</option>
                                @foreach ($data_permohonan as $permohonan)
                                    <option @selected($permohonan->uuid == request('spd_uuid')) value='{{ $permohonan->id }}'>
                                        {{ $permohonan->surat->nomor_surat }}
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
    </div> --}}
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
                                    <th>Uang Muka</th>
                                    <th>Status Uang Muka</th>
                                    <th>Status</th>
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
                                        <td>{{ $item->uang_muka ? 'Rp. ' . number_format($item->uang_muka->nominal) : '-' }}
                                        <td>{{ $item->statusUangMuka() }}</td>
                                        <td>{!! $item->status() !!}</td>
                                        <td>
                                            @if ($item->spj && $item->spj->status)
                                                <a href="{{ route('karyawan.spd-spj.print', $item->spj->uuid) }}"
                                                    class="btn btn-secondary py-2">Print Kwitansi</a>
                                            @endif
                                            {{-- <a href="{{ route('karyawan.spd-detail-supir.index', [
                                                'spd_detail_uuid' => $item->uuid,
                                            ]) }}"
                                                class="btn btn-primary  py-2">Supir</a> --}}
                                            {{-- <a href="{{ route('karyawan.spd-detail.edit', $item->uuid) }}"
                                                class="btn btn-sm py-2 btn-info">Isi SPD</a> --}}
                                            @if ($item->uang_muka)
                                                @if ($item->spj)
                                                    <a href="{{ route('karyawan.spd-spj.show', $item->spj->uuid) }}"
                                                        class="btn btn-info  py-2">Lihat SPJ</a>
                                                @else
                                                    <a href="{{ route('karyawan.spd-spj.create', [
                                                        'spd_detail_uuid' => $item->uuid,
                                                    ]) }}"
                                                        class="btn btn-primary  py-2">Buat SPJ</a>
                                                @endif
                                            @else
                                                <a href="javascript:void()" class="btn btn-primary disabled py-2"
                                                    disabled>Buat
                                                    SPJ</a>
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
