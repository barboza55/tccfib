@extends('layouts.app')



@section('content')
	
		<div class="row">
			<div class="col-md-4">
				<form action="{{ url('isentar') }}" class="form-horizontal" method="POST">
					{{ csrf_field() }}
				    <div class="form-group">
				    	<label for="pedido_id">Pedido</label>
				    	<input type="number" class="form-control" id="pedido_id" name="pedido_id" value="{{ old('pedido_id') }}">
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
	

