@extends('ppk.layouts.app')
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
                                    <th>Perihal</th>
                                    <th>Tanggal Surat</th>
                                    <th>Pengusul</th>
                                    <th>Status Surat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->pengajuan_barang_jasa->nomor_surat }}</td>
                                        <td>{{ $item->pengajuan_barang_jasa->nomor_agenda }}</td>
                                        <td>{{ $item->pengajuan_barang_jasa->perihal }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->pengajuan_barang_jasa->created_at)->format('d F Y') }}
                                        </td>
                                        <td>
                                            <ul>
                                                @foreach ($item->pengajuan_barang_jasa->pengusul as $pengusul)
                                                    <li>{{ $pengusul->karyawan->nama ?? '-' }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>{{ $item->pengajuan_barang_jasa->status_surat }}</td>
                                        <td>
                                            @if ($item->pengajuan_barang_jasa->verifikasi_ppk == 0)
                                                <form action="{{ route('ppk.pengajuan-pbj.verifikasi', $item->id) }}"
                                                    method="post" class="d-inline">
                                                    @csrf
                                                    <button class="btn py-2  btn-sm btn-success">Verifikasi</button>
                                                </form>
                                            @else
                                                <a href="{{ route('ppk.pengajuan-pbj.print', $item->id) }}" target="_blank"
                                                    class="btn btn-sm py-2 btn-primary">Print</a>
                                            @endif
                                            <a href="{{ route('ppk.pengajuan-pbj.show', $item->id) }}"
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
    <script>
        $(function() {
            $('body').on('click', '.btnTolak', function() {
                let url = $(this).data('url');

                $('body').on('click', '.btnSubmit', function() {
                    let keterangan = $('#modalKeterangan textarea').val();
                    $('#keterangan_ppk').val(keterangan);
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'status',
                        value: 2
                    }).appendTo('#formAcc');
                    $('#formAcc').attr('action', url);
                    $('#formAcc').submit();
                })
                $('#modalKeterangan').modal('show');
            })
        })
    </script>
@endpush
