@extends('layouts.app')

@section('title', '| Users')

@section('content')

<div class="col-lg-10 col-lg-offset-1">
    <h1><i class="fa fa-users"></i> Usuários <a href="{{ route('roles.index') }}" class="btn btn-primary float-right">Funções</a>
    <a href="{{ route('permissions.index') }}" class="btn btn-primary float-right">Permissões</a></h1>
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">

            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Criação</th>
                    <th>Funções</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)
                <tr>

                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('F d, Y h:ia') }}</td>
                    <td>{{  $user->roles()->pluck('name')->implode(' ') }}</td>{{-- Retrieve array of roles associated to a user and convert to string --}}

                    <td>
                        <div class="row">
                            <div class="col-xs-4">
                                 <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info pull-left" style="margin-right: 3px;">Editar</a>
                            </div>
                            <div class="col-xs-4">
                                {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id] ]) !!}
                                {!! Form::submit('Apagar', ['class' => 'btn btn-danger', 'style' => 'width: 74px;']) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                   

                    

                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    <a href="{{ route('users.create') }}" class="btn btn-success">Criar Usuário</a>

</div>

@endsection