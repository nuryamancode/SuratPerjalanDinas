<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticated()
    {
        if (auth()->user()->roles->pluck('name')->first() === 'Pengadministrasi Umum') {
            return redirect()->route('pengadministrasi-umum.dashboard');
        } else if (auth()->user()->roles->pluck('name')->first() === 'Wakil Direktur II') {
            return redirect()->route('wakil-direktur-ii.dashboard');
        } elseif (auth()->user()->roles->pluck('name')->first() === 'Wakil Direktur I') {
            return redirect()->route('wakil-direktur-i.dashboard');
        } elseif (auth()->user()->roles->pluck('name')->first() === 'Bendahara Keuangan') {
            return redirect()->route('bendahara-keuangan.dashboard');
        } elseif (auth()->user()->roles->pluck('name')->first() === 'Pengelola Keuangan') {
            return redirect()->route('pengelola-keuangan.dashboard');
        } elseif (auth()->user()->roles->pluck('name')->first() === 'Supir') {
            return redirect()->route('supir.dashboard');
        } elseif (auth()->user()->roles->pluck('name')->first() === 'Karyawan') {
            return redirect()->route('karyawan.dashboard');
        } elseif (auth()->user()->roles->pluck('name')->first() === 'Kepala Bagian') {
            return redirect()->route('kabag.dashboard');
        } elseif (auth()->user()->roles->pluck('name')->first() === 'Pejabat Pembuat Komitmen') {
            return redirect()->route('ppk.dashboard');
        } elseif (auth()->user()->roles->pluck('name')->first() === 'Tim PPK') {
            return redirect()->route('timppk.dashboard');
        } elseif (auth()->user()->roles->pluck('name')->first() === 'Admin') {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('login');
        }
    }
}
