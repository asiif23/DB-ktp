<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Contracts\Role;

class UserController extends Controller
{
    public function index()
    {
        return view('user.panel')
            ->with('title', 'Dashboard | User')
            ->with('halaman', 'Dashboard')
            ->with('user', auth()->user()->name)
            ->with('role', auth()->user()->getRoleNames()->first());
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.user.create')
                ->with('title', 'Tambah User')
                ->with('halaman', 'Tambah User')
                ->with('user', auth()->user()->name)
                ->with('role', auth()->user()->getRoleNames()->first());
    }

}
