@extends('layouts.app')

@section('content')
<div class="container">
	<table class="table table-striped table-condensed">
		<caption>Pedido de compra</caption>
		<thead>
			<tr>
				<th>Produto</th>
				<th>Cx</th>
				<th>Media ult 3 meses</th>
				<th>Saída Diária</th>
				<th>Estoque</th>
				<th>Precisa</th>
				
			</tr>
		</thead>
		<tbody>
			@foreach($lista as $produto)
				@if($produto['grupo'])
					<tr align="center" style="{{ $produto['style'] }}">
						<td colspan="6">{{ $produto['nomegrupo'] }}</td>
					</tr>
				@else
					<tr>
						<td>
							{{ $produto['nome'] }}
						</td>
						<td>{{ $produto['caixa'] }}</td>
						<td>{{ $produto['media'] }}</td>
						<td>{{ $produto['pordia'] }}</td>
						<td>{{ $produto['estoque'] }}</td>
						<td>
							<input class="form-control" type="number" name="{{ $produto['inputname'] }}" value="{{ $produto['precisa'] }}">
						</td>	
					</tr>
				@endif
				
			@endforeach
		</tbody>
	</table>
</div>	
@endsection