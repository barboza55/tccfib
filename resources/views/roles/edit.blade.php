@extends('layouts.app')

@section('title', '| Edit Role')

@section('content')

<div class='col-lg-4 col-lg-offset-4'>
    <h1><i class='fa fa-key'></i> Editar Função: {{$role->name}}</h1>
    <hr>
    {{-- @include ('errors.list')
 --}}
    {{ Form::model($role, array('route' => array('roles.update', $role->id), 'method' => 'PUT')) }}

    <div class="form-group">
        {{ Form::label('name', 'Nome') }}
        {{ Form::text('name', null, array('class' => 'form-control')) }}
    </div>

    <h5><b>Vincular permissão</b></h5>
    <div class="row">
        @foreach ($permissions as $permission)
            
                {{Form::checkbox('permissions[]',  $permission->id, $role->permissions ) }}
           
            
                {{Form::label($permission->name, ucfirst($permission->name)) }}
            
          

        @endforeach
    </div>
    
    <br>
    {{ Form::submit('Salvar', array('class' => 'btn btn-primary')) }}
    <a href="{{ url()->previous() }}" class="btn btn-primary">Voltar</a>
    {{ Form::close() }}    
</div>

@endsection