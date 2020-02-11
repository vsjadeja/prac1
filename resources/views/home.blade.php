@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($permissionDenied = Session::get('permission-denied'))
                        <div class="alert alert-danger">
                            {{ $permissionDenied }}
                        </div>
                    @endif
                    <a href="{{ route('users.index') }}">Users</a>
                    <a href="{{ route('roles.index') }}">Roles</a>
                    <a href="{{ route('packages.index') }}">Packages</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
