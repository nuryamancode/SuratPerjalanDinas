@extends('karyawan.layouts.app')
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
                                            {{--  @if ($item->spj && $item->spj->status)
                                                <a href="{{ route('karyawan.spd-spj.print', $item->spj->uuid) }}"
                                                    class="btn btn-secondary py-2">Print Kwitansi</a>
                                            @endif  --}}
                                            {{-- <a href="{{ route('karyawan.spd-detail-supir.index', [
                                                'spd_detail_uuid' => $item->uuid,
                                            ]) }}"
                                                class="btn btn-primary  py-2">Supir</a> --}}
                                            {{-- <a href="{{ route('karyawan.spd-detail.edit', $item->uuid) }}"
                                                class="btn btn-sm py-2 btn-info">Isi SPD</a> --}}
                                            {{--  @if ($item->uang_muka)
                                                @if ($item->spj)
                                                    <a href="{{ route('karyawan.spd-spj.show', $item->spj->uuid) }}"
                                                        class="btn btn-info  py-2">Lihat SPJ</a>
                                                @else
                                                    <a href="{{ route('karyawan.spd-spj.create', [
                                                        'spd_detail_uuid' => $item->uuid,
                                                    ]) }}"
                                                        class="btn btn-primary  py-2">Buat SPJ</a>
                                                @endif
                                            @else
                                                <a href="javascript:void()" class="btn btn-primary disabled py-2"
                                                    disabled>Buat
                                                    SPJ</a>
                                            @endif  --}}
                                            <a href="{{ route('supir.spd.show', $item->id) }}"
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
