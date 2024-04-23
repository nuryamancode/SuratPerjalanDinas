@extends('timppk.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Pengajuan PBJ</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nomor Surat</th>
                                    <th>Nomor Agenda</th>
                                    <th>Tanggal Surat</th>
                                    <th>Perihal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->pengajuan->nomor_surat }}</td>
                                        <td>{{ $item->pengajuan->nomor_agenda }}</td>
                                        <td>{{ $item->pengajuan->tanggal }}</td>
                                        <td>{{ $item->pengajuan->perihal }}</td>
                                        <td>
                                            @if ($item->is_penanggung_jawab == 1)
                                                <a href="{{ route('timppk.pengajuan-pbj-proses.index', [
                                                    'pbj_uuid' => $item->pengajuan->uuid,
                                                ]) }}"
                                                    class="btn btn-sm py-2 btn-info">Proses PBJ</a>
                                            @endif
                                            <a href="{{ route('kabag.pengajuan-pbj.show', $item->uuid) }}"
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
