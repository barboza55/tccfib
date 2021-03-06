<?php

namespace App\Http\Controllers;

use App\Sian;
use App\Conta;
use SoapClient;
use SoapHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UserPassword;

class SianController extends Controller
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->middleware(['auth', 'clearance']);
        $this->request = $request;
    }
    public function index()
    {
        $user_id = Auth::id();
        $userpassword = UserPassword::where('user_id', $user_id)->first();
        $sian = new Sian();
        //$sian->clearCoockie();
        $sian->connect($userpassword->user, $userpassword->password);
    	
        
    	//$orders = $sian->getOrders('http://aneethun-sian.com.br/app?page=pages%2Fsale%2FSaleOrderAnalysisOrderList&service=page');
    	$fullOrders = $sian->getOrders();
    	//$elements = $sian->getHiddenSian('http://aneethun-sian.com.br/app?page=pages%2Ffinance%2FBillToReceiveList&service=page', 'filterForm');
    	//$elements = $sian->getHiddenSian('http://aneethun-sian.com.br/app?component=edit&page=pages%2Fsale%2FSaleOrderAnalysisOrderList&service=direct&session=T&sp=167421','form');
    	//$sian->getPendencia('http://aneethun-sian.com.br/app?component=edit&page=pages%2Fsale%2FSaleOrderAnalysisOrderList&service=direct&session=T&sp=167358');
    	/*foreach($elements as $key => $value)
    	{
    		echo 'Chave: ' . $key . '<br>Valor: ' . $value . '<br><br>';
    	}*/
        //dd($fullOrders);
        $cidades = [
            'Araraquara',
            'Cafelandia',
            'Marilia',
            'Palmital',
        ];
        
        /*foreach($fullOrders as $key => $pedido)
        {
            if(in_array($pedido['cidade'], $cidades)) continue;

            unset($fullOrders[$key]);
        }*/

        //dd($fullOrders);
    	return view('sian.index', compact('fullOrders'));
    	
    }

    public function find($id)
    {
        $sian = new Sian();
        $filtros = [
            'filterClientCode' => $id
        ];
        $pedidosTransito = $sian->findPedidos($filtros);
    }

    public function editPedido($id)
    {
        
    }

    public function analisar($idPedido, $status = 'nada')
    {
    	$sian = new Sian();
        $user_id = Auth::id();
        $userpassword = UserPassword::where('user_id', $user_id)->first();
        $sian = new Sian();
        //$sian->clearCoockie();
        //$sian->connect($userpassword->user, $userpassword->password);

    	$pedido = $sian->getOptions($idPedido, $status);

    	$customer = $sian->getCustomerData($pedido['customer_id']);
        $customer['combos'] = $sian->promoRepo($pedido['customer_id'], $pedido['itens'], $pedido['valor']);
    	$pedidos = $sian->getVendas($pedido['customer_id']);
        $dataInicio = '01/' . date('m/Y');
        $dataFim = date('t/m/Y');
        $filtros = [
            'filterClientCode'  => $pedido['customer_id'],
            'input_0'  => $dataInicio,
            'input_1'  => $dataFim,
        ];
        
        $dados = [];
        $dados['clientCodeOrName'] = $pedido['customer_id'];
    	$contas = $sian->getContas($dados, '1');

        $pedidosTransito = $sian->findPedidos($filtros);

        //$filtros = 
        //dd($pedidosTransito);
        /*
        Opcoes para alerta de produtos
    	foreach($pedido['itens'] as $item)
        {
            if($item['product_id'] == 184)
                $pedido['privateObs'] = 'Up curl ' . $pedido['privateObs'];
                
            
            if($item['product_id'] == 1)
                $pedido['privateObs'] = 'Cr sil ' . $pedido['privateObs'];
           
            if($item['product_id'] == 136)
                $pedido['privateObs'] = 'Sh sil ' . $pedido['privateObs'];
            
        }*/
        //dd($pedidosTransito);
    	$recebidas = $sian->getContas($dados, '2', TRUE);
    	return view('sian.analisar', compact('pedido', 'customer', 'pedidos', 'contas', 'recebidas', 'pedidosTransito'));
    }

    public function aproveOrder(Request $request, $status = 'nada')
    {
        $user_id = Auth::id();
        $userpassword = UserPassword::where('user_id', $user_id)->first();
    	$sian = new Sian();
        //$sian->clearCoockie();
        //$sian->connect($userpassword->user, $userpassword->password);
        $data = $request->all();
        
        if($data['action'] == 'aprove')
        {
            $post = $sian->postAnalise($data['codigo']);
        }
        elseif($data['action'] == 'cancel')
        {
            $post = $sian->postCancel($data['codigo']);
        }
        elseif($data['action'] == 'save')
        {
            $post = $sian->postSave($data['codigo']);
        }
        else
        {
            return redirect(url('sian'));
        }
        //dd($data);
        
        
        //dd($post);
        $post['publicObs'] = utf8_decode($data['obs']);
        $post['privateObs'] = utf8_decode($data['obsP']);
        $post['input'] = $data['fpagto'];
        //dd($post);

        $postQuery = $sian->buildPostQuery($post);
        //dd($postQuery);
    	$sian->aproveOrder($postQuery);
        if($data['action'] == 'save')
        {
            return redirect(route('sian', ['id' => $data['codigo']]));
        }
    	return redirect(url('sian'));
    }

    public function cancelOrder(Request $request)
    {
        $sian = new Sian();
        $data = $request->all();
        //dd($data);
        $post = $sian->postCancel($data['codigo']);
        $post['publicObs'] = utf8_decode($data['obs']);
        $post['privateObs'] = utf8_decode($data['obsP']);

        $post['input'] = $data['fpagto'];
        //dd($post);
        $postQuery = $sian->buildPostQuery($post);
        $sian->aproveOrder($postQuery);
        return redirect(url('sian'));
    }

    public function isentar(Request $request)
    {
        $request->flash();
        $data = $request->all();
        $pedido_id = $data['pedido_id'];
        $operacao = $data['operacao'];
        $sian = new Sian();
        //$sian->localizaPedido();
        $sian->getBoletos($pedido_id, $operacao);
        return redirect('boleto')->withInput();
    }

    public function boleto()
    {
        $user_id = Auth::id();
        $userpassword = UserPassword::where('user_id', $user_id)->first();
        $sian = new Sian();
        //$sian->clearCoockie();
        $sian->connect($userpassword->user, $userpassword->password);
        
        //echo '01/' . date('m/Y') . '<br>' . date('t/m/Y');
        return view('sian.boleto');
    }

    public function apagar(Request $request)
    {
        try {
            //$username = '2122539';
            //$password = '20180822';
            $password = '10082018';
            $username = '398950';
            

            $opts = array(
                'https' => array(
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                    
                    'user_agent' => 'PHPSoapClient',

                ),
                'ssl' => [
                        'allow_self_signed' => true,
                    ]
            );

            $context = stream_context_create($opts);

            //$wsdlUrl = 'https://servicos.spc.org.br/spc/remoting/ws/consulta/consultaWebService?wsdl';
            $wsdlUrl = 'https://treina.spc.org.br/spc/remoting/ws/consulta/consultaWebService?wsdl';
            
            $soapClientOptions = array(
                'soap_version'=>SOAP_1_1,
                'stream_context' => $context,
                'cache_wsdl' => WSDL_CACHE_NONE,
                
                'login' => $username,
                'password' => $password
            );

            $client = new SoapClient($wsdlUrl, $soapClientOptions);
            

            $parametros = new \stdClass;
            //$parametros->{'codigo-produto'} = '240';
            $parametros->{'codigo-produto'} = '333';
            if ($request->exists('cpf')) {
                $documento = $request->input('cpf');
                $parametros->{'tipo-consumidor'} = 'F';
            }elseif ($request->exists('cnpj')) {
                $documento = $request->input('cnpj');
                $parametros->{'tipo-consumidor'} = 'J';
            }

            $documento = str_replace(".","", $documento);
            $documento = str_replace("-","", $documento);
            $documento = str_replace("/","", $documento);
            $parametros->{'documento-consumidor'} = $documento;
            $name = $request->input('name');

            $response = $client->consultar($parametros);
            $codigo = $request->input('codigo');

            $protocolo = $codigo . 'Protocolo' . $response->protocolo->numero . '-' . $response->protocolo->digito;
            $dados_json = json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            $fp = fopen("consulta/".$protocolo."consulta.json", "w");
            $escreve = fwrite($fp, $dados_json);
            fclose($fp);    
        }
        catch(Exception $e) {
            echo $e->getMessage();
        }
 
        
        //return view('sian.spc-response', compact('response', 'name'));
        return view('sian.spc-response-cnpj', compact('response', 'name'));
    }

    public function sugestaoCompra()
    {
        $user_id = Auth::id();
        $userpassword = UserPassword::where('user_id', $user_id)->first();
        $sian = new Sian();
        //$sian->clearCoockie();
        $sian->connect($userpassword->user, $userpassword->password);
        $lista = $sian->sugestaoCompra();
        return view('sian.sugestao', compact('lista'));
    }

    public function editar($id)
    {
        $user_id = Auth::id();
        $userpassword = UserPassword::where('user_id', $user_id)->first();
        $sian = new Sian();
        //$sian->clearCoockie();
        //$sian->connect($userpassword->user, $userpassword->password);
    
        $request = $this->request->all();
        //dd($request);
        $lista = $sian->editarPedido($id);
        return redirect(route('sian', $id));
    }
     public function comparativo(Request $request){
        $user_id = Auth::id();
        $userpassword = UserPassword::where('user_id', $user_id)->first();
        $sian = new Sian();
        //$sian->clearCoockie();
        $sian->connect($userpassword->user, $userpassword->password);
        
        //echo Auth::user()->sian_user;
        //echo $request->method;
        //dd($request);
        $request->flash();
        $tabela = $sian->comparativo($request);
        if($request->isMethod('post')){
            $client = $request->input('cliente_id') ? $request->input('cliente_id') : '';
            //$customer = $sian->getCustomerData($client);
        }elseif($request->isMethod('get')){
            $form['client'] = '';
        }
        
        //dd($form);
        $data = 1;
        
        return view('sian.comparativo', compact('tabela', 'data'));
     }

     

     





    

    
}
