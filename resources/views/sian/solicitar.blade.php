@extends('layouts.app')



@section('content')
	
		<div class="row">
			<div class="col-md-4">
				<form action="{{ url('solicitar') }}" class="form-horizontal" method="POST">
					{{ csrf_field() }}
				    <div class="form-group">
				    	<label for="cliente_id">Cliente</label>
				    	<input type="number" class="form-control" id="cliente_id" name="cliente_id" value="{{ old('cliente_id') }}">
				    </div>
				    <div class="form-group">
				    	<div class="btn-group">
				    		<button type="submit" class="btn btn-danger" name="operacao" value="-">Retirar</button>
				    		<button type="submit" class="btn btn-primary" name="operacao" value="+">Colocar</button>
				    	</div>
				    </div>
				</form>
			</div>
		</div>
	
@endsection
	

