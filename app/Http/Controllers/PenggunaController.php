<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ktp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Contracts\Activity as ContractsActivity;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = User::latest()->paginate(20);
        return view('dashboard.user.read', compact('datas'))
        
                ->with('title', 'Tambah User')
                ->with('halaman', 'Tambah Data User')
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
                ->with('halaman', 'Tambah Data User')
                ->with('user', auth()->user()->name)
                ->with('role', auth()->user()->getRoleNames()->first());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function edit($id)
    {
        $data = User::findOrFail($id);
        return view('dashboard.user.edit', compact('data'))
                ->with('title', 'Edit User')
                ->with('halaman', 'Edit Data User')
                ->with('user', auth()->user()->name)
                ->with('role', auth()->user()->getRoleNames()->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function update(Request $request, $id)
    {
        $user = auth()->user()->name;
        activity()
            ->username($user)
            ->log('User ' . $request->name . ' telah diupdate');
        $data = User::findOrFail($id);
        $data->update($request->all());
        return redirect('admin/users')
                ->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function destroy($id)
    {
        $user = auth()->user()->name;
        activity()
            ->username($user)
            ->log('Menghapus Data User');
        User::destroy($id);
        return redirect('admin/users')
                ->with('success', 'Data Berhasil Dihapus');
    }


// ================
//   FUNGSI E-KTP
// ================
    function lihatktp(){
        {
            $dataAll = Ktp::paginate(20);
            return view('dashboard.ktp.read', compact('dataAll'))
            
                    ->with('title', 'Data KTP')
                    ->with('halaman', 'Lihat Data Lengkap')
                    ->with('user', auth()->user()->name)
                    ->with('role', auth()->user()->getRoleNames()->first());
        }
    }

    function searchktp(){

            $dataAll = Ktp::latest();

            if(request('search')) {
                $dataAll->where('nama', 'LIKE', '%' . request('search') . '%');
            }

            return view('dashboard.ktp.read', [
                "dataAll" => $dataAll->get(),
                "title" => "Data KTP",
                "halaman" => "Lihat Data Lengkap",
                "user" => auth()->user()->name,
                "role" => auth()->user()->getRoleNames()->first()
            ]);
    }

    public function profile(Request $id){
        $data = Ktp::all();
        return view ('user/profile', compact('data'))
                ->with('title', 'Profile')
                ->with('halaman', 'Profile')
                ->with('user', auth()->user()->name)
                ->with('role', auth()->user()->getRoleNames()->first());
    }

    protected function store(Request $request)
    {
        $userr = auth()->user()->name;
        activity()
            ->username($userr)
            ->log('Menambahkan User Baru');
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        $user->assignRole('User');
        return redirect('/admin/users')
                ->with('success', 'Data Berhasil Ditambahkan');
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function tambah_user(Request $request,$data){
        $userr = auth()->user()->name;
        activity()
            ->username($userr)
            ->log('menambahkan user baru');
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $user -> assignRole('User');
        return $user;
    }

    protected function hitung1(){
        $hitungktp1 = Ktp::count();
        $hitunguser1 = User::count();
        return view('user.panel', compact('hitungktp1', 'hitunguser1'))
                ->with('title', 'Data KTP')
                ->with('halaman', 'Lihat Data Lengkap')
                ->with('user', auth()->user()->name)
                ->with('role', auth()->user()->getRoleNames()->first());
    }
}
