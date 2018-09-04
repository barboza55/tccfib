@extends('layouts.app')
@section('content')
	<div class="card text-white bg-success mb-3" style="max-width: 18rem;">
	  	<div class="card-header">Header</div>
	  	<div class="card-body">
	    <h5 class="card-title">Success card title</h5>
	    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
	  	</div>
	</div>
		<div class="panel panel-success">
		  	<div class="panel-heading">
		   		<h3 class="panel-title">Resposta Consulta - {{ $name or 'Nome' }}</h3>
		  	</div>
		  	<div class="panel-body">
		  		<p>{{ $response->consumidor->{'consumidor-pessoa-juridica'}->{'razao-social'} or $response->consumidor->{'consumidor-pessoa-fisica'}->{'nome'} or 'resposta'}}</p>
		  		@if($response->restricao or 0)
		  		<div class="row border">
		  			<div class="col-4">SPC</div>
		  			<div class="col">{{ $response->spc->resumo->{'quantidade-total'} or '0'}}</div>
		  		</div>
		  		<div class="row border">
		  			<div class="col-4">Cheques Lojistas</div>
		  			<div class="col">{{ $response->{'cheque-lojista'}->resumo->{'quantidade-total'} or '0' }}</div>
		  		</div>
		  		<div class="row border">
		  			<div class="col-4">CCF</div>
		  			<div class="col">{{ $response->ccf->resumo->{'quantidade-total'} or '0' }}</div>
		  		</div>
		  		<div class="row border">
		  			<div class="col-4">Contra Ordem Documento diferente</div>
		  			<div class="col">{{ $response->{'contra-ordem-documento-diferente'}->resumo->{'quantidade-total'} or '0' }}</div>
		  		</div>
		  		<div class="row border">
		  			<div class="col-4">Protesto</div>
		  			<div class="col">{{ $response->protesto->resumo->{'quantidade-total'} or '0' }}</div>
		  		</div>
		  		<div class="row border">
		  			<div class="col-4">Contra Ordem</div>
		  			<div class="col">{{ $response->{'contra-ordem'}->resumo->{'quantidade-total'} or '0' }}</div>
		  		</div>
		  		
		  		<div class="row border">
		  			<div class="col-4">Contumacia</div>
		  			<div class="col">{{ $response->contumacia->resumo->{'quantidade-total'} or '0' }}</div>
		  		</div>
		  		<div class="row border">
		  			<div class="col-4">Judiciario</div>
		  			<div class="col">{{ $response->{'informacao-poder-judiciario'}->resumo->{'quantidade-total'} or '0' }}</div>
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