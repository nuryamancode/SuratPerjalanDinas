@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-3 justify-content-between">
                        <h4 class="card-title mb-3">SPJ Form Non PBJ
                        </h4>
                        {{-- @can('SPJ Form Non PBJ Create')
                            <a href="{{ route('spj-form-non-pbj.create') }}" class="btn btn-primary">Tambah SPJ</a>
                        @endcan --}}
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nomor Surat</th>
                                    <th>Perihal</th>
                                    <th>Nomor Agenda</th>
                                    <th>Nominal Uang Muka</th>
                                    {{-- @canany([
    'SPJ Form Non PBJ Verifikasi',
    'SPJ Form Non PBJ Show',
    'SPJ Form Non PBJ
                                        Edit',
    'SPJ Form Non PBJ Delete',
])
                                    @endcanany --}}
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nomor_surat }}</td>
                                        <td>{{ $item->perihal }}</td>
                                        <td>{{ $item->nomor_agenda }}</td>
                                        <td>{{ $item->uang_muka->nominal ?? '-' }}</td>
                                        {{-- @canany([
    'SPJ Form Non PBJ Verifikasi',
    'SPJ Form Non PBJ Show',
    'SPJ Form Non PBJ
                                            Edit',
    'SPJ Form Non PBJ Delete',
]) --}}
                                        <td>
                                            <a @if ($item->uang_muka) href="{{ route('spj-form-non-pbj.show', $item->uuid) }}" @else disabled @endif
                                                class="btn btn-primary  py-2">Detail SPJ</a>


                                            {{-- @can('SPJ Form Non PBJ Verifikasi')
                                                    @if ($item->status != 1)
                                                        <a href="{{ route('sjp-barang-jasa.verifikasi', [
                                                            'uuid' => $item->uuid,
                                                            'status' => 1,
                                                        ]) }}"
                                                            class="btn btn-success  py-2">Setujui</a>
                                                    @else
                                                        <a href="{{ route('sjp-barang-jasa.verifikasi', [
                                                            'uuid' => $item->uuid,
                                                            'status' => 2,
                                                        ]) }}"
                                                            class="btn btn-danger  py-2">Tolak</a>
                                                    @endif
                                                @endcan
                                                @can('SPJ Form Non PBJ Show')
                                                    <a href="{{ route('sjp-barang-jasa.show', $item->uuid) }}"
                                                        class="btn btn-warning  py-2">Detail</a>
                                                @endcan
                                                @can('SPJ Form Non PBJ Edit')
                                                    <a href="{{ route('sjp-barang-jasa.edit', $item->uuid) }}"
                                                        class="btn btn-sm py-2 btn-info">Edit</a>
                                                @endcan
                                                @can('SPJ Form Non PBJ Delete')
                                                    <form action="javascript:void(0)" method="post" class="d-inline"
                                                        id="formDelete">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                            data-action="{{ route('sjp-barang-jasa.destroy', $item->uuid) }}">Hapus</button>
                                                    </form>
                                                @endcan --}}
                                        </td>
                                        {{-- @endcanany --}}
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
