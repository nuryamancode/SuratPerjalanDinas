@extends('kabag.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Pengajuan Surat Non PBJ</h4>
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
                                    <th>Taksiran</th>
                                    <th>Status Surat</th>
                                    <th>Acc Wadir 2</th>
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
                                        <td>
                                            {{ $item->details ? number_format($item->details()->sum('harga_satuan')) : '0' }}
                                        </td>
                                        <td>{{ $item->status }}</td>
                                        <td>{!! $item->statusAccWadir2() !!}</td>

                                        <td>

                                            @if ($item->verifikasi_kabag == 0)
                                                <form action="{{ route('kabag.surat-non-pbj.verifikasi', $item->uuid) }}"
                                                    method="post" class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-sm py-2 btn-success">Set Verifikasi</button>
                                                </form>
                                            @endif
                                            <a href="{{ route('kabag.surat-non-pbj.show', $item->uuid) }}"
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
