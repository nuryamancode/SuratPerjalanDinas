@extends('bendahara-keuangan.layouts.app')
@section('content')
    {{--  <div class="row mb-3">
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
    </div>  --}}
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
                                    <th>Nomor Surat</th>
                                    <th>Maksud Perjalanan Dinas</th>
                                    <th>Tanggal Surat</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->surat->nomor_surat }}</td>
                                        <td>{{ $item->surat->maksud_perjalanan_dinas }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->surat->created_at)->format('d M Y') }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>
                                            @if ($item->surat->antar == 1)
                                                <a href="{{ route('bendahara-keuangan.arsip-spd-spj.detail-supir', $item->spd_supir->id) }}"
                                                    class="btn btn-sm py-2 btn-info">Lihat SPJ Supir</a>
                                            @endif
                                            <a href="{{ route('bendahara-keuangan.arsip-spd-spj.detail', $item->spd_pelaksana_dinas->id) }}"
                                                class="btn btn-sm py-2 btn-info">Lihat SPJ Pelaksana</a>
                                            <a href="{{ route('bendahara-keuangan.arsip-spd-spj.show', $item->id) }}"
                                                class="btn btn-sm py-2 btn-warning">Detail</a>
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
