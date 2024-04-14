@extends('ppk.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-3 justify-content-between">
                        <h4 class="card-title mb-3">Surat Pertanggung Jawaban SPD </h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tingkat Biaya</th>
                                    <th>Maksud Perjalanan Dinas</th>
                                    <th>Tempat Berangkat</th>
                                    <th>Tempat Tujuan</th>
                                    <th>Pelaksana</th>
                                    <th>Draf SPJ</th>
                                    <th>Total Biaya</th>
                                    <th>Keterangan PPK</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->spd_detail->tingkat_biaya }}</td>
                                        <td>{{ $item->spd_detail->maksud_perjalanan_dinas }}</td>
                                        <td>{{ $item->spd_detail->tempat_berangkat }}</td>
                                        <td>{{ $item->spd_detail->tempat_tujuan }}</td>
                                        <td>{{ $item->spd_detail->karyawan->nama }}</td>
                                        <td>
                                            <a href="{{ $item->downloadFile() }}" class="btn btn-sm btn-success"
                                                target="_blank">Lihat</a>
                                        </td>
                                        <td>Rp. {{ number_format($item->details()->sum('nominal')) ?? '-' }}</td>
                                        <td>{{ $item->keterangan_ppk }}</td>
                                        <td>{!! $item->status() !!}</td>
                                        <td>
                                            <form action="{{ route('ppk.spd-spj.verifikasi', $item->uuid) }}" method="post"
                                                class="d-inline" id="formVerifikasi">
                                                @csrf
                                                <textarea name="keterangan_ppk" id="keterangan_ppk" hidden cols="30" rows="10"></textarea>
                                                @if ($item->status == 0)
                                                    <button class="btn py-2  btn-sm btn-success" name="status"
                                                        value="1">Terima</button>
                                                    <button data-url="{{ route('ppk.spd-spj.verifikasi', $item->uuid) }}"
                                                        type="button" class="btn btnTolak py-2  btn-sm btn-danger"
                                                        name="status" value="2">Tolak</button>
                                                @elseif($item->status == 1)
                                                    <button data-url="{{ route('ppk.spd-spj.verifikasi', $item->uuid) }}"
                                                        type="button" class="btn btnTolak py-2  btn-sm btn-danger"
                                                        name="status" value="2">Tolak</button>
                                                @else
                                                    <button class="btn py-2  btn-sm btn-success" name="status"
                                                        value="1">Terima</button>
                                                @endif
                                            </form>
                                            <a href="{{ route('ppk.spd-spj.show', $item->uuid) }}"
                                                class="btn btn-warning  py-2">Detail</a>
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
<x-Admin.Datatable />
<x-Admin.Sweetalert />
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
                    }).appendTo('#formVerifikasi');
                    $('#formVerifikasi').attr('action', url);
                    $('#formVerifikasi').submit();
                })
                $('#modalKeterangan').modal('show');
            })


        })
    </script>
@endpush
