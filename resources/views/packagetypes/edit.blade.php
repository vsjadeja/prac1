@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Package Type</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('packagetypes.index') }}"> Back</a>
            </div>
        </div>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {!! Form::open(['route' => ['packagetypes.update', $packagetype->id]]) !!}
    	@csrf
        @method('PUT')
         <div class="row">
		    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Name:</strong>
                    {!! Form::text('name', $packagetype->name, ['placeholder' => 'Name','class' => 'form-control']) !!}
		        </div>
		    </div>
		    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Status:</strong>
                    {!! Form::select('status', ['1' => 'Enable', '0' => 'Disable'], $packagetype->status, ['placeholder' => 'Status','class' => 'form-control']) !!}
		        </div>
		    </div>
		    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
		      <button type="submit" class="btn btn-primary">Submit</button>
		    </div>
		</div>
    {!! Form::close() !!}
@endsection