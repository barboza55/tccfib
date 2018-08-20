@extends('layouts.app')



@section('content')
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Observações do Cadastro</h3>
					</div>
					<div class="panel-body">
						<textarea class="form-control" rows="5">{{ $customer['obs'] }}</textarea>
						@if($customer['relacionamento'])
							<textarea rows="5" class="form-control">@foreach($customer['relacionamentoData'] as $linha){{ $linha['data'] }}:&nbsp{{ $linha['obs'] }}&#10;@endforeach</textarea>
							
							<!-- <table class="table table-striped table-condensed table-bordered">
								<thead>
									<th>Data</th>
									<th>Contato</th>
									<th>Obs</th>
								</thead>
								<tbody>
									@foreach($customer['relacionamentoData'] as $linha)
										<tr>
											<td>{{ $linha['data'] }}</td>
											<td>{{ $linha['contato'] }}</td>
											<td>{{ $linha['obs'] }}</td>
										</tr>
									@endforeach
								</tbody>
							</table> -->
						@else
							<p>Nao Tem relacionamento</p>
						@endif
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Dados Cliente</h3>
					</div>
					<div class="panel-body" id="teste">
						<p>
							<a target="_blank" href="http://aneethun-sian.com.br/app?component=edit_&page=pages%2Frecord%2FClientRecordList&service=direct&session=T&sp={{ $customer['Hidden'] }}">
								{{ $customer['Hidden'] }}
							</a>
													
						</p>
						<p>
							{{ $customer['name'] }}
						</p>
						<a target="_blank" class="btn btn-success" href="http://aneethun-sian.com.br/app?component=sale_&page=pages%2Fsale%2FSendSaleOrderClientList&service=direct&session=T&sp={{ $customer['Hidden'] }}">
							Novo Pedido
						</a>
						<a target="_blank" href="{{ url('localiza', $customer['Hidden']) }}">Pedidos</a>
						<p>{{ $pedido['cidade'] }}</p>
						<form class="form-inline" action="{{ route('apagar') }}" method="POST" target="_blank">
							{{ csrf_field() }}
							<input type="hidden" name="name" value="{{ $customer['name'] }}">
							@if(array_key_exists('cnpj', $customer))
							<input class="form-control mb-2 mr-sm-2" type="text" id="cpfcnpj" name="cpfcnpj" value="{{ $customer['cnpj'] }}">
							@else
							<input class="form-control mb-2 mr-sm-2" type="text" id="cpfcnpj" name="cpfcnpj"  value="{{ $customer['cpf'] }}">
							@endif
							<input class="btn btn-danger btn-sm" type="submit" value="Consultar" name="consulta">
						</form>
						
						
						<p class="noselect">{{ $customer['contactAddress'] }} {{ $customer['contactAddressNumber'] }}</p>
						<p>{{ $customer['contactQuarter'] }}</p>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Itens Pedido</h3>
					</div>
					<div class="panel-body pre-scrollable">
						<!--
						@foreach($pedido['itens'] as $item)
							@if($item['product_id'] == 184)
								<p style="color: white; background: red">{{ $item['amount'] }} UP CURLY</p>
							@endif
							@if($item['product_id'] == 1)
								<p style="color: white; background: blue">{{ $item['amount'] }} Creme silicone 250</p>
							@endif
							@if($item['product_id'] == 136)
								<p style="color: white; background: blue">{{ $item['amount'] }} Sh silicone 250</p>
							@endif
						@endforeach -->
						@if($pedido['totalhomecare'] >= 300.0 && $pedido['podes'])
							<p style="color: white; background: red">PROMOCAO BLOND REVIVE</p>
						@elseif($pedido['totalhomecare'] >= 300.0)
							<p style="color: white; background: red">Possibilidade promo Blond</p>
						@endif
						<table class="table table-striped table-condensed">
							<thead>
								<th>Cod</th>
								<th>Nome</th>
								<th>Quantidade</th>
							</thead>
							<tbody>
								@foreach($pedido['itens'] as $item)
								@if($item['grupo'])
								<tr>
									<td colspan="3" align="center" style="{{ $item['style'] }}">{{ $item['namegrupo'] }}</td>
								</tr>
								@else
								<tr>
									<td>{{ $item['product_id'] }}</td>
									<td>{{ $item['product_name'] }}</td>
									<td>{{ $item['amount'] }}</td>
								</tr>
								@endif
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Pedidos em transito</h3>
					</div>
					<div class="panel-body pre-scrollable">
						<table class="table table-striped table-condensed">
							<thead>
								<th>Cód</th>
								<th>Data</th>
								<th>Estado</th>
								<th>Valor</th>
							</thead>
							<tbody>
								@foreach($pedidosTransito as $item)
								<tr>
									<td>{{ $item['id'] }}</td>
									<td>{{ $item['data'] }}</td>
									<td>{{ $item['status'] }}</td>
									<td>{{ $item['total'] }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Combos Agosto</h3>
					</div>
					<div class="panel-body pre-scrollable">
						<table class="table table-striped table-condensed">
							<thead>
								<th>Combo</th>
								<th>Situação</th>
								<th>Ação</th>
							</thead>
							<tbody>
								@foreach($customer['combos'] as $key => $valor)
								<tr>
									<td>{{ $key }}</td>
									<td>{{ $valor }}</td>
									<td>
										@if($valor == 'ok')
										<a class="btn btn-primary botao2" href="{{ url('zera-combo', [
											$pedido['codigo'],
											'combo',
											$key,
											'retira',
											0
										] ) }}">Desconto</a>
										<a class="btn btn-success botao2" href="{{ url('zera-combo', [
											$pedido['codigo'],
											'combo',
											$key,
											'retira',
											1
										] ) }}">Desc+Inclui</a>
										@endif
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<form action="{{ url('aprove') }}" class="form-horizontal">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Ações</h3>
					</div>
					<div class="panel-body">
						
							<div class="form-group">
								<label for="fpagto" class="col-sm-2 control-label">Forma Pagto</label>
								<div class="col-sm-2">
									<select class="form-control" name="fpagto">
										@foreach($pedido['opts'] as $opt)
										<option @if($opt['selected']) selected="selected" @endif value="{{ $opt['value'] }}">{{ $opt['text'] }}</option>
										@endforeach
									</select>
								</div>
								<div class="col-sm-4">
									<table class="table table-striped table-condensed">
										<tr>
											<td>
												<a target="_blank" href="http://aneethun-sian.com.br/app?component=edit_&page=pages%2Fsale%2FSaleOrderAnalysisOrderList&service=direct&session=T&sp={{ $pedido['codigo'] }}">
													<label for="vendedor" class="control-label">Vendedor</label>
												</a>
											</td>
											<td>{{ $pedido['vendedor'] }}</td>
										</tr>
										<tr>
											<td>
												<label for="valor" class="control-label">Valor</label>
											</td>
											<td>
												{{ $pedido['valor'] }}
												<span>
													Média
													{{ $customer['mediaAnual'] }}
												</span>
											</td>
										</tr>
									</table>
								</div>
							</div>
							<div class="form-group">
								<label for="obs" class="col-sm-2 control-label">Publica</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="obs" name="obs" value="{{ $pedido['publicObs'] }}">
								</div>
							</div>
							<div class="form-group">
								<label for="obsP" class="col-sm-2 control-label">Privada</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="obsP" name="obsP" value="{{ $pedido['privateObs'] }}">
								</div>
							</div>
							{{ csrf_field() }}
							<input type="hidden" name="codigo" value="{{ $pedido['codigo'] }}">
							<div class="form-group">
								<div class="row botao">
									<div class="col-sm-offset-2 col-sm-10">
										<a class="btn btn-primary botao2" href="{{ url('editar', $pedido['codigo']) }}">Zerar</a>
										<button type="submit" class="btn btn-success" name="action" value="aprove" title="Tooltip on top">Aprovar</button>
										<button type="submit" class="btn btn-primary" name="action" value="save">Salvar</button>
										<button type="submit" class="btn btn-danger" name="action" value="cancel">Cancelar</button>
										<a class="btn btn-primary" href="{{ url('sian') }}" role="button">Voltar</a>
									</div>
								</div>
							</div>
						
						<!-- <a class="btn btn-success" href="{{ url('aprove', $pedido['codigo']) }}" role="button">Aprovar</a> -->
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Historico Pedidos</h3>
					</div>
					<div class="panel-body">
						<table class="table table-striped table-condensed">
							<thead>
								<th>Pedido</th>
								<th>Data</th>
								<th>Forma Pagto</th>
								<th>Valor</th>
							</thead>
							<tbody>
								@if($pedidos)
								@foreach($pedidos as $pedido)
								<tr>
									<td>{{ $pedido['id'] }}</td>
									<td>{{ $pedido['data'] }}</td>
									<td>{{ $pedido['formapagamento'] }}</td>
									<td>{{ $pedido['total'] }}</td>
								</tr>
								@endforeach
								@else
								<tr>
									<td colspan="3">
										<span>Sem registros!</span>
									</td>
								</tr>
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-danger">
					<div class="panel-heading">
						<h3 class="panel-title">Contas a receber</h3>
					</div>
					<div class="panel-body">
						<table class="table table-striped table-condensed">
							<thead>
								<th>Vencto</th>
								<th>Atraso</th>
								<th>Forma</th>
								<th>Valor</th>
							</thead>
							<tbody>
								@if($contas)
								@foreach($contas as $conta)
								<tr>
									<td>
										{{ $conta['data'] }}<br>
										{{ $conta['diff'] }}
									</td>
									<td>{{ $conta['formapagamento'] }}</td>
									<td>{{ $conta['total'] }}</td>
								</tr>
								@endforeach
								@else
								<tr>
									<td colspan="3">
										<span>Sem registros!</span>
									</td>
								</tr>
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h3 class="panel-title">Contas recebidas</h3>
					</div>
					<div class="panel-body pre-scrollable">
						<table class="table table-striped table-condensed">
							<thead>
								<th>Forma Pagto</th>
								<th>Vencto</th>
								<th>Pagto</th>
								<th>Valor</th>
							</thead>
							<tbody>
								@if($recebidas)
								@foreach($recebidas as $recebida)
								<tr>
									<td>{{ $recebida['formapagamento'] }}</td>
									<td>
										{{ $recebida['datavencto'] }}<br>
										<span>
											{{ $recebida['dif'] }}
										</span>
									</td>
									<td>
										{{ $recebida['datapagto'] }}
										<span>
											{{ $recebida['semanapagto'] }}
										</span>
									</td>
									<td>{{ $recebida['total'] }}</td>
								</tr>
								@endforeach
								@else
								<tr>
									<td colspan="4">
										<span>Sem registros!</span>
									</td>
								</tr>
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="row botao">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-success" name="action" value="aprove" title="Tooltip on top">Aprovar</button>
				<button type="submit" class="btn btn-primary" name="action" value="save">Salvar</button>
				<button type="submit" class="btn btn-danger" name="action" value="cancel">Cancelar</button>
				<a class="btn btn-primary" href="{{ url('sian') }}" role="button">Voltar</a>
			</div>
		</div>
		</form>
		@endsection