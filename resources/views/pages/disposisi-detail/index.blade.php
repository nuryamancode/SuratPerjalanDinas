@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Disposisi</h4>
                        @if (is_pejabatpembuatkomitmen())
                            <a href="{{ route('disposisi-detail.create', [
                                'disposisi_id' => $disposisi->id,
                            ]) }}"
                                class="btn my-2 mb-3 btn-sm py-2 btn-primary">Tambah
                                Disposisi</a>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tujuan</th>
                                    <th>Catatan</th>
                                    <th>Pembuat</th>
                                    @if (is_pejabatpembuatkomitmen())
                                        <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->tujuan->nama }}</td>
                                        <td>{{ $item->catatan }}</td>
                                        <td>{{ $item->pembuat->nama }}</td>
                                        @if (is_pejabatpembuatkomitmen())
                                            <td>
                                                <a href="{{ route('disposisi-detail.edit', $item->id) }}"
                                                    class="btn btn-sm py-2 btn-info">Edit</a>
                                                <form action="javascript:void(0)" method="post" class="d-inline"
                                                    id="formDelete">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                        data-action="{{ route('disposisi-detail.destroy', $item->id) }}">Hapus</button>
                                                </form>
                                            </td>
                                        @endif
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
