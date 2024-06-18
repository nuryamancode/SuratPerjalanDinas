<?php

namespace App\Http\Controllers\Wakildirekturii;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        $count = [
            'user' => User::count(),
            'role' => Role::count(),
            'permission' => Permission::count()
        ];
        return view('wakil-direktur-ii.pages.dashboard', [
            'title' => 'Dashboard',
            'count' => $count
        ]);
    }

    public function profile()
    {
        return view('wakil-direktur-ii.pages.profile', [
            'title' => 'Profile'
        ]);
    }
}
