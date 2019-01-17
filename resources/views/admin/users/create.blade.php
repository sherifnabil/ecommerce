@extends('admin.index')
@section('content')


<div class="box">
            <div class="box-header">
              <h3 class="box-title">{{ $title }}</h3>
            </div>
            <div class="box-body">
            {!! Form::open(['url'   =>  aurl('users')]) !!}
                <div class="form-group">
                    {!! Form::label('name', trans('admin.user_name')) !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}

                </div>
                <div class="form-group">
                    {!! Form::label('email', trans('admin.user_email')) !!}
                    {!! Form::email('email', old('email'), ['class' => 'form-control']) !!}

                </div>
                <div class="form-group">
                    {!! Form::label('level', trans('admin.level')) !!}
                    {!! Form::select('level', ['user' => trans('admin.user'), 'vendor' => trans('admin.vendor'), 'company' => trans('admin.company')],  old('email'), ['class' => 'form-control', 'placeholder' => '.....................']) !!}

                </div>
                <div class="form-group">
                    {!! Form::label('password', trans('admin.password')) !!}
                    {!! Form::password('password', ['class' => 'form-control']) !!}

                </div>

                {!! Form::submit(trans('admin.add'), ['class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}


            </div>
          </div>



@endsection
