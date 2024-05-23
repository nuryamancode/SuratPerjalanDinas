@extends('pengelola-keuangan.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Arsip</h4>
                    </div>
                    <form action="{{ route('pengelola-keuangan.surat-non-pbj.arsip.spj') }}" method="GET" class="mb-3">
                        <div class="filter">
                            <label for="pilih_pbj" class="form-label">Filter</label>
                            <select name="pilih_pbj" id="" class="form-control" onchange="this.form.submit()">
                                <option value="" selected disabled>Pilih Filter</option>
                                <option value="surat_non_pbj">SURAT NON PBJ</option>
                                <option value="form_non_pbj">FORMULIR NON PBJ</option>
                            </select>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                @if ($filter == 'surat_non_pbj')
                                    <tr>
                                        <th>No.</th>
                                        <th>Nomor Surat</th>
                                        <th>Nomor Agenda</th>
                                        <th>Tanggal Surat</th>
                                        <th>Perihal</th>
                                        <th>Taksiran</th>
                                        <th>Uang Muka</th>
                                        <th>Aksi</th>
                                    </tr>
                                @elseif($filter == 'form_non_pbj')
                                    <tr>
                                        <th>No.</th>
                                        <th>Pembuat</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Status SPJ</th>
                                        <th>Aksi</th>
                                    </tr>
                                @endif
                            </thead>
                            <tbody>
                                @if ($filter == 'surat_non_pbj')
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nomor_surat }}</td>
                                            <td>{{ $item->nomor_agenda }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}</td>
                                            <td>{{ $item->perihal }}</td>
                                            <td>
                                                {{ $item->nilai_taksiran ? 'Rp. ' . number_format($item->nilai_taksiran, 0, ',', '.') : '-' }}
                                            </td>
                                            <td>
                                                Rp. {{ $item->uang_muka ? number_format($item->uang_muka->nominal) : '-' }}
                                            </td>
                                            <td>
                                                <a href="{{ route('pengelola-keuangan.surat-non-pbj.lihat.spj', $item->spj->id) }}"
                                                    class="btn btn-sm py-2 btn-info">Lihat SPJ</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @elseif ($filter == 'form_non_pbj')
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->spj->karyawan->nama }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->spj->created_at)->format('d F Y') }}</td>
                                            <td>
                                                @if ($item->spj->acc_ppk == 0)
                                                    <span class="btn-primary btn btn-sm disabled">Belum diperiksa</span>
                                                @else
                                                    <span class="btn-success btn btn-sm disabled">Sudah diperiksa</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('pengelola-keuangan.form-non-pbj.arsip_spj_form-spj', $item->spj->id) }}"
                                                    class="btn btn-sm py-2 btn-info">Lihat SPJ</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
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
