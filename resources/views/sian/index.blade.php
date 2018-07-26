@extends('layouts.app')



@section('content')

	
		
	<h5>Total Pedidos:{{ count($fullOrders) }}</h5>
	<table class="table table-striped table-condensed">
		<thead>
			<th>Codigo</th>
			<th>Data</th>
			<th></th>
			<th>Nome</th>
			<th>Cidade</th>
			<th>Cidade</th>
		</thead>
		<tbody>
			@foreach($fullOrders as $order)
			<tr>
				<td>{{ $order['id'] }}</td>
				<td>{{ $order['dataCad'] }}</td>
				<td>
					<img src="{{ url('img/') .'/'.$order['statuscliente'].'.png'}}" alt="">
				</td>
				<td>
					<a href="{{ route('sian', ['id' => $order['id'], 'status' => $order['statuscliente']]) }}">{{ $order['nome'] }}</a>
				</td>
				
				<td>{{ $order['cidade'] }}</td>
				<td>
					{{ $order['total'] }}
				</td>
			</tr>
			@if($loop->last)
			<tfoot>
				<tr>
					<td colspan="5">Total de Pedidos</td>
					<td>{{ $loop->count }}</td>
				</tr>
			</tfoot>
			@endif
			@endforeach

		</tbody>
	</table>
	
@endsection