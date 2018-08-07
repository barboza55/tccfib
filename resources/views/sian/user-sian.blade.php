@extends('layouts.app')

@section('title', '| Create New Post')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

        <h1>Usuário Sian</h1>
        <hr>
        <form action="{{ route('usersiangrava') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="user">Usuário</label>
                <input type="text" class="form-control" id="user" name="user" value="{{ $data['user'] or '' }}">
            </div>
            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" class="form-control" id="password" name="password" value="{{ $data['password'] or '' }}">
            </div>
            <div class="form-group">
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary" name="" value="">Salvar</button>
                </div>
            </div>
        </form>
        </div>
    </div>

@endsection