@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Tambah Karyawan</h4>
                    <form action="{{ route('karyawan.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class='form-group mb-3'>
                            <label for='nama' class='mb-2'>Nama</label>
                            <input type='text' name='nama' class='form-control @error('nama') is-invalid @enderror'
                                value='{{ old('nama') }}'>
                            @error('nama')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='nip' class='mb-2'>NIP</label>
                            <input type='text' name='nip' id='nip'
                                class='form-control @error('nip') is-invalid @enderror' value='{{ old('nip') }}'>
                            @error('nip')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group'>
                            <label for='jenis_kelamin'>Jenis Kelamin</label>
                            <select name='jenis_kelamin' id='jenis_kelamin'
                                class='form-control @error('jenis_kelamin') is-invalid @enderror'>
                                <option value='' selected disabled>Pilih Jenis Kelamin</option>
                                <option @selected(old('jenis_kelamin') === 'Laki-laki') value="Laki-laki">Laki-laki</option>
                                <option @selected(old('jenis_kelamin') === 'Perempuan') value="Perempuan">Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='nomor_hp' class='mb-2'>Nomor HP</label>
                            <input type='text' name='nomor_hp' id='nomor_hp'
                                class='form-control @error('nomor_hp') is-invalid @enderror' value='{{ old('nomor_hp') }}'>
                            @error('nomor_hp')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group'>
                            <label for='jabatan_id'>Jabatan</label>
                            <select name='jabatan_id' id='jabatan_id'
                                class='form-control @error('jabatan_id') is-invalid @enderror'>
                                <option value='' selected disabled>Pilih Jabatan</option>
                                @foreach ($data_jabatan as $jabatan)
                                    <option @selected($jabatan->id == old('jabatan_id')) value='{{ $jabatan->id }}'>{{ $jabatan->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jabatan_id')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group'>
                            <label for='golongan_id'>Golongan</label>
                            <select name='golongan_id' id='golongan_id'
                                class='form-control @error('golongan_id') is-invalid @enderror'>
                                <option value='' selected disabled>Pilih Golongan</option>
                                @foreach ($data_golongan as $golongan)
                                    <option @selected($golongan->id == old('golongan_id')) value='{{ $golongan->id }}'>{{ $golongan->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('golongan_id')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group'>
                            <label for='status_akun'>Status Akun</label>
                            <select name='status_akun' id='status_akun'
                                class='form-control @error('status_akun') is-invalid @enderror'>
                                <option value='0'>Tanpa Akun</option>
                                <option value='1'>Dengan Akun</option>
                            </select>
                            @error('status_akun')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="akun_user d-none">
                            <div class='form-group mb-3'>
                                <label for='email' class='mb-2'>Email</label>
                                <input type='text' name='email' id='email'
                                    class='form-control @error('email') is-invalid @enderror' value='{{ old('email') }}'>
                                @error('email')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label for='password' class='mb-2'>Password</label>
                                <input type='password' name='password' id='password'
                                    class='form-control @error('password') is-invalid @enderror'
                                    value='{{ old('password') }}'>
                                @error('password')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label for='password_confirmation' class='mb-2'>Konfirmasi Password</label>
                                <input type='password' name='password_confirmation' id='password_confirmation'
                                    class='form-control @error('password_confirmation') is-invalid @enderror'
                                    value='{{ old('password_confirmation') }}'>
                                @error('password_confirmation')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group'>
                                <label for='role'>Role</label>
                                <select name='role' id='role'
                                    class='form-control @error('role') is-invalid @enderror'>
                                    <option value='' selected disabled>Pilih Role</option>
                                    @foreach ($data_role as $role)
                                        <option @selected($role->id == old('role')) value='{{ $role->name }}'>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('karyawan.index') }}" class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Tambah Karyawan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
@push('scripts')
    <script>
        $(function() {
            $('#status_akun').on('change', function() {
                let status_akun = $(this).val();
                if (status_akun == 1) {
                    $('.akun_user').removeClass('d-none');
                } else {
                    $('.akun_user').addClass('d-none');
                }
            })
        })
    </script>
@endpush
