@extends('ppk.layouts.app')
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
                                    <th>Tanggal</th>
                                    <th>File</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->created_at->translatedFormat('d F Y') }}</td>
                                        <td>
                                            <a href="{{ $item->getFile() }}" target="_blank"
                                                class="btn btn-secondary py-2">Lihat</a>
                                        </td>
                                        <td>{{ $item->status }}</td>
                                        <td>
                                            @if ($item->acc_ppk == 1)
                                                <a href="{{ route('ppk.pengajuan-form-non-pbj-disposisi.index', $item->uuid) }}"
                                                    class="btn btn-sm py-2 btn-info">Disposisi</a>
                                            @endif
                                            <form action="{{ route('ppk.pengajuan-form-non-pbj.acc', $item->uuid) }}"
                                                method="post" class="d-inline" id="formAcc">
                                                @csrf
                                                <textarea name="keterangan_ppk" id="keterangan_ppk" hidden cols="30" rows="10"></textarea>
                                                @if ($item->acc_ppk == 0)
                                                    <button class="btn py-2  btn-sm btn-success" name="status"
                                                        value="1">Terima</button>
                                                    <button
                                                        data-url="{{ route('ppk.pengajuan-form-non-pbj.acc', $item->uuid) }}"
                                                        type="button" class="btn btnTolak py-2  btn-sm btn-danger"
                                                        name="status" value="2">Tolak</button>
                                                @elseif($item->acc_ppk == 1)
                                                    <button
                                                        data-url="{{ route('ppk.pengajuan-form-non-pbj.acc', $item->uuid) }}"
                                                        type="button" class="btn btnTolak py-2  btn-sm btn-danger"
                                                        name="status" value="2">Tolak</button>
                                                @else
                                                    <button class="btn py-2  btn-sm btn-success" name="status"
                                                        value="1">Terima</button>
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
