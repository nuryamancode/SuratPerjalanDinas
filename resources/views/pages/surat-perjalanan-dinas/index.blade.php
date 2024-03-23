@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Surat Perjalanan Dinas</h4>
                        @if (is_pengadministrasiumum())
                            <a href="{{ route('surat-perjalanan-dinas.create') }}"
                                class="btn my-2 mb-3 btn-sm py-2 btn-primary">Tambah
                                Surat Perjalanan Dinas</a>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nomor Surat</th>
                                    <th>Perihal</th>
                                    <th>Tipe</th>
                                    <th>Tujuan Disposisi</th>
                                    <th>Status</th>
                                    <th>Persetujuan TIM PPK</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->surat->nomor_surat }}</td>
                                        <td>{{ $item->surat->perihal }}</td>
                                        <td>{{ $item->tipe }}</td>
                                        <td>{{ $item->tujuan_disposisi->nama ?? '-' }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>{{ $item->acc_tim_ppk() }}</td>
                                        <td>
                                            @if (is_wakildirekturii())
                                                <a href="{{ route('surat-perjalanan-dinas.disposisi-single', $item->id) }}"
                                                    class="btn btn-sm py-2 btn-warning">Disposisi</a>
                                            @endif
                                            @if (is_pejabatpembuatkomitmen())
                                                <a href="{{ route('disposisi.index', $item->id) }}"
                                                    class="btn btn-sm py-2 btn-warning">Disposisi</a>
                                                @if ($item->acc_tim_ppk == 0)
                                                    <a href="{{ route('surat-perjalanan-dinas.acc-tim-ppk', [
                                                        'id' => $item->id,
                                                        'status' => 1,
                                                    ]) }}"
                                                        class="btn btn-sm py-2 btn-success">Setujui</a>
                                                    <a href="{{ route('surat-perjalanan-dinas.acc-tim-ppk', [
                                                        'id' => $item->id,
                                                        'status' => 2,
                                                    ]) }}"
                                                        class="btn btn-sm py-2 btn-danger">Tolak</a>
                                                @endif
                                            @endif
                                            <a href="{{ route('surat-perjalanan-dinas.show', $item->id) }}"
                                                class="btn btn-sm py-2 btn-warning">Detail</a>
                                            @if (is_pengadministrasiumum())
                                                <form action="javascript:void(0)" method="post" class="d-inline"
                                                    id="formDelete">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                        data-action="{{ route('surat-perjalanan-dinas.destroy', $item->id) }}">Hapus</button>
                                                </form>
                                            @endif
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
