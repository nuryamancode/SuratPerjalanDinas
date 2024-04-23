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
        if (auth()->user()->getRoleNames()->first() === 'Pengadministrasi Umum') {
            return redirect()->route('pengadministrasi-umum.dashboard');
        } else if (auth()->user()->getRoleNames()->first() === 'Wakil Direktur II') {
            return redirect()->route('wakil-direktur-ii.dashboard');
        } elseif (auth()->user()->getRoleNames()->first() === 'Pejabat Pembuat Komitmen') {
            return redirect()->route('ppk.dashboard');
        } elseif (auth()->user()->getRoleNames()->first() === 'Bendahara Keuangan') {
            return redirect()->route('bendahara-keuangan.dashboard');
        } elseif (auth()->user()->getRoleNames()->first() === 'Pelaksana Perjalanan Dinas') {
            return redirect()->route('pelaksana-spd.dashboard');
        } elseif (auth()->user()->getRoleNames()->first() === 'Pengusul') {
            return redirect()->route('pengusul.dashboard');
        } elseif (auth()->user()->getRoleNames()->first() === 'Pelaksana Belanja') {
            return redirect()->route('pelaksana-belanja.dashboard');
        } elseif (auth()->user()->getRoleNames()->first() === 'Wakil Direktur I') {
            return redirect()->route('wakil-direktur-i.dashboard');
        } elseif (auth()->user()->getRoleNames()->first() === 'Karyawan') {
            return redirect()->route('karyawan.dashboard');
        } elseif (auth()->user()->getRoleNames()->first() === 'Kabag') {
            return redirect()->route('kabag.dashboard');
        } elseif (auth()->user()->getRoleNames()->first() === 'Tim PPK') {
            return redirect()->route('timppk.dashboard');
        } elseif (auth()->user()->getRoleNames()->first() === 'superadmin ') {
            return redirect()->route('dashboard');
        }
    }
}
