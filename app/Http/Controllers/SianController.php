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
    	$sian = new Sian();
    	$sian->connect('17165', 'porquesou10');
        
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
        $sian->clearCoockie();
        $sian->connect($userpassword->user, $userpassword->password);
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
        $sian = new Sian();
        $sian->connect('17165', 'porquesou10');
        //echo '01/' . date('m/Y') . '<br>' . date('t/m/Y');
        return view('sian.boleto');
    }

    public function apagar()
    {
        $pedidos = [
            '169533',
            '169545',
            '169562',
            '169578',
            '169580',
            '169582',
            '169584',
            '169587',
            '169589',
            '169591',
            '169593',
            '169595',
            '169606',
            '169610',
            '169114',
            '169208',
            '169357',
            '169370',
            '169376',
            '169384',
            '169460',
            '169467',
            '169468',
            '169480',
            '169504',
            '169508'

        ];
        /*$sian = new Sian();
        foreach($pedidos as $idPedido)
        {
            $pedido = $sian->getOptions($idPedido);
            foreach($pedido['itens'] as $item)
            {
                if($item['product_id'] == '120')
                {
                    echo $pedido['codigo'] . '<br>';
                }
            }
        }*/


        //https://homologacao.spc.org.br/spc/remoting/ws/consulta/buscaWebService?wsdl
        
        //$Webservice = 'https://servicos.spc.org.br/spc/remoting/ws/consulta/consultaWebService?wsdl';
        //$Webservice = 'https://treina.spc.org.br/spc/remoting/ws/consulta/consultaEntidadeReplicadaWebService?wsdl';
        $Webservice = 'http://horusws.treinamento.saude.gov.br/horus-ws-service/HorusWSService/HorusWS?wsdl';
        $username = '91570082';
        $password = 'lima07ab';
        $auth =  'Basic ' . base64_encode($username . ':' . $password);
        
        
        //$auth = 'Basic ' . base64_encode($username . ':' . $password);
        $options = [
            'Authorization' => $auth
        ];
        
        $client = new \SoapClient($Webservice, $options);
        $functions = $client->__getFunctions();
        print_r($functions);
        //$header = "Authorization: Basic " . base64_encode($username . ':' . $password);
        //$client->__setSoapHeaders($header);

       /* $auth = array(
                'UserName'=>'USERNAME',
                'Password'=>'PASSWORD',
                'SystemId'=> array('_'=>'DATA','Param'=>'PARAM'),
        );
        $header = new \SoapHeader('NAMESPACE','Auth',$auth,false);
        $client->__setSoapHeaders($header);*/
        //dd($header);
        //return view('sian.apagar');
    }

    public function sugestaoCompra()
    {
        $sian = new Sian();
        $sian->connect('caxias', 'lu291205');
        $lista = $sian->sugestaoCompra();
        return view('sian.sugestao', compact('lista'));
    }

    public function editar($id)
    {
        $sian = new Sian();
        $sian->connect('17165', 'porquesou10');
        $request = $this->request->all();
        //dd($request);
        $lista = $sian->editarPedido($id);
        return redirect(route('sian', $id));
    }
     public function comparativo(Request $request){
        $sian = new Sian();
        $user = Auth::user()->sian_user;
        $pass = Auth::user()->sian_pass;
        $sian->connect('17165', 'porquesou10');
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
