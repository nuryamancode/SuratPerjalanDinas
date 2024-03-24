<?php

namespace App\Http\Controllers;

use App\Models\Golongan;
use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class KaryawanController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Karyawan Index')->only('index');
        $this->middleware('can:Karyawan Create')->only(['create', 'store']);
        $this->middleware('can:Karyawan Edit')->only(['edit', 'update']);
        $this->middleware('can:Karyawan Delete')->only('destroy');
    }

    public function index()
    {
        $items = Karyawan::orderBy('nama', 'ASC')->get();
        return view('pages.karyawan.index', [
            'title' => 'Karyawan',
            'items' => $items
        ]);
    }

    public function create()
    {
        return view('pages.karyawan.create', [
            'title' => 'Tambah Karyawan',
            'data_jabatan' => Jabatan::orderBy('nama', 'ASC')->get(),
            'data_golongan' => Golongan::orderBy('nama', 'ASC')->get(),
            'data_role' => Role::orderBy('name', 'ASC')->get()
        ]);
    }

    public function store()
    {
        request()->validate([
            'nama' => ['required'],
            'nip' => ['required', 'unique:karyawan,nip'],
            'jenis_kelamin' => ['required'],
            'jabatan_id' => ['required'],
            'golongan_id' => ['required'],
            'status_akun' => ['required'],
            'email' => [Rule::when(request('status_akun') == 1, ['required', 'unique:users,email'])],
            'password' => [Rule::when(request('status_akun') == 1, ['required', 'confirmed', 'min:6'])],
            'password_confirmation' => [Rule::when(request('status_akun') == 1, ['required'])],
            'role' => [Rule::when(request('status_akun') == 1, ['required'])],
        ]);

        DB::beginTransaction();
        try {
            $data_karyawan = request()->only(['nama', 'nip', 'jenis_kelamin', 'nomor_hp', 'jabatan_id', 'golongan_id']);
            if (request('status_akun') == 1) {
                // karyawan dengan user
                $user = User::create([
                    'name' => request('nama'),
                    'email' => request('email'),
                    'password' => bcrypt(request('password'))
                ]);
                $user->assignRole(request('role'));
                $data_karyawan['user_id'] = $user->id;
            } else {
                // tanpa user
                $data_karyawan['user_id'] = NULL;
            }

            Karyawan::create($data_karyawan);
            DB::commit();
            return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $item = Karyawan::findOrFail($id);
        return view('pages.karyawan.edit', [
            'title' => 'Edit Karyawan',
            'item' => $item,
            'data_jabatan' => Jabatan::orderBy('nama', 'ASC')->get(),
            'data_golongan' => Golongan::orderBy('nama', 'ASC')->get(),
            'data_role' => Role::orderBy('name', 'ASC')->get()
        ]);
    }

    public function update($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        request()->validate([
            'nama' => ['required'],
            'nip' => ['required', 'unique:karyawan,nip,' . $id],
            'jenis_kelamin' => ['required'],
            'jabatan_id' => ['required'],
            'golongan_id' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $data_karyawan = request()->only(['nama', 'nip', 'jenis_kelamin', 'nomor_hp', 'jabatan_id', 'golongan_id']);
            if ($karyawan->user && request('status_akun') == 0) {
                // kosongkan user_id di karyawan, dan hapus usernya
                $user = User::findOrFail($karyawan->user_id);
                $karyawan->update([
                    'user_id' => NULL
                ]);
                // hapus akun user
                $user->delete();
            } elseif (!$karyawan->user && request('status_akun') == 1) {
                // karaywan sebelumnya tidak mempunyai akun dan ingin dibuatkan akun baru
                request()->validate([
                    'email' => ['required', 'unique:users,email'],
                    'password' => ['required', 'confirmed', 'min:6'],
                    'password_confirmation' => ['required'],
                    'role' => ['required']
                ]);
                $data_user = [];
                $data_user['name'] = request('nama');
                $data_user['email'] = request('email');
                $data_user['password'] = bcrypt(request('password'));
                $user = User::create($data_user);
                $user->assignRole(request('role'));
                $data_karyawan['user_id'] = $user->id;
            } elseif ($karyawan->user && request('status_akun') == 1) {
                // karyawan punya akun, dan ingin mengedit karyawan dan akunnya
                $data_user = [];
                $data_user['name'] = request('nama');
                $data_user['email'] = request('email');
                if (request('password'))
                    $data_user['password'] = bcrypt(request('password'));
                $user = $karyawan->user()->update($data_user);
                $karyawan->user->syncRoles(request('role'));
            }

            $karyawan->update($data_karyawan);
            DB::commit();
            return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil diupdate.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy($id)
    {

        DB::beginTransaction();
        try {
            $item = Karyawan::findOrFail($id);
            $user = $item->user;
            $item->delete();
            if ($user) {
                $user->delete();
            }
            DB::commit();
            return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
