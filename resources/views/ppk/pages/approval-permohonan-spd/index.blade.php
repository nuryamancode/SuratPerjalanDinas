@extends('ppk.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Approval Permohonan Surat Perjalanan Dinas</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nomor Surat</th>
                                    <th>Maksud Perjalanan Dinas</th>
                                    <th>Tanggal Surat</th>
                                    <th>Status Verifikasi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->surat->nomor_surat }}</td>
                                        <td>{{ $item->surat->maksud_perjalanan_dinas }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->surat->created_at)->format('d F Y') }}</td>
                                        <td>{{ $item->statusSpd() }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>
                                            {{--  @if ($item->disposisi)
                                                @if ($item->disposisi->pembuat_karyawan_id_2 != null)
                                                    @if ($item->verifikasi_ppk != 1)
                                                        <form
                                                            action="{{ route('ppk.permohonan-spd.verifikasi-ppk', $item->id) }}"
                                                            method="post" class="d-inline">
                                                            @csrf
                                                            <button class="btn py-2  btn-sm btn-success">Set
                                                                Verifikasi</button>
                                                        </form>
                                                    @else
                                                        <a href="{{ route('ppk.permohonan-spd-disposisi.print', $item->id) }}"
                                                            target="_blank" class="btn btn-sm py-2 btn-secondary">Print</a>
                                                    @endif
                                                @endif
                                            @endif  --}}
                                            @if ($item->spd_pelaksana_dinas->verifikasi_ppk == 0 || $item->spd_supir->verifikasi_ppk == 0)
                                                <form
                                                    action="{{ route('ppk.approval-permohonan-spd.verifikasi', $item->id) }}"
                                                    method="post" class="d-inline">
                                                    @csrf
                                                    <button class="btn py-2  btn-sm btn-success">
                                                        Verifikasi SPD</button>
                                                </form>
                                            @endif
                                            @if ($item->spd_pelaksana_dinas)
                                                <a href="{{ route('ppk.approval-permohonan-spd.lihat-spd-pelaksana', $item->spd_pelaksana_dinas->id) }}"
                                                    target="_blank" class="btn btn-sm py-2 btn-info">Lihat SPD</a>
                                            @endif
                                            <a href="{{ route('ppk.approval-permohonan-spd.show', $item->id) }}"
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

    <div class="modal fade" id="modalKeterangan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Keterangan Penolakan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class='form-group mb-3'>
                        <label for='keterangan' class='mb-2'>Keterangan</label>
                        <textarea name='keterangan' id='keterangan' cols='30' rows='3'
                            class='form-control @error('keterangan') is-invalid @enderror'>{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class='invalid-feedback'>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btnSubmit">Submit</button>
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
