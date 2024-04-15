@extends('pelaksana-belanja.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Pengajuan Form Non PBJ</h4>
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
                                    <th>Pelaksana</th>
                                    <th>Status Surat</th>
                                    <th>Status Uang Muka</th>
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
                                                @foreach ($item->pelaksana as $pelaksana)
                                                    <li>{{ $pelaksana->karyawan->nama ?? '-' }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>{{ $item->status() }}</td>
                                        <td>{{ $item->statusUangMuka() }}</td>
                                        <td>
                                            <a href="{{ route('pelaksana-belanja.pengajuan-form-non-pbj-spj.index', [
                                                'pengajuan_uuid' => $item->uuid,
                                            ]) }}"
                                                class="btn btn-sm py-2 btn-info">SPJ</a>
                                            <a href="{{ route('pelaksana-belanja.pengajuan-form-non-pbj.show', $item->uuid) }}"
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
