@extends('layouts.app')
@section('content')
		<div class="panel panel-primary">
		
			<div class="panel-heading">
		    	<h3 class="panel-title">Novo voto</h3>
		  	</div>
		  	<div class="panel-body">
		  		<form action="{{ route('votes.store') }}" method="POST">
		  			{{ csrf_field() }}
		  			<div class="row">
		  				<div class="col-md-4">
		  					<div class="form-group">
		  						<label for="cpf">CPF</label>
		  						<input type="number" class="form-control" name="cpf" id="cpf">
		  					</div>
		  				</div>
		  			</div>
		  			<div class="row">
		  				<div class="col-md-6">
		  					@foreach($typeVotes as $type)
		  					<div class="form-group">
		  						<div class="checkbox">
		  							<label>
		  							  <input type="checkbox" name="itemvote[]" value="{{ $type->id }}">{{ $type->description }}
		  							</label>
		  						</div>
		  					</div>
		  					@endforeach
		  				</div>
		  			</div>
		  			<button type="submit" class="btn btn-primary">Votar</button>
		  		</form>
		  	</div>
		</div>

@endsection