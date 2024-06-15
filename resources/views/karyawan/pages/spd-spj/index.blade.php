@extends('karyawan.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-3 justify-content-between">
                        <h4 class="card-title mb-3">Surat Pertanggung Jawaban SPD</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal Surat</th>
                                    <th>Status Surat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                                        <td>{!! $item->spd->statusSPJ() !!}</td>
                                        <td>
                                            @if ($item->status_spj == 1)
                                                <a href="{{ route('karyawan.spd-spj.print', $item->id) }}" target="_blank"
                                                    class="btn btn-secondary py-2">Print Kwitansi</a>
                                            @endif
                                            <a href="{{ route('karyawan.spd-spj.show', $item->id) }}"
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
