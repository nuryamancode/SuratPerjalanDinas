@extends('wakil-direktur-ii.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Pengajuan Belanja</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Jenis</th>
                                    <th>Nomor Surat</th>
                                    <th>Nomor Agenda</th>
                                    <th>Perihal</th>
                                    <th>Tanggal Surat</th>
                                    <th>Pengusul</th>
                                    <th>Status Surat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($item as $pbj)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><span class="bg-warning p-2 rounded">PBJ</span></td>
                                        <td>{{ $pbj->nomor_surat }}</td>
                                        <td>{{ $pbj->nomor_agenda }}</td>
                                        <td>{{ $pbj->perihal }}</td>
                                        <td>{{ \Carbon\Carbon::parse($pbj->created_at)->format('d F Y') }}</td>
                                        <td>
                                            <ol>
                                                @foreach ($pbj->pengusul as $pengusul)
                                                    <li>{{ $pengusul->karyawan->nama ?? '-' }}</li>
                                                @endforeach
                                            </ol>
                                        </td>
                                        <td>{{ $pbj->status_surat }}</td>
                                        <td>
                                            @if ($pbj->verifikasi_wadir2 == 0)
                                                <form
                                                    action="{{ route('wakil-direktur-ii.pengajuan-pbj.verifikasi', $pbj->id) }}"
                                                    method="post" class="d-inline">
                                                    @csrf
                                                    <button class="btn py-2  btn-sm btn-success">Verifikasi</button>
                                                </form>
                                            @else
                                                <a href="{{ route('wakil-direktur-ii.pengajuan-pbj.print', $pbj->id) }}" target="_blank"
                                                    class="btn btn-sm py-2 btn-primary">Print</a>
                                            @endif
                                            <a href="{{ route('wakil-direktur-ii.pengajuan-belanja.show.pbj', $pbj->id) }}"
                                                class="btn btn-sm py-2 btn-warning">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                                @foreach ($items as $suratnonpbj)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><span class="bg-primary p-2 rounded text-white">Surat Non PBJ</span></td>
                                        <td>{{ $suratnonpbj->nomor_surat }}</td>
                                        <td>{{ $suratnonpbj->nomor_agenda }}</td>
                                        <td>{{ $suratnonpbj->perihal }}</td>
                                        <td>{{ \Carbon\Carbon::parse($suratnonpbj->created_at)->format('d F Y') }}</td>
                                        <td>
                                            <ol>
                                                @foreach ($suratnonpbj->pengusul as $pengusul)
                                                    <li>{{ $pengusul->karyawan->nama ?? '-' }}</li>
                                                @endforeach
                                            </ol>
                                        </td>
                                        <td>{{ $suratnonpbj->status_surat }}</td>
                                        <td>
                                            @if ($suratnonpbj->verifikasi_wadir2 == 0)
                                                @if ($suratnonpbj->acc_wadir2 == 1 || $suratnonpbj->acc_wadir2 == 0)
                                                    <form
                                                        action="{{ route('wakil-direktur-ii.surat-non-pbj.verifikasi', $suratnonpbj->id) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        <button class="btn py-2  btn-sm btn-success">Verifikasi</button>
                                                    </form>
                                                @endif
                                            @else
                                                <a href="{{ route('wakil-direktur-ii.surat-non-pbj.print', $suratnonpbj->id) }}"
                                                    target="_blank" class="btn btn-sm py-2 btn-primary">Print</a>
                                            @endif
                                            <a href="{{ route('wakil-direktur-ii.pengajuan-belanja.show.suratnonpbj', $suratnonpbj->id) }}"
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
    <script></script>
@endpush
