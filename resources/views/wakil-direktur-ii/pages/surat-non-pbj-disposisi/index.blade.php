@extends('wakil-direktur-ii.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Disposisi Surat Non PBJ</h4>
                        <a href="{{ route('wakil-direktur-ii.surat-non-pbj-disposisi.create', $pengajuan->uuid) }}"
                            class="btn my-2 mb-3 btn-sm py-2 btn-primary">Buat Disposisi</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Pembuat</th>
                                    <th>Tujuan</th>
                                    <th>Tipe</th>
                                    <th>Catatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->pembuat->nama }}</td>
                                        <td>{{ $item->tujuan->nama }}</td>
                                        <td>{{ $item->tipe }}</td>
                                        <td>{{ $item->catatan }}</td>
                                        <td>
                                            @if ($item->pembuat_karyawan_id == auth()->user()->karyawan->id)
                                                <form action="javascript:void(0)" method="post" class="d-inline"
                                                    id="formDelete">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                        data-action="{{ route('wakil-direktur-ii.surat-non-pbj-disposisi.destroy', $item->id) }}">Hapus</button>
                                                </form>
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
@endsection
<x-Admin.Sweetalert />
<x-Admin.Datatable />
