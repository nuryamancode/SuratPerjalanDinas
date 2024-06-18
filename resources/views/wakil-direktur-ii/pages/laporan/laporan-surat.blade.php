@extends('wakil-direktur-ii.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Laporan Non PBJ Surat</h4>
                        {{-- Form Filter Bulan --}}
                        <form action="{{ route('wakil-direktur-ii.laporan.surat') }}" method="GET" class="mb-3">
                            <div class="form-group">
                                <label for="filter_bulan">Filter Bulan</label>
                                <select name="filter_bulan" id="filter_bulan" class="form-control"
                                    onchange="this.form.submit()">
                                    <option value="" disabled selected>Pilih Bulan</option>
                                    @foreach (range(1, 12) as $month)
                                        <option value="{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}"
                                            {{ $filterbulan == str_pad($month, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create(null, $month, 1)->format('F') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                        {{-- Form Filter Tanggal Masuk dan Tanggal Selesai --}}
                        <form action="{{ route('wakil-direktur-ii.laporan.surat') }}" method="GET" class="mb-3">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="filter_tanggal_masuk">Filter Tanggal Masuk</label>
                                        <input type="date" name="filter_tanggal_masuk" id="filter_tanggal_masuk"
                                            class="form-control" value="{{ $filterTanggalMasuk }}">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="filter_tanggal_selesai">Filter Tanggal Selesai</label>
                                        <input type="date" name="filter_tanggal_selesai" id="filter_tanggal_selesai"
                                            class="form-control" value="{{ $filterTanggalSelesai }}">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-warning btn-sm">Filter</button>
                        </form>

                        {{-- Tabel Data --}}
                        <div class="table-responsive">
                            <table class="table table-hover dtTable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Perihal</th>
                                        <th>No Surat</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Tanggal Keluar</th>
                                        <th>Kebutuhan Anggaran</th>
                                        <th>Realisasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($spd as $item)
                                        <tr class="text-center">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $item->perihal }}
                                            </td>
                                            <td>
                                                {{ $item->nomor_surat }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('d F Y') }}</td>
                                            <td>
                                                @if ($item->uang_muka)
                                                    Rp. {{ number_format($item->uang_muka->nominal) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->uang_muka)
                                                    <span class="badge badge-success">Uang Muka Sudah Distribusikan</span>
                                                @else
                                                    <span class="badge badge-danger">Uang Muka Belum Distribusikan</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('wakil-direktur-ii.laporan.surat-show', $item->id) }}"
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
    </div>
@endsection

<x-Admin.Sweetalert />

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.dtTable').DataTable({
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                pageLength: 10,
                dom: 'Blfrtip',
                buttons: [{
                    extend: 'excel',
                    text: 'Export Excel',
                    exportOptions: {
                        columns: ':visible'
                    }
                }]
            });
        });
    </script>
@endpush
