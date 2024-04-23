@extends('kabag.layouts.app')
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
                                    <th>Pengusul</th>
                                    <th>Status Surat</th>
                                    <th>Verifikasi Kabag</th>
                                    <th>Status Uang Muka</th>
                                    <th>Status</th>
                                    <th>Tahapan Terakhir</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nomor_surat }}</td>
                                        <td>{{ $item->nomor_agenda }}</td>
                                        <td>{{ $item->tanggal }}</td>
                                        <td>{{ $item->perihal }}</td>
                                        <td>
                                            <ul>
                                                @foreach ($item->pengusul as $pengusul)
                                                    <li>{{ $pengusul->karyawan->nama ?? '-' }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>{{ $item->status() }}</td>
                                        <td>{{ $item->statusVerifikasiKabag() }}</td>
                                        <td>{{ $item->statusUangMuka() }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>{{ $item->proses ? $item->proses->first()->tahapan->nama ?? '-' : '-' }}</td>
                                        <td>
                                            @if ($item->verifikasi_kabag == 0)
                                                <form action="{{ route('kabag.pengajuan-pbj.verifikasi', $item->uuid) }}"
                                                    method="post" class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-sm py-2 btn-success">Set Verifikasi</button>
                                                </form>
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
