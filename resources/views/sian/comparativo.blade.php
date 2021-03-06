@extends('layouts.app')

@section('content')
		
		<div class="row" id="form_search">
			<div class="col-md-12">
				<form action="{{ url('comparativo') }}" class="form-inline" method="POST">
					{{ csrf_field() }}
				    <div class="form-group">
				    	<label for="cliente_id">Cliente</label>
				    	<input type="number" class="form-control" id="cliente_id" name="cliente_id" value="{{ old('cliente_id') }}">
				    </div>

				    <div class="form-group">
				    	<select class="form-control" id="input" name="input">
				    	  @foreach($tabela['cidades'] as $option)
				    	  	<option value="{{ $loop->index }}" {{ old('input') == $loop->index ? 'selected="selected"' : '' }}>{{ $option->textContent }}</option>
				    	  @endforeach
				    	</select>
				    </div>
				    
				    <div class="form-group">
				    	<div class="btn-group">
				    		<button type="submit" class="btn btn-primary" name="operacao" value="+">Atualizar</button>
				    	</div>
				    </div>
				    <div class="form-group">
				    	<div class="radio">
				    		<label class="radio-inline">
				    			<input type="radio" name="valueUnit" id="valueUnit" value="0" {{ old('valueUnit') == 0 ? 'checked="checked"' : '' }}>Valores
				    		</label>
				    		<label class="radio-inline">
				    			<input type="radio" name="valueUnit" id="valueUnit" value="1" {{ old('valueUnit') == 1 ? 'checked="checked"' : '' }}>Unidades
				    		</label>
				    	</div>
				    </div>
				</form>
			</div>
		</div>
		<div class="row">
			@if($tabela['exist'])
				<div class="table-responsive">
					<table class="table table-bordered table-responsive">
						<thead>
							<tr>
								@foreach($tabela['ths'] as $th)
									<th>{{ $th['text'] }}</th>
								@endforeach
							</tr>
						</thead>
						<thead>
							<tr>
								<th></th>
								@foreach($tabela['thsft'] as $th)
									<!-- <th>{{ (float) $th['number'] * 1.02}}</th> -->
									<th>{{ $loop->parent }}</th>
								@endforeach
								<th></th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th></th>
								@foreach($tabela['thsft'] as $th)
									<th>{{ $th['text'] }}</th>
								@endforeach
								<th></th>
							</tr>
						</tfoot>
						<tbody>
							@foreach($tabela['trs'] as $tr)
								<tr>
									@foreach($tr['tds'] as $td)
										<td>{{ $td }}</td>
									@endforeach
								</tr>
								
							@endforeach
						</tbody>
					</table>
				</div>
			    
			@endif
		</div>
	
@endsection
	

