@extends('bendahara-keuangan.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Pengajuan Form Non PBJ</h4>
                    </div>
                    <div class="table-responsive">
                        <div class="text-right mb-3">
                            <a href="{{ route('bendahara-keuangan.pengajuan-form-non-pbj.create') }}"
                                class="btn btn-sm btn-primary">Buat Pengajuan</a>
                        </div>
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Pembuat</th>
                                    <th>Tanggal Pembuatan</th>
                                    <th>Status Pengajuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->karyawan->nama }} - {{ $item->karyawan->jabatan->nama }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}</td>
                                        <td>
                                            {{ $item->status }}
                                        </td>
                                        <td>
                                            <a href="{{ route('bendahara-keuangan.pengajuan-form-non-pbj.show', $item->id) }}"
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
