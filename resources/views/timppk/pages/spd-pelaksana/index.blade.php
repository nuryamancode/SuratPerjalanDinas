@extends('timppk.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-3 justify-content-between">
                        <h4 class="card-title mb-3">Surat Perjalanan Dinas</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nomor Surat</th>
                                    <th>Tanggal Surat</th>
                                    <th>Status Surat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->spd->surat->nomor_surat }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->spd->surat->created_at)->format('d M Y') }}</td>
                                        <td>{{ $item->spd->status }}</td>
                                        <td>
                                            @php
                                                $userId = auth()->user()->karyawan->id;
                                                $isPembuatSpj = false;
                                            @endphp
                                            @foreach ($item->spj_many as $spj)
                                                @if ($spj->pembuat_spj == $userId)
                                                    @php $isPembuatSpj = true; @endphp
                                                    <a href="{{ route('timppk.spd-spj.show', $spj->id) }}"
                                                        class="btn btn-info py-2">Lihat SPJ</a>
                                                @break
                                            @endif
                                        @endforeach
                                        @if (!$isPembuatSpj)
                                            <a href="{{ route('timppk.spd-spj.create', ['spd_id' => $item->id]) }}"
                                                class="btn btn-primary py-2">Buat SPJ</a>
                                        @endif
                                        <a href="{{ route('timppk.spd.show', $item->id) }}"
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
