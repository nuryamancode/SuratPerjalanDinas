@extends('timppk.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md">
            <style>
                .back:hover {
                    text-decoration: none;
                }
            </style>
            <a href="{{ route('timppk.pengajuan-pbj.index') }}" class="back">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-arrow-left-bold-circle  pr-2 pt-1 icon-large"></i>
                    <span>Kembali</span>
                </div>
            </a>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Detail Pengajuan Form Non PBJ</h4>
                    <ul class="list-inline">
                        <li class="list-item mb-4 d-flex justify-content-between p-1" style="border: 1px solid black">
                            <span>Nomor Surat</span>
                            <span>{{ $item->pengajuan_barang_jasa->nomor_surat }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between p-1" style="border: 1px solid black">
                            <span>Nomor Agenda</span>
                            <span>{{ $item->pengajuan_barang_jasa->nomor_agenda }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between p-1" style="border: 1px solid black">
                            <span>Tanggal</span>
                            <span>{{ \Carbon\Carbon::parse($item->pengajuan_barang_jasa->created_at)->format('d F Y') }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between p-1" style="border: 1px solid black">
                            <span>Perihal</span>
                            <span>{{ $item->pengajuan_barang_jasa->perihal }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between p-1" style="border: 1px solid black">
                            <span>Dokumen surat</span>
                            <span>
                                <a href="{{ $item->pengajuan_barang_jasa->getFileDokumen() }}" target="_blank"
                                    class="btn btn-success btn-sm">Lihat
                                    Dokumen</a>
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between p-1" style="border: 1px solid black">
                            <span>Lampiran</span>
                            <span>
                                <ol class="list-group">
                                    @foreach ($item->pengajuan_barang_jasa->lampiranpbj as $lampiranpbj)
                                        <li>
                                            <a href="{{ $lampiranpbj->getFile() }}" target="_blank"
                                                class="btn btn-success btn-sm mt-2">Lihat Lampiran</a>
                                        </li>
                                    @endforeach
                                </ol>
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between p-1" style="border: 1px solid black">
                            <span>Pengusul</span>
                            <div>
                                <ol class="list-group">
                                    @foreach ($item->pengajuan_barang_jasa->pengusul as $pengusul)
                                        <li>
                                            {{ $pengusul->karyawan->nama }}
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        </li>
                        <li class="list-item">
                            <form action="{{ route('timppk.pengajuan-pbj.update-proses', $item->id) }}" method="post">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-8">
                                        <span>Status Surat</span>
                                    </div>
                                    <div class="col-6">
                                        <div class='form-group'>
                                            <select name='tahapan' id='tahapan' class='form-control'>
                                                @php
                                                    $selected = '';
                                                    if (
                                                        $item->id == old('tahapan') ||
                                                        $item->id == $item->pengajuan_barang_jasa->status_surat
                                                    ) {
                                                        $selected = 'selected';
                                                    }
                                                @endphp
                                                @if ($selected != '')
                                                    <option value='' selected disabled>Pilih Tahapan Proses</option>
                                                @endif
                                                @foreach ($data_tahapan as $items)
                                                    <ol>
                                                        <li>
                                                            <option {{ $selected }} value="{{ $items->nama }}">
                                                                {{ $items->nama }}
                                                            </option>
                                                        </li>
                                                    </ol>
                                                @endforeach
                                            </select>
                                            @error('tahapan')
                                                <div class='invalid-feedback'>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button class="btn btn-primary btn-sm" type="submit">Ubah Proses</button>
                                </div>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
<x-Admin.Datatable />
