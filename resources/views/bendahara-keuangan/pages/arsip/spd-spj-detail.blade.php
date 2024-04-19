@extends('bendahara-keuangan.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Detail SPJ</h4>
                    <ul class="list-inline">
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span class="font-weight-bold">Tingkat Biaya</span>
                            <span>{{ $item->spd_detail->tingkat_biaya }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span class="font-weight-bold">Maksud Perjalana Dinas</span>
                            <span>{{ $item->spd_detail->maksud_perjalanan_dinas }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span class="font-weight-bold">File Draft</span>
                            <span>
                                <a href="{{ $item->downloadFile() }}" target="_blank"
                                    class="btn btn-success btn-sm">Lihat</a>
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span class="font-weight-bold">Keterangan PPK</span>
                            <span>
                                {{ $item->keterangan_ppk ?? '-' }}
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span class="font-weight-bold">Status</span>
                            <span>
                                {!! $item->status() !!}
                            </span>
                        </li>

                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Aksi</span>
                            <div>
                                <a href="{{ route('bendahara-keuangan.arsip-spd-spj.index') }}"
                                    class="btn btn-sm btn-warning">Kembali</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-3 justify-content-between">
                        <h4 class="card-title ">Detail Biaya</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Perincian Biaya</th>
                                    <th>Nominal</th>
                                    <th>Keterangan</th>
                                    <th>File Dokumen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($item->details as $detail)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $detail->perincian_biaya }}</td>
                                        <td>Rp. {{ number_format($detail->nominal) }}</td>
                                        <td>{{ $detail->keterangan }}</td>
                                        <td>
                                            <a href="{{ $item->downloadFile() }}" target="_blank"
                                                class="btn btn-success btn-sm">Lihat</a>
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
<x-Admin.Datatable />
<x-Admin.Sweetalert />
