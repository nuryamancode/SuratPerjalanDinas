@extends('bendahara-keuangan.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Submit Uang Muka</h4>
                    <form action="{{ route('bendahara-keuangan.spd-detail-uang-muka.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="spd_detail_uuid" value="{{ $spd_detail->uuid }}">
                        <div class='form-group mb-3'>
                            <label for='pelaksana' class='mb-2'>Pelaksana</label>
                            <input type='text' name='pelaksana' id='pelaksana'
                                class='form-control @error('pelaksana') is-invalid @enderror'
                                value='{{ $spd_detail->karyawan->nama ?? old('pelaksana') }}' readonly>
                            @error('pelaksana')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='nominal' class='mb-2'>Nominal</label>
                            <input type='number' name='nominal' id='nominal'
                                class='form-control @error('nominal') is-invalid @enderror'
                                value='{{ $spd_detail->uang_muka->nominal ?? old('nominal') }}'>
                            @error('nominal')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('bendahara-keuangan.spd.index', [
                                'spd_uuid' => $spd_detail->surat_perjalanan_dinas->uuid,
                            ]) }}"
                                class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
