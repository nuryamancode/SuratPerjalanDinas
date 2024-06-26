@extends('ppk.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Pelaksana PBJ</h4>
                        <a href="{{ route('ppk.pengajuan-pbj-pelaksana.create', [
                            'pengajuan_uuid' => $permohonan->uuid,
                        ]) }}"
                            class="btn my-2 mb-3 btn-sm py-2 btn-primary">Tambah Pelaksana</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Karyawan</th>
                                    <th>Penanggung Jawab</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->karyawan->nama }}</td>
                                        <td>{{ $item->isPenanggungJawab() }}</td>
                                        <td>
                                            @if ($item->is_penanggung_jawab == 0)
                                                <form
                                                    action="{{ route('ppk.pengajuan-pbj-pelaksana.set-penanggung-jawab', $item->pengajuan->uuid) }}"
                                                    method="post" class="d-inline" id="formDelete">
                                                    @csrf
                                                    <input type="number" name="karyawan_id"
                                                        value="{{ $item->karyawan->id }}" hidden>
                                                    <button class="btn btn-sm py-2 btn-info">Set Penanggung
                                                        Jawab</button>
                                                </form>
                                            @endif
                                            <form action="javascript:void(0)" method="post" class="d-inline"
                                                id="formDelete">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                    data-action="{{ route('ppk.pengajuan-pbj-pelaksana.destroy', $item->id) }}">Hapus</button>
                                            </form>
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
