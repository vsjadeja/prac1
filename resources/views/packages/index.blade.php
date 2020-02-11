@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Packages</h2>
            </div>
            <div class="pull-right">
                @can('package-create')
                <a class="btn btn-success" href="{{ route('packages.create') }}"> Create New Package</a>
                @endcan
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Thumb</th>
            <th>Package Type</th>
            <th>Status</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($packages as $package)
	    <tr>
	        <td>{{ ++$i }}</td>
	        <td>{{ $package->name }}</td>
	        <td>{{ $package->description }}</td>
            <td>{{ $package->price }}</td>
            <td><img src="{{ $package->thumb }}" /></td>
            <td>{{ $package->packageType->name }}</td>
            <td>
                @if ($package->status)
                    Enable
                @else
                    Disable
                @endif
            </td>
	        <td>
                <form action="{{ route('packages.destroy',$package->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('packages.show',$package->id) }}">Show</a>
                    @can('package-edit')
                    <a class="btn btn-primary" href="{{ route('packages.edit',$package->id) }}">Edit</a>
                    @endcan

                    @csrf
                    @method('DELETE')
                    @can('package-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>


    {!! $packages->links() !!}


@endsection