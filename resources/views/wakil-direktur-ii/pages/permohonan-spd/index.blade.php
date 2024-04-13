@extends('wakil-direktur-ii.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Permohonan Surat Perjalanan Dinas</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nomor Surat</th>
                                    <th>Perihal</th>
                                    <th>Status Verifikasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->surat->nomor_surat }}</td>
                                        <td>{{ $item->surat->perihal }}</td>
                                        <td>{{ $item->verifikasi_wadir2() }}</td>
                                        <td>
                                            @if ($item->verifikasi_wadir2 != 1)
                                                <form
                                                    action="{{ route('wakil-direktur-ii.permohonan-spd.verifikasi', $item->id) }}"
                                                    method="post" class="d-inline">
                                                    @csrf
                                                    <button class="btn py-2  btn-sm btn-success">Set Verifikasi</button>
                                                </form>
                                            @elseif($item->verifikasi_wadir2 == 1)
                                                <a href="{{ route('wakil-direktur-ii.permohonan-spd-disposisi.index', [
                                                    'permohonan_spd_uuid' => $item->uuid,
                                                ]) }}"
                                                    class="btn btn-sm py-2 btn-info">Disposisi</a>
                                            @endif
                                            <a href="{{ route('wakil-direktur-ii.permohonan-spd.show', $item->id) }}"
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
