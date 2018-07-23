@extends('layouts.app')

@section('title', '| Add User')

@section('content')

<div class='col-lg-4 col-lg-offset-4'>

    <h1><i class='fa fa-user-plus'></i>Adicionar Usuário</h1>
    <hr>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- @include ('errors.list') --}}

    {{ Form::open(array('url' => 'users')) }}

    <div class="form-group">
        {{ Form::label('name', 'Nome') }}
        {{ Form::text('name', '', array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('email', 'Email') }}
        {{ Form::email('email', '', array('class' => 'form-control')) }}
    </div>



    <div class='form-group'>
        @foreach ($roles as $role)
            {{ Form::checkbox('roles[]',  $role->id ) }}
            {{ Form::label($role->name, ucfirst($role->name)) }}<br>

        @endforeach
    </div>

    <div class="form-group">
        {{ Form::label('password', 'Senha') }}<br>
        {{ Form::password('password', array('class' => 'form-control')) }}

    </div>

    <div class="form-group">
        {{ Form::label('password', 'Confirmar Senha') }}<br>
        {{ Form::password('password_confirmation', array('class' => 'form-control')) }}

    </div>
    <div class="form-group">
        {{ Form::label('sian_user', 'Usuario Sian') }}<br>
        {{ Form::text('sian_user', '', array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('sian_pass', 'Senha Sian') }}<br>
        {{ Form::password('sian_pass', '', array('class' => 'form-control')) }}
    </div>

    {{ Form::submit('Criar', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

</div>

@endsection