@extends('layouts.app')

@section('content')
<?php
if(Auth::user()->hasRole('Admin'))
    {
    echo '<li class="nav-item">
            <a class="nav-link btn btn-sm btn-outline-danger btn-dark text-light ms-2" href="'.route('admin.dashboard').'">Dashboard</a>
        </li>';
    }
    else {
    echo '<li class="nav-item">
            <a class="nav-link btn btn-sm btn-dark btn-outline-success text-light ms-2" href="'.route('user.dashboard').'">Dashboard</a>
        </li>';
    }
?>
</ul>
</div>
</div>
</nav>
<main class="py-4">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
