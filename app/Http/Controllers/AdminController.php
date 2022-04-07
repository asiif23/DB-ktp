<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.panel')
            ->with('title', 'Dashboard | Admin')
            ->with('halaman', 'Dashboard')
            ->with('user', auth()->user()->name)
            ->with('role', auth()->user()->getRoleNames()->first());

    }
}
