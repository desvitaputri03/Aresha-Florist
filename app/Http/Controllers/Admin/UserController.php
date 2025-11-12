<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseAdminController as Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Tampilkan daftar user/pelanggan
     */
    public function index()
    {
        $users = User::where('is_admin', false)->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Tampilkan detail user
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }
}
