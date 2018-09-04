@extends('layouts.app')
@section('content')
	
	<div id="listagem-spc">
	  <div class="card">
	    <div class="card-header" id="header-spc">
	      <h5 class="mb-0">
	        <button class="btn btn-danger" data-toggle="collapse" data-target="#collapse-spc" aria-expanded="false" aria-controls="collapse-spc">
	          SPC - {{ $response->spc->resumo->{'quantidade-total'} or 0}}
	          - Total: R$ {{ $response->spc->resumo->{'valor-total'} or 0,00 }}
	        </button>
	      </h5>
	    </div>

	    <div id="collapse-spc" class="collapse" aria-labelledby="header-spc" data-parent="#listagem-spc">
	      <div class="card-body">
	        <div class="row">
	        	<div class="col">Credor</div>
	        	<div class="col">Valor</div>
	        	<div class="col">Tipo</div>
	        	<div class="col">Data Inclusão</div>
	        </div>
	        @if(property_exists($response->spc, 'detalhe-spc'))
	        @if(is_array($response->spc->{'detalhe-spc'}))
	        		@foreach($response->spc->{'detalhe-spc'} as $detalhe)
					<div class="row">
						<div class="col">{{ $detalhe->{'nome-associado'} }}</div>
						<div class="col">{{ $detalhe->valor }}</div>
						<div class="col">{{ $detalhe->{'comprador-fiador-avalista'} }}</div>
						<div class="col">{{ $detalhe->{'data-inclusao'} }}</div>
					</div>
					@endforeach
	        	@else
	        	<div class="row">
					<div class="col">{{ $response->spc->{'detalhe-spc'}->{'nome-associado'} }}</div>
					<div class="col">{{ $response->spc->{'detalhe-spc'}->valor }}</div>
					<div class="col">{{ $response->spc->{'detalhe-spc'}->{'comprador-fiador-avalista'} }}</div>
					<div class="col">{{ $response->spc->{'detalhe-spc'}->{'data-inclusao'} }}</div>
				</div>
	        	@endif
	        @else
	        <p>Sem registros.</p>
	        @endif
	        	
	        	
				
				
	        	
	        
	      </div>
	    </div>
	  </div>


	  <div class="card">
	    <div class="card-header" id="header-contra-ordem-d">
	      <h5 class="mb-0">
	        <button class="btn btn-danger collapsed" data-toggle="collapse" data-target="#collapseContraD" aria-expanded="false" aria-controls="collapseContraD">
	          Contra Ordem Documento Diferente - {{ $response->{'contra-ordem-documento-diferente'}->resumo->{'quantidade-total'} or 0}}
	          - Última ocorrência: {{ $response->{'contra-ordem-documento-diferente'}->resumo->{'data-ultima-ocorrencia'} or '-' }}
	        </button>
	      </h5>
	    </div>
	    <div id="collapseContraD" class="collapse" aria-labelledby="header-contra-ordem-d" data-parent="#listagem-spc">
	      <div class="card-body">
	        <div class="row">
	        	<div class="col">Cheque início/fim</div>
	        	<div class="col">Banco</div>
	        	<div class="col">Motivo</div>
	        	<div class="col">Data Inclusão</div>
	        </div>
	        @if(property_exists($response->{'contra-ordem-documento-diferente'}, 'detalhe-contra-ordem-documento-diferente'))
	        @if(is_array($response->{'contra-ordem-documento-diferente'}->{'detalhe-contra-ordem-documento-diferente'}))
	        		@foreach($response->{'contra-ordem-documento-diferente'}->{'detalhe-contra-ordem-documento-diferente'} as $detalhe)
					<div class="row">
						<div class="col">{{ $detalhe->{'cheque-inicial'}->numero.'/'.$detalhe->{'cheque-final'}->numero }}</div>
						<div class="col">{{ $detalhe->{'dados-bancarios'}->banco->nome }}</div>
						<div class="col">{{ $detalhe->motivo->codigo }}</div>
						<div class="col">{{ $detalhe->{'data-inclusao'} }}</div>
					</div>
					@endforeach
	        	@else
	        	<div class="row">
					<div class="col">{{ $response->{'contra-ordem-documento-diferente'}->{'detalhe-contra-ordem-documento-diferente'}->{'cheque-inicial'}->numero .'/'.$response->{'contra-ordem-documento-diferente'}->{'detalhe-contra-ordem-documento-diferente'}->{'cheque-final'}->numero }}</div>
					<div class="col">{{ $response->{'contra-ordem-documento-diferente'}->{'detalhe-contra-ordem-documento-diferente'}->{'cheque-inicial'}->{'dados-bancarios'}->banco->nome }}</div>
					<div class="col">{{ $response->{'contra-ordem-documento-diferente'}->{'detalhe-contra-ordem-documento-diferente'}->motivo->codigo }}</div>
					<div class="col">{{ $response->{'contra-ordem-documento-diferente'}->{'detalhe-contra-ordem-documento-diferente'}->{'data-inclusao'} }}</div>
				</div>
	        	@endif
	        @else
	        <p>Sem registros.</p>
	        @endif
	      </div>
	    </div>
	  </div>
	  <div class="card">
	    <div class="card-header" id="headingThree">
	      <h5 class="mb-0">
	        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
	          Collapsible Group Item #3
	        </button>
	      </h5>
	    </div>
	    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#listagem-spc">
	      <div class="card-body">
	        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
	      </div>
	    </div>
	  </div>
	</div>
		
@endsection