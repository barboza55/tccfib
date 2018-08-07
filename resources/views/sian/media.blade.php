@extends('layouts.app')
@section('content')
		<div class="row">
			<div class="col-md-4">
				<form action="{{ url('media') }}" class="form-horizontal" method="POST">
					{{ csrf_field() }}
				    <div class="form-group">
				    	<label for="cliente_id">Código Cliente</label>
				    	<input type="number" class="form-control" id="cliente_id" name="cliente_id" value="{{ $cliente['cliente_id'] or '' }}">
				    </div>
				    <div class="form-group">
				    	<div class="btn-group">
				    		<button type="submit" class="btn btn-primary" name="operacao" value="+">Procurar</button>
				    	</div>
				    </div>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				@if(($cliente['media']))
					<h3>R$ {{ $cliente['media'] }}</h3>
				@endif
			</div>
		</div>
@endsection