@extends('ppk.layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mb-3">Permohonan SPJ Form Non PBJ</h4>
                </div>
                <div class="table-responsive">
                    <table class="table dtTable table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Pembuat</th>
                                <th>Tanggal Dibuat SPJ</th>
                                <th>Status SPJ</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->karyawan->nama }} - {{ $item->karyawan->jabatan->nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}
                                    <td>
                                        @if ($item->acc_ppk == 0)
                                        <span class="btn-primary btn btn-sm disabled">Belum diperiksa</span>
                                        @else
                                        <span class="btn-success btn btn-sm disabled">Sudah diperiksa</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{--  <form action="{{ route('ppk.form-non-pbj-spj.acc', $item->id) }}" method="post"
                                            class="d-inline" id="formAcc">
                                            @csrf
                                            <textarea name="keterangan_ppk" id="keterangan_ppk" hidden cols="30" rows="10"></textarea>
                                            @if ($item->acc_ppk == 0)
                                                <button class="btn py-2  btn-sm btn-success" name="status"
                                                    value="1">Terima</button>
                                                <button data-url="{{ route('ppk.form-non-pbj-spj.acc', $item->id) }}"
                                                    type="button" class="btn btnTolak py-2  btn-sm btn-danger"
                                                    name="status" value="2">Tolak</button>
                                            @elseif($item->acc_ppk == 2)
                                                <button class="btn py-2  btn-sm btn-success" name="status"
                                                    value="1">Terima</button>
                                            @endif
                                        </form>  --}}
                                        {{--  <a target="_blank" href="{{ route('ppk.form-non-pbj-spj.print', $item->id) }}"
                                            class="btn btn-primary  py-2">Print</a>  --}}
                                        <a href="{{ route('ppk.form-non-pbj-spj.show', $item->id) }}"
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
                    console.log(url);
                    $('#formAcc').attr('action', url);
                    $('#formAcc').submit();
                })
                $('#modalKeterangan').modal('show');
            })


        })
    </script>
@endpush
