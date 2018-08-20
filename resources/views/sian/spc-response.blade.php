@extends('layouts.app')
@section('content')
		<div class="panel panel-success">
		  	<div class="panel-heading">
		   		<h3 class="panel-title">Resposta Consulta</h3>
		  	</div>
		  	<div class="panel-body">
		   	 	<p>{{ $response->consumidor->{'consumidor-pessoa-fisica'}->nome }}</p>
		   	 	@if($response->restricao)
		   	 	<h3>SPC</h3>
		   	 	<p>{{ $response->spc->resumo->{'quantidade-total'} }}</p>
		   	 	<h3>Cheques Lojistas</h3>
		   	 	<p>{{ $response->{'cheque-lojista'}->resumo->{'quantidade-total'} }}</p>
		   	 	<h3>CCF</h3>
		   	 	<p>{{ $response->ccf->resumo->{'quantidade-total'} }}</p>
		   	 	<h3>Contra Ordem Doc Dif</h3>
		   	 	<p>{{ $response->{'contra-ordem-documento-diferente'}->resumo->{'quantidade-total'} }}</p>
		   	 	<h3>Protestos</h3>
		   	 	<p>{{ $response->protesto->resumo->{'quantidade-total'} }}</p>
		   	 	<h3>Contra Ordem</h3>
		   	 	<p>{{ $response->{'contra-ordem'}->resumo->{'quantidade-total'} }}</p>
		  

		   	 	
		   	 	@endif
		  	</div>
		</div>
@endsection