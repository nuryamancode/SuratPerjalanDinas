@extends('timppk.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Permohonan Belanja Form Non PBJ</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>No Surat</th>
                                    <th>Perihal</th>
                                    <th>Status SPJ</th>
                                    <th>Uang Muka</th>
                                    <th>Tanggal Distribusi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->form_non_pbj->disposisi_form->no_surat }}</td>
                                        <td>{{ $item->form_non_pbj->disposisi_form->perihal }}</td>
                                        <td>
                                            @if ($item->form_non_pbj->spj == null || $item->form_non_pbj->spj->status_spj == null)
                                                <span class="btn-primary btn btn-sm disabled">Belum dibuat</span>
                                            @else
                                                @if ($item->form_non_pbj->spj->acc_ppk == 2)
                                                    <span class="btn-danger btn btn-sm disabled">SPJ ditolak</span>
                                                @else
                                                    <span class="btn-success btn btn-sm disabled">Sudah dibuat</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>{{ $item->nominal ? 'Rp. ' . number_format($item->nominal, 0, ',', '.') : '-' }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}</td>
                                        <td>
                                            @if (!$item->form_non_pbj->spj)
                                                {{ null }}
                                            @else
                                                @if ($item->form_non_pbj->spj->acc_ppk == 1)
                                                    <a target="_blank"
                                                        href="{{ route('timppk.pembelanjaan-form-non-pbj.print', $item->form_non_pbj->spj->id) }}"
                                                        class="btn btn-primary py-2">Print</a>
                                                @endif
                                            @endif
                                            <a href="{{ route('timppk.pembelanjaan-form-non-pbj.show', $item->form_non_pbj->id) }}"
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
@endsection
<x-Admin.Sweetalert />
<x-Admin.Datatable />
@push('scripts')
@endpush
