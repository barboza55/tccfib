@extends('layouts.app')
@section('content')
		<div class="panel panel-default">

			<div class="panel-heading">
		    	<h3 class="panel-title">Totalização votos</h3>
		    	<p>
		    		Total de votos:
		    		<span>{{ $votes or 3 }}</span>
		    	</p>
		  	</div>
		  	<div class="panel-body">
		  		<table class="table-hover table-bordered">
		  			<thead>
		  				<th>Descrição</th>
		  				<th>Total</th>
		  			</thead>
		  			<tbody>
		  				@foreach($typeVotes as $type)
		  				<tr>
		  					<td>{{ $type->description }}</td>
		  					<td>{{ $type->itemVotings()->count() }}</td>
		  				</tr>
		  				@endforeach
		  			</tbody>
		  		</table>
		  	</div>
		</div>
@endsection