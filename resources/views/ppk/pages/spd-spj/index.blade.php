@extends('ppk.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-3 justify-content-between">
                        <h4 class="card-title mb-3">Surat Pertanggung Jawaban SPD </h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Pembuat SPJ</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Status SPJ</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $pelaksana)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pelaksana->karyawan->nama ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($pelaksana->created_at)->format('d M Y') }}</td>
                                        <td>
                                            @if ($pelaksana->status_spj == 0)
                                                <span class="btn-primary btn btn-sm disabled">Belum diperiksa</span>
                                            @else
                                                @if ($pelaksana->status_spj == 2)
                                                    <span class="btn-danger btn btn-sm disabled">Ditolak</span>
                                                @else
                                                    <span class="btn-success btn btn-sm disabled">Disetujui</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('ppk.spd-spj.show', $pelaksana->id) }}"
                                                class="btn btn-warning  py-2">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                                @foreach ($item as $supir)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $supir->karyawan->nama ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($supir->created_at)->format('d M Y') }}</td>
                                        <td>
                                            @if ($supir->status_spj == 0)
                                                <span class="btn-primary btn btn-sm disabled">Belum diperiksa</span>
                                            @else
                                                <span class="btn-success btn btn-sm disabled">Sudah diperiksa</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('ppk.spd-spj.show-supir', $supir->id) }}"
                                                class="btn btn-warning  py-2">Detail</a>
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
@push('scripts')
@endpush
