@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Product</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('packages.index') }}"> Back</a>
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
    {!! Form::open(['route' => 'packages.store', 'files' => true]) !!}
    	@csrf
         <div class="row">
		    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Name:</strong>
                    {!! Form::text('name', null, ['placeholder' => 'Name','class' => 'form-control']) !!}
		        </div>
		    </div>
		    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Description:</strong>
                    {!! Form::textarea('description', null, ['placeholder' => 'Description','class' => 'form-control', 'style' => 'height:150px']) !!}
		        </div>
		    </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Price:</strong>
                    {!! Form::number('price', null, ['placeholder' => 'Price','class' => 'form-control']) !!}
		        </div>
		    </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Thumb:</strong>
                    {!! Form::file('thumb') !!}
		        </div>
		    </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Package Type:</strong>
                    {!! Form::select('package_type_id', $ptypes, null, ['placeholder' => 'Package Type','class' => 'form-control']) !!}
		        </div>
		    </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Status:</strong>
                    {!! Form::select('status', ['1' => 'Enable', '0' => 'Disable'],'1', ['placeholder' => 'Status','class' => 'form-control']) !!}
		        </div>
		    </div>
		    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    {!! Form::submit('Save',['class' => 'btn btn-primary']) !!}
		    </div>
		</div>
    {!! Form::close() !!}
@endsection