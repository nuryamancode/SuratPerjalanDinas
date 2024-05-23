@extends('bendahara-keuangan.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Permohonan Belanja Disposisi Form Non PBJ</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>No Surat</th>
                                    <th>No Agenda</th>
                                    <th>Asal Surat</th>
                                    <th>Tipe Disposisi</th>
                                    <th>Tanggal Surat</th>
                                    <th>Perihal</th>
                                    <th>Catatan Disposiisi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->no_surat }}</td>
                                        <td>{{ $item->no_agenda }}</td>
                                        <td>{{ $item->form_non_pbj->karyawan->nama }}</td>
                                        <td>{{ $item->tipe_disposisi }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->perihal }}</td>
                                        <td>{{ $item->catatan_disposisi }}</td>
                                        <td>
                                            @if ($item->form_non_pbj->uang_muka1 == null)
                                                <a href="#" data-toggle="modal"
                                                    data-target="#modalTanggapi{{ $item->id }}"
                                                    class="btn btn-sm py-2 btn-primary">Tanggapi Disposisi</a>
                                            @endif
                                            <a href="{{ route('bendahara-keuangan.permohonan-belanja-disposisi.show', $item->id) }}"
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
    <div class="modal fade" id="modalTanggapi{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tanggapi Disposisi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('bendahara-keuangan.permohonan-belanja-disposisi.tanggapi', $item->form_non_pbj->id) }}"
                    method="post">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <div class='form-group mb-3'>
                            <div class='form-group mb-3'>
                                <label for='nominal' class='mb-2'>Uang Muka</label>
                                <input type='number' name='nominal' id='nominal'
                                    class='form-control @error('nominal') is-invalid @enderror'
                                    value='{{ old('nominal') }}'>
                                @error('nominal')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class='form-group'>
                            <label for='karyawan_id'>Diteruskan</label>
                            <select name='karyawan_id' id='karyawan_id'
                                class='form-control @error('karyawan_id') is-invalid @enderror'>
                                <option value='' selected disabled>Pilih Diteruskan</option>
                                @foreach ($data_karyawans as $karyawan)
                                    <option @selected($karyawan->id == old('karyawan_id')) value='{{ $karyawan->id }}'>
                                        {{ $karyawan->nama . ' - ' . $karyawan->jabatan->nama ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('karyawan_id')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btnSubmit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
<x-Admin.Datatable />
