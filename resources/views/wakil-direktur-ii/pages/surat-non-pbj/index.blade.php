@extends('wakil-direktur-ii.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Pengajuan Surat Non PBJ</h4>
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
                                    <th>Pengusul</th>
                                    <td>Taksiran</td>
                                    <th>Acc Wakdir 2</th>
                                    <th>Status Surat</th>
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
                                                @foreach ($item->pengusul as $pengusul)
                                                    <li>{{ $pengusul->karyawan->nama ?? '-' }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            {{ $item->details ? number_format($item->details()->sum('harga_satuan')) : '0' }}
                                        </td>
                                        <td>{!! $item->statusAccWadir2() !!}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>
                                            @if ($item->acc_wadir2 == 1)
                                                @if ($item->acc_wadir2 == 1)
                                                    <a href="{{ route('wakil-direktur-ii.surat-non-pbj-disposisi.index', $item->uuid) }}"
                                                        class="btn btn-sm py-2 btn-info">Disposisi</a>
                                                @endif
                                            @endif
                                            <a href="{{ route('wakil-direktur-ii.surat-non-pbj.show', $item->uuid) }}"
                                                class="btn btn-sm py-2 btn-warning">Detail</a>
                                            <form action="{{ route('wakil-direktur-ii.surat-non-pbj.acc', $item->uuid) }}"
                                                method="post" class="d-inline" id="formAcc">
                                                @csrf
                                                <textarea name="keterangan_wadir2" id="keterangan_wadir2" hidden cols="30" rows="10"></textarea>
                                                @if ($item->acc_wadir2 == 0)
                                                    <button class="btn py-2  btn-sm btn-success" name="status"
                                                        value="1">Terima</button>
                                                    <button
                                                        data-url="{{ route('wakil-direktur-ii.surat-non-pbj.acc', $item->uuid) }}"
                                                        type="button" class="btn btnTolak py-2  btn-sm btn-danger"
                                                        name="status" value="2">Tolak</button>
                                                @elseif($item->acc_wadir2 == 2)
                                                    <button class="btn py-2  btn-sm btn-success" name="status"
                                                        value="1">Terima</button>
                                                @endif
                                            </form>
                                            {{-- <a href="{{ route('wakil-direktur-ii.surat-non-pbj.edit', $item->uuid) }}"
                                                class="btn btn-sm py-2 btn-info">Edit</a> --}}
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
                    $('#keterangan_wadir2').val(keterangan);
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