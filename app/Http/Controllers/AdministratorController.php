<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use APP\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Ktp;
use App\Models\ActivityLog;
use App\Exports\KtpExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Imports\KtpImport;
use Spatie\Activitylog\Models\Activity;


class AdministratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = User::all();
        $hitunguser = User::count();
        $hitungktp = Ktp::count();
        return view('dashboard.user.read', compact('datas','hitunguser','hitungktp'))
        
                ->with('title', 'Manage User')
                ->with('halaman', 'Manage User')
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
        return view('dashboard.ktp.create')
                ->with('title', 'Tambah EKTP')
                ->with('halaman', 'Tambah Data E-KTP')
                ->with('user', auth()->user()->name)
                ->with('role', auth()->user()->getRoleNames()->first());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user()->name;
        activity()
            ->username($user)
            ->log('Menambahkan Data E-KTP');
        $request->validate([
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $image = $request->file('foto');
        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('storage'), $new_name);
        $form_data = array(
            'nama' => $request->nama,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'foto' => $new_name,
        );
        Ktp::create($form_data);
        return redirect('ektp')
                ->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Ktp::findOrFail($id);
        return view('dashboard.ktp.show', compact('data'))
                ->with('title', 'Profil User')
                ->with('halaman', 'Profil '.$data->nama)
                ->with('user', auth()->user()->name)
                ->with('role', auth()->user()->getRoleNames()->first());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Ktp::findOrFail($id);
        return view('dashboard.ktp.edit', compact('data'))
                ->with('title', 'Edit EKTP')
                ->with('halaman', 'Edit Data E-KTP')
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
    public function update(Request $request, $id)
    {
        $user = auth()->user()->name;
        activity()
            ->username($user)
            ->log('Mengedit Data E-KTP');
        $data = Ktp::findOrFail($id);
        $image = $request->file('foto');
        $new_name = $image->getClientOriginalExtension();
        $image->move(public_path('storage'), $new_name);
        $form_data = array(
            'nama' => $request->nama,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'foto' => $new_name,
        );
        $data->update($request->all());
        return redirect('ektp')
                ->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user()->name;
        activity()
            ->username($user)
            ->log('Menghapus Data E-KTP');
            
        Ktp::destroy($id);
        return redirect('ektp')
                ->with('success', 'Data Berhasil Dihapus');
    }

    public function Profile(){
        {
            $datas = User::all();
            return view('admin.profile', compact('datas'))
            
                    ->with('title', 'Admin Profile')
                    ->with('halaman', 'Profil Admin')
                    ->with('user', auth()->user()->name)
                    ->with('role', auth()->user()->getRoleNames()->first());
        }
    }

    // function lihatktp(){
    //     {
    //         dd(request('search'));
    //         // $dataAll = $this->withprogressBar(Ktp::all());
    //         // $this->performtask($dataAll);
    //         // return view('dashboard.ktp.read', compact('dataAll'))
    //         //         ->with('title', 'Data KTP')
    //         //         ->with('halaman', 'Lihat Data Lengkap')
    //         //         ->with('user', auth()->user()->name)
    //         //         ->with('role', auth()->user()->getRoleNames()->first());
    //     }
    // }

    public function hapusUser($id){
        $user = auth()->user()->name;
        activity()
            ->username($user)
            ->log('Menghapus Data User');
        User::destroy($id);
        return redirect('/user/dashboard')
                ->with('success', 'Data Berhasil Dihapus');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function ktpexport(){
        $user = auth()->user()->name;
        activity()
            ->username($user)
            ->log('Mengunduh Data E-KTP');
        return Excel::download(new KtpExport, 'data.xlsx');
    }

    public function ktpimport(){
        return view('dashboard.ktp.import')
                ->with('title', 'Import Data KTP')
                ->with('halaman', 'Import Data KTP')
                ->with('user', auth()->user()->name)
                ->with('role', auth()->user()->getRoleNames()->first());
    }

    public function import(){
        $user = auth()->user()->name;
        activity()
            ->username($user)
            ->log('Mengimport Data E-KTP');
        $file = request()->file('file');
        $nama_file = rand().$file->getClientOriginalName();
        $file->move('exceldata', $nama_file);

        Excel::import(new KtpImport, public_path('/exceldata/'.$nama_file));
        return redirect('ektp')
                ->with('success', 'Data Berhasil Diimport');
    }

    public function activity(){
        $log = ActivityLog::orderBy('id', 'desc')->paginate(10);
        return view('admin.activity', compact('log'))
                ->with('title', 'User Activity')
                ->with('halaman', 'User Activity')
                ->with('user', auth()->user()->name)
                ->with('role', auth()->user()->getRoleNames()->first());
    }

    public function hitung(){
        $hitungktp = Ktp::count();
        $hitunguser = User::count();
        return view('admin.panel', compact('hitungktp', 'hitunguser'))
                ->with('title', 'Data KTP')
                ->with('halaman', 'Lihat Data Lengkap')
                ->with('user', auth()->user()->name)
                ->with('role', auth()->user()->getRoleNames()->first());
    }
}
