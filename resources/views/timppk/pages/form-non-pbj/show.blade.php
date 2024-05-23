@extends('timppk.layouts.app')
@section('content')
    <style>
        .back:hover {
            text-decoration: none;
        }
    </style>
    <a href="{{ route('timppk.form-non-pbj.index') }}" class="back">
        <div class="d-flex align-items-center">
            <i class="mdi mdi-arrow-left-bold-circle  pr-2 pt-1 icon-large"></i>
            <span>Kembali</span>
        </div>
    </a>
    <div class="row">
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Detail Pengajuan Form Non PBJ</h4>
                    <ul class="list-inline">
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Formulir</span>
                            <span>
                                <a href="{{ $item->getFile() }}" target="_blank" class="btn btn-success btn-sm">Lihat
                                    Formulir</a>
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Tanggal Pembuatan</span>
                            <span>
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Status Pengajuan</span>
                            <span>
                                {{ $item->status }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
<x-Admin.Datatable />
