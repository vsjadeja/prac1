@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Permission</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('permissions.index') }}"> Back</a>
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
    {!! Form::open(['route' => 'permissions.store']) !!}
         <div class="row">
		    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Name:</strong>
                    {!! Form::text('name', null, ['placeholder' => 'Name','class' => 'form-control']) !!}
		        </div>
		    </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Guard Name:</strong>
                    {!! Form::text('guard_name', null, ['placeholder' => 'Guard Name','class' => 'form-control']) !!}
		        </div>
		    </div>
		    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    {!! Form::submit('Save',['class' => 'btn btn-primary']) !!}
		    </div>
		</div>
    {!! Form::close() !!}
@endsection