@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Package Types</h2>
            </div>
            <div class="pull-right">
                @can('packagetype-create')
                <a class="btn btn-success" href="{{ route('packagetypes.create') }}"> Create New Package Type</a>
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
            <th>Status</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($packageTypes as $packageType)
	    <tr>
	        <td>{{ ++$i }}</td>
	        <td>{{ $packageType->name }}</td>
	        <td>
                @if ($packageType->status)
                    Enable
                @else
                    Disable
                @endif
            </td>
	        <td>
                <form action="{{ route('packagetypes.destroy',$packageType->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('packagetypes.show',$packageType->id) }}">Show</a>
                    @can('packagetype-edit')
                    <a class="btn btn-primary" href="{{ route('packagetypes.edit',$packageType->id) }}">Edit</a>
                    @endcan

                    @csrf
                    @method('DELETE')
                    @can('packagetype-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>
    {!! $packageTypes->links() !!}
@endsection