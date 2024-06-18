@extends('bendahara-keuangan.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Permohonan Surat Perjalanan Dinas</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nomor Surat</th>
                                    <th>Maksud Perjalanan Dinas</th>
                                    <th>Tanggal Surat</th>
                                    <th>Nominal Pelaksana</th>
                                    <th>Nominal Supir</th>
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
                                        <td>
                                            @if ($item->uang_muka_pelaksana)
                                                Rp. {{ number_format($item->uang_muka_pelaksana->nominal) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->uang_muka_supir)
                                                Rp. {{ number_format($item->uang_muka_supir->nominal) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $item->status }}</td>
                                        {{-- <td>{{ $item->statusUangMuka() }}</td> --}}
                                        <td>
                                            @if ($item->status == 'SPD Sudah Di TTD')
                                                @if ($item->surat->antar == 1)
                                                    <a href="{{ route('bendahara-keuangan.uang-muka-spd.index', $item->spd_supir->id) }}"
                                                        class="btn btn-sm py-2 btn-primary">Uang Muka Supir</a>
                                                @else
                                                    <a href="{{ route('bendahara-keuangan.uang-muka-spd.pelaksana', $item->spd_pelaksana_dinas->id) }}"
                                                        class="btn btn-sm py-2 btn-primary">Uang Muka Pelaksana</a>
                                                @endif
                                            @elseif($item->status == 'Uang Muka Supir Sudah Disubmit')
                                                <a href="{{ route('bendahara-keuangan.uang-muka-spd.pelaksana', $item->spd_pelaksana_dinas->id) }}"
                                                    class="btn btn-sm py-2 btn-primary">Uang Muka Pelaksana</a>
                                            @endif
                                            @if ($item->spd_pelaksana_dinas)
                                                @if ($item->spd_supir)
                                                    @if ($item->surat->antar == 1)
                                                        <a href="{{ route('bendahara-keuangan.buat-spd.print', $item->spd_supir->id) }}"
                                                            target="_blank" class="btn btn-sm py-2 btn-info">Print SPD
                                                            Supir</a>
                                                    @endif
                                                @else
                                                    {{ null }}
                                                @endif
                                                <a href="{{ route('bendahara-keuangan.buat-spd.print-pelaksana', $item->spd_pelaksana_dinas->id) }}"
                                                    target="_blank" class="btn btn-sm py-2 btn-info">Print SPD Pelaksana</a>
                                            @endif
                                            <a href="{{ route('bendahara-keuangan.permohonan-spd.show', $item->id) }}"
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
@push('scripts')
@endpush
