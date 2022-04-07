@extends( (Auth::user()->hasRole('Admin')) ? 'admin.dashboard' : 'user.dashboard')

@section( (Auth::user()->hasRole('Admin')) ? 'kontenUserAdmin' : 'kontenUserPengguna')

@endsection