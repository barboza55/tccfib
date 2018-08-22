@extends('layouts.app')
@section('content')
		<div class="panel panel-success">
		  	<div class="panel-heading">
		   		<h3 class="panel-title">Resposta Consulta - {{ $name }}</h3>
		  	</div>
		  	<div class="panel-body">
		  		<p>{{ $response->consumidor->{'consumidor-pessoa-juridica'}->{'razao-social'} or $response->consumidor->{'consumidor-pessoa-fisica'}->{'nome'} }}</p>
		  		@if($response->restricao)
		  		<div class="row border">
		  			<div class="col-4">SPC</div>
		  			<div class="col">{{ $response->spc->resumo->{'quantidade-total'} }}</div>
		  		</div>
		  		<div class="row border">
		  			<div class="col-4">Cheques Lojistas</div>
		  			<div class="col">{{ $response->{'cheque-lojista'}->resumo->{'quantidade-total'} }}</div>
		  		</div>
		  		<div class="row border">
		  			<div class="col-4">CCF</div>
		  			<div class="col">{{ $response->ccf->resumo->{'quantidade-total'} }}</div>
		  		</div>
		  		<div class="row border">
		  			<div class="col-4">Contra Ordem Documento diferente</div>
		  			<div class="col">{{ $response->{'contra-ordem-documento-diferente'}->resumo->{'quantidade-total'} }}</div>
		  		</div>
		  		<div class="row border">
		  			<div class="col-4">Protesto</div>
		  			<div class="col">{{ $response->protesto->resumo->{'quantidade-total'} }}</div>
		  		</div>
		  		<div class="row border">
		  			<div class="col-4">Contra Ordem</div>
		  			<div class="col">{{ $response->{'contra-ordem'}->resumo->{'quantidade-total'} }}</div>
		  		</div>
		  		
		  		<div class="row border">
		  			<div class="col-4">Contumacia</div>
		  			<div class="col">{{ $response->contumacia->resumo->{'quantidade-total'} }}</div>
		  		</div>
		  		<div class="row border">
		  			<div class="col-4">Judiciario</div>
		  			<div class="col">{{ $response->{'informacao-poder-judiciario'}->resumo->{'quantidade-total'} }}</div>
		  		</div>
		  		@endif
		   	 	
		   	 	<!-- <h5>SPC <span class="badge badge-danger"></span></h5>
		   	 	<h5> <span class="badge badge-danger"></span></h5>
		   	 	<h5>CCF <span class="badge badge-danger"></span></h5>
		   	 	<h5>Contra Ordem Doc Dif <span class="badge badge-danger"></span></h5>
		   	 	<h5>Protestos <span class="badge badge-danger"></span></h5>
		   	 	<h5>Contra Ordem <span class="badge badge-danger"></span></h5> -->
		   	 	
		  	</div>
		</div>
@endsection