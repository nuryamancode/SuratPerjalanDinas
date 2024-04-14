<?php

namespace App\Http\Controllers\Pelaksanaspd;

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
        return view('pelaksana-spd.pages.dashboard', [
            'title' => 'Dashboard',
            'count' => $count
        ]);
    }
}
