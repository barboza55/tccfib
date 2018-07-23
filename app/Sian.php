<?php

namespace App;
ini_set('max_execution_time', 3000);
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Sian extends Model
{
    private $cookie_file;// = dirname(__FILE__).'\\';
    private $dom;
    private $liberadoTaxa = [
        //99999999,
        6,
        2431,
        5348,
        7544,
        3968,
        5081,
        770

    ];
    private $homecare = [
        150, 125, 117, 128, 154, 155, 156,
        181, 182, 183, 184, 185,
        129, 130, 131,
        171, 172, 173, 174, 175,
        178, 179, 180, 177,
        91, 93, 94,
        136, 1, 4, 162, 2, 6, 37,
        159, 160, 161, 157, 158,
        109, 140, 111, 106, 107, 108,
        88, 152, 153, 135, 87, 119, 134, 151,
        89, 66, 137, 64, 62, 63, 65,
        69, 142, 127, 22, 24, 26, 70, 138, 72,
        73, 139, 76,
        176, 90, 133, 51, 50, 102, 45, 47,
        191, 166, 164, 165,
        147, 143, 144, 148, 146, 149, 189, 190, 145,
        186, 187, 188
    ];
    public function __construct()
    {
        $this->cookie_file = dirname(__FILE__).'/cookie.txt';
        //dd($this->cookie_file);
    }
    public function connect($login, $password, $response = TRUE)
    {
    	$unidade = 'bauru';
		$site = "http://aneethun-sian.com.br/app";
		$datapost = [
			'formids' => 'Hidden,login,password',
			'component' => 'form',
			'page' => 'pages/Login',
			'service' => 'direct',
			'submitmode' => 'submit',
			'submitname' => '',
			'Hidden' => 'X',
			'login' => $login,
			'password' => $password
		];
		$post = curl_init();
		$headers = array("Expect:");
		curl_setopt($post, CURLOPT_URL, $site);
		curl_setopt($post, CURLOPT_TIMEOUT, 40000);
		curl_setopt($post, CURLOPT_HEADER, FALSE);
		curl_setopt($post, CURLOPT_RETURNTRANSFER, $response);
		curl_setopt($post, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
		curl_setopt($post, CURLOPT_POST, TRUE);
		curl_setopt($post, CURLOPT_POSTFIELDS, $datapost);
		curl_setopt($post, CURLOPT_COOKIEJAR, $this->cookie_file);
        curl_setopt($post, CURLOPT_COOKIEFILE, $this->cookie_file);
		$error = curl_error($post);
		curl_exec($post);
		curl_close($post);
    }

    /**
     *
     *@param $dom
     *@param $idForm
     *
    */
    public function getHiddenSian($url, $idForm)
    {
        $fields = [];
        $this->setDomDocument($url);
        $form = $this->dom->getElementById($idForm);
        $elements = $form->getElementsByTagName('input');
        $selects = $this->dom->getElementsByTagName('select');
        foreach($selects as $select)
        {
            $name = $select->getAttribute('name');
            $options = $select->getElementsByTagName('option');
            foreach($options as $option)
            {
                if($option->hasAttribute('selected'))
                {
                    $value = $option->getAttribute('value');
                    $fields[$name] = $value;
                }
            }
        }
        $textareas = $this->dom->getElementsByTagName('textarea');
        if($textareas->length >= 1)
        {
            foreach($textareas as $textarea)
            {
                $fields[$textarea->getAttribute('name')] = $textarea->textContent;
            }
            
        }
        
        
        
        foreach($elements as $element)
        {
            if(!$element->hasAttribute('name')) continue;
            $name = $element->getAttribute('name');
            $value = $element->getAttribute('value');
            $fields[$name] = $value;
        }
        return $fields;
    }

    private function setDomDocument($url, $response = TRUE, $flag = FALSE, $datapost = null)
    {
        //$response = FALSE;
    	$unidade = 'bauru';
    	$login = '17165';
    	$post = curl_init();
		$headers = array("Expect:");
		curl_setopt($post, CURLOPT_URL, $url);
		curl_setopt($post, CURLOPT_TIMEOUT, 40000);
		curl_setopt($post, CURLOPT_HEADER, FALSE);
		curl_setopt($post, CURLOPT_RETURNTRANSFER, $response);
		//curl_setopt($post, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($post, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
        if($flag)
        {
            curl_setopt($post, CURLOPT_POST, TRUE);
            curl_setopt($post, CURLOPT_POSTFIELDS, $datapost);
        }
        else
        {
            curl_setopt($post, CURLOPT_POST, FALSE);
        }
		//dd($this->cookie_file);
		curl_setopt($post, CURLOPT_COOKIEFILE, $this->cookie_file);
		//$error = curl_error($post);
		$html = curl_exec($post);
		$dom = new \DOMDocument();
        @$dom->loadHTML($html);
		curl_close($post);
        $this->dom = $dom;

    }

    private function getAnaliseList($dom)
    {
    	
    	$xpath = new \DOMXpath($dom);
    	return $xpath->query("//tr[@class='even' or @class='odd' or @class='background-red']");
    }

    public function getPendencia()
    {
        $counter = 0;
        $xpath = new \DOMXpath($this->dom);
        $tabela = $xpath->query("//table[@class='list-table']")->item(1);
        if($tabela)
        {

            $trs = $tabela->getElementsByTagName('tr');
            foreach($trs as $tr)
            {
                if($tr->getAttribute('class') == 'background-red' or $tr->getAttribute('class') == 'background-orange') $counter++;
            }
        }
        else
        {
            return $counter;
        }
        return $counter;
    }

    public function getOrders()
    {
        $url = 'http://aneethun-sian.com.br/app?page=pages/sale/SaleOrderAnalysisOrderList&service=page';
        //dd($url);
        $post = $this->getHiddenSian($url, 'filterForm');
        unset($post['Submit_0']);
        unset($post['saleOrderStatus']);
        $post['filterMaxResults_'] = 100;
        $post['RadioGroup'] = 0;
        //dd($post);
        $url = 'http://aneethun-sian.com.br/app';
        $this->setDomDocument($url, TRUE, TRUE, $post);
    	$orders = [];
    	$trs = $this->getAnaliseList($this->dom);
    	foreach($trs as $tr)
    	{
            $pedido['id'] = trim($tr->getElementsByTagName('td')[0]->textContent);
            $pedido['dataCad'] = trim($tr->getElementsByTagName('td')[1]->textContent);
            $pedido['nome'] = trim($tr->getElementsByTagName('td')[2]->textContent);
            $pedido['cidade'] = trim($tr->getElementsByTagName('td')[4]->textContent);
            $pedido['total'] = trim($tr->getElementsByTagName('td')[7]->textContent);
            $pedido['statuscliente'] = trim($tr->getElementsByTagName('td')[2]->getElementsByTagName('span')[0]->getAttribute('class'));
    		$orders[] = $pedido;
    	}
    	return $orders;
    }



    public function getOptions($order)
    {
    	//foreach($orders as $order)
    	//{
    		$pedido = [];
    		$pedido['codigo'] = $order;
    		$url = "http://aneethun-sian.com.br/app?component=edit_&page=pages%2Fsale%2FSaleOrderAnalysisOrderList&service=direct&session=T&sp=" . $order;
    		
    		$this->setDomDocument($url);
    		$xpath = new \DOMXpath($this->dom);
            $tabelaItens = $xpath->query("//table[@class='list-table']")->item(0);
            $pedido['valor'] = $xpath->query("//td[@class='largeText color-blue']/strong")->item(0)->textContent;
            $options = $xpath->query("//select[@id='input']/option");
            $vendedor = $xpath->query("//select[@id='input']")->item(0)->parentNode->nextSibling->nextSibling->textContent;
            $vendedor = str_replace("\n", "", $vendedor);  
            //$vendedor = str_replace(" ", "", $vendedor);  
            $vendedor = trim(str_replace("Consultor", "", $vendedor));  
            $pedido['vendedor'] = $vendedor;
            $opts = [];
            foreach($options as $option)
            {
                $opt = [];
                $opt['selected'] = FALSE;
                if($option->hasAttribute('selected'))
                {
                    $opt['selected'] = TRUE;
                }
                $opt['value'] = $option->getAttribute('value');
                $opt['text'] = $option->textContent;
                $opts[] = $opt;
            }
            $pedido['opts'] = $opts;
            $pedido['totalhomecare'] = 0;
            $pedido['podes'] = false;
            $linhas = $tabelaItens->getElementsByTagName('tr');
            $itens = [];
            foreach($linhas as $linha)
            {
                if($linha->getElementsByTagName('td')->length >=1 )
                {
                    if($linha->getAttribute('class') == 'even' || $linha->getAttribute('class') == 'odd')
                    {
                        $item = [];
                        $item['grupo'] = FALSE;
                        $item['namegrupo'] = '-';
                        $item['product_id'] = (int) $linha->getElementsByTagName('td')[0]->textContent;
                        $totalItem = $linha->getElementsByTagName('td')[4]->textContent;
                        $totalItem = str_replace('.', '', $totalItem);
                        $totalItem = (float) str_replace(',', '.', $totalItem);

                        if(in_array($item['product_id'], $this->homecare)) $pedido['totalhomecare'] += $totalItem;
                        if($item['product_id'] == 192) $pedido['podes'] = true;
                        $item['product_name'] = $linha->getElementsByTagName('td')[1]->textContent;
                        $item['amount'] = (int) $linha->getElementsByTagName('td')[2]->textContent;
                        $item['style'] = '';
                        $itens[] = $item;
                    }
                    else
                    {
                        $item = [];
                        $item['grupo'] = TRUE;
                        $item['namegrupo'] = $linha->getElementsByTagName('td')[0]->textContent;;
                        $item['style'] = $linha->getAttribute('style');
                        $item['product_id'] = 0;
                        $item['product_name'] = '-';
                        $item['amount'] = 0;
                        $itens[] = $item;
                    }
                    
                }
            }
            $pedido['itens'] = $itens;
            $obsPub = $this->dom->getElementById('publicObs')->getAttribute('value');
            $obsPriv = $this->dom->getElementById('privateObs')->getAttribute('value');
            $pedido['publicObs'] = $obsPub;
            $pedido['privateObs'] = $obsPriv;
    		$div = $xpath->query("//div[@class='grid-data']")->item(0);
            $pedido['customer_id'] = trim($div->getElementsByTagName('tr')[0]->getElementsByTagName('td')[0]->getElementsByTagName('span')[0]->textContent);
            //$clienteFields = getCustomerData($pedido['customer_id'])
    		$pedido['cidade'] = $div->getElementsByTagName('tr')[1]->getElementsByTagName('td')[2]->textContent;
    		$pedido['nome'] = $div->getElementsByTagName('tr')[0]->getElementsByTagName('td')[1]->textContent;
            $pedido['statuscliente'] = $div->getElementsByTagName('tr')[0]->getElementsByTagName('td')[0]->getElementsByTagName('img')[0]->getAttribute('title');
            $pedido['contas'] = $this->getPendencia();

    		//dd($options);
    		//echo $dom;
    		
    		$options = $this->dom->getElementById('input')->getElementsByTagName('option');
			foreach ($options as $option)
			{
    			//var_dump($option);
				if ($option->getAttribute('selected'))
				{
					$pedido['formapagamento'] = $option->textContent;
					break;
				}
			}
			
    	//}
    	return $pedido;
    }

    public function getCustomerData($id)
    {
        $url = 'http://aneethun-sian.com.br/app?component=edit_&page=pages%2Frecord%2FClientRecordList&service=direct&session=T&sp=' . $id;
        $customerData = $this->getHiddenSian($url, 'form');
        $url = 'http://aneethun-sian.com.br/app?component=%24partials%24ClientTabs.%24PageTabs.changePage&page=pages%2Fclient%2FClientSalesHistory&service=direct&sp=4&sp='. $id .'&sp=X';
        $this->setDomDocument($url);
        $xpath = new \DOMXpath($this->dom);
        $tabela = $xpath->query("//table[@class='list-table']")->item(1);
        if($tabela){
            $customerData['relacionamento'] = true;
            $customerData['relacionamentoData'] = [];
            $trs = $tabela->getElementsByTagName('tbody')[0]->getElementsByTagName('tr');
            foreach ($trs as $key => $tr) {
                $linha = [];
                $linha['data'] = trim($tr->getElementsByTagName('td')[2]->firstChild->textContent);
                $linha['contato'] = trim($tr->getElementsByTagName('td')[3]->textContent);
                $linha['obs'] = trim($tr->getElementsByTagName('td')[4]->textContent);
                //dd($linha['obs']);
                $customerData['relacionamentoData'][] = $linha;
            }
        }else{
            $customerData['relacionamento'] = false;
        }
        return $customerData;
    }

    public function getVendas($id)
    {
        $pedidos = [];

        $url = 'http://aneethun-sian.com.br/app?component=%24partials%24ClientTabs.%24PageTabs.changePage&page=pages%2Frecord%2FClientRecordEdit&service=direct&sp=1&sp=' . $id .'&sp=X';
        
        $this->setDomDocument($url);
        $xpath = new \DOMXpath($this->dom);
        $tabela = $xpath->query("//table[@class='list-table']")->item(0);
        if($tabela)
        {
            $trs = $tabela->getElementsByTagName('tr');
           
            foreach($trs as $tr)
            {
                
                if($tr->getElementsByTagName('td')->length >= 1)
                {
                    $pedido = [];
                    
                    
                    $pedido['id'] = trim($tr->getElementsByTagName('td')[0]->firstChild->textContent);
                    $pedido['data'] = trim($tr->getElementsByTagName('td')[2]->firstChild->textContent);
                    $pedido['formapagamento'] = $tr->getElementsByTagName('td')[4]->textContent;
                    $pedido['total'] = $tr->getElementsByTagName('td')[7]->textContent;
                    $pedidos[] = $pedido;
                }
                
            }
            return $pedidos;
        }
    }

    public function findPedidos($filtros)
    {
        $pedidos = [];

        $url = 'http://aneethun-sian.com.br/app?page=pages%2Fsale%2FSaleOrderSearch&service=page';
        
        
        $post = $this->getHiddenSian($url, 'filterForm');
        unset($post['Submit_0']);
        $post['submitmode'] = 'submit';
        //$post['input_0'] = '';
        $post['input_0'] = '01/' . date('m/Y');
        $post['input_1'] = date('t/m/Y');
        //$post['input_1'] = '';
        $post['filterClientCode'] = $filtros['filterClientCode'];
        $url = 'http://aneethun-sian.com.br/app';
        $this->setDomDocument($url, TRUE, TRUE, $post);
        $xpath = new \DOMXpath($this->dom);

        //echo $xpath->query("//div[@id='bd']/h3")->length;
        $h3 = $xpath->query("//div[@id='bd']/h3");
        //echo $xpath->query("//div[@id='bd']/table")->length;
        $table = $xpath->query("//div[@id='bd']/table");
        $pedidos = [];
        foreach($h3 as $key => $value)
        {
            if($value->getElementsByTagName('a')->item(0))
            {
                $status = trim($value->getElementsByTagName('a')->item(0)->textContent);
                $trs = $table->item($key)->getElementsByTagName('tr');
            }
            else
            {
                $status = trim($value->textContent);
                $trs = $table->item($key)->getElementsByTagName('tr');
            }
            foreach($trs as $tr)
            {
                
                if($tr->getElementsByTagName('td')->length >= 1)
                {
                    $pedido = [];
                    
                    
                    $pedido['id'] = trim($tr->getElementsByTagName('td')[0]->firstChild->textContent);
                    $pedido['data'] = trim($tr->getElementsByTagName('td')[1]->firstChild->textContent);
                    $pedido['status'] = $status;
                    $pedido['total'] = trim($tr->getElementsByTagName('td')[7]->textContent);
                    $pedidos[] = $pedido;
                }
                
            }
            
        }
        
        
        
        //$tabela = $xpath->query("//table[@class='sortable list-table']")->item(0);
        
        
        //dd($tabela);
        

        return $pedidos;
    }

    public function getContas($fields, $flag = FALSE)
    {
        $url = 'http://aneethun-sian.com.br/app?page=pages%2Ffinance%2FBillToReceiveList&service=page';
        $post = $this->getHiddenSian($url, 'filterForm');
        if($flag)
        {
            $url = 'http://aneethun-sian.com.br/app?component=filter.received1&page=pages%2Ffinance%2FBillToReceiveList&service=direct&session=T&sp=2';
        }
        else
        {
            $url = 'http://aneethun-sian.com.br/app?component=filter.toReceive2&page=pages%2Ffinance%2FBillToReceiveList&service=direct&session=T&sp=1';
        }
        $this->setDomDocument($url);
        unset($post['Submit_0']);
        unset($post['showingOnlyProblemBills']);
        $url = 'http://aneethun-sian.com.br/app';
        $post['billToReceiveDate'] = '0';
        $post['clientCodeOrName'] = '';
        foreach($fields as $key => $value)
        {
            $post[$key] = $value;
        }

        //$post['clientCodeOrName'] = $id;
        $post['modeOfPaymentType'] = 0;
        $post['submitmode'] = 'submit';
        $contas = [];
        /*$tiposPagtos = [1,2,3,4,5];
        foreach($tiposPagtos as $tipo)
        {
            $post['modeOfPaymentType'] = $tipo;
        }*/

        $this->setDomDocument($url, TRUE, TRUE, $post);
        $xpath = new \DOMXpath($this->dom);
        $tabela = $xpath->query("//table[@class='list-table']")->item(0);
        if($tabela)
        {
            $trs = $tabela->getElementsByTagName('tr');
           
            foreach($trs as $tr)
            {
                
                if($tr->getElementsByTagName('td')->length >= 1)
                {
                    $pedido = [];
                    
                    if($flag)
                    {
                        $pedido['datavencto'] = trim($tr->getElementsByTagName('td')[6]->textContent);
                        $pedido['datapagto'] = trim($tr->getElementsByTagName('td')[7]->textContent);
                        
                        //$dateobj = \DateTime::createFromFormat($format, $pedido['datapagto']);
                        

                        
                        
                        //$diasem = jddayofweek($dateobj->getTimestamp(),1);
                        //dd($diasemana_numero);
                        $pedido['dif'] = $this->diffDatas($pedido['datavencto'], $pedido['datapagto']);
                        $pedido['semanapagto'] = $this->diaSemana($pedido['datapagto']);
                        $pedido['semanavencto'] = $this->diaSemana($pedido['datavencto']);
                        $pedido['formapagamento'] = $tr->getElementsByTagName('td')[4]->textContent;
                        $pedido['total'] = $tr->getElementsByTagName('td')[8]->textContent;
                        $contas[] = $pedido;
                    }
                    else
                    {
                        $pedido['data'] = trim($tr->getElementsByTagName('td')[7]->firstChild->textContent);
                        $pedido['diff'] = $this->diffDatas($pedido['data'], date('d/m/y'));
                        $pedido['formapagamento'] = trim($tr->getElementsByTagName('td')[5]->textContent);
                        $pedido['total'] = $tr->getElementsByTagName('td')[8]->textContent;
                        $contas[] = $pedido;
                    }
                    
                }
                
            }
            return $contas;
        }
    }

    private function formatarData($data)
    {
        $data = str_replace('/', '-', $data);
        $standarddate = "20" . substr($data,6,2) . "-" . substr($data,3,2) . "-" . substr($data,0,2);
        return $standarddate;
    }

    private function diffDatas($datavencto, $datapagto)
    {
        $datavencto = $this->formatarData($datavencto);
        $datapagto = $this->formatarData($datapagto);
        //$datavencto = date('Y-m-d', strtotime($datavencto));
        $datavencto = strtotime($datavencto);
        //$datapagto = date('Y-m-d', strtotime($datapagto));
        $datapagto = strtotime($datapagto);
        //$datavencto = new \DateTime($datavencto);
        //$datapagto = new \DateTime($datapagto);
        //$intervalo = $datapagto->diff($datavencto);
        if($datavencto > $datapagto)
        {
            $diferenca = $datavencto - $datapagto;
            $dias = (int)floor( $diferenca / (60 * 60 * 24));
            //return $intervalo->d . ' dias adiantado';
            return $dias . ' dias adiantado';
        }
        elseif($datavencto < $datapagto)
        {
            $diferenca = $datapagto - $datavencto;
            $dias = (int)floor( $diferenca / (60 * 60 * 24));
            return $dias . ' dias atrasado';
            //return $intervalo->d . ' dias atrasado';
        }

        
        return '0 dia';
    }

    private function diaSemana($data)
    {
        $nomes = [
            'Domingo',
            'Segunda-feira',
            'Terça-feira',
            'Quarta-feira',
            'Quinta-feira',
            'Sexta-feira',
            'Sábado'
        ];
        $standarddate = $this->formatarData($data);
        $date = date('w', strtotime($standarddate));

        return $nomes[$date];
    }

    public function buildPost($id)
    {
        $url = 'http://aneethun-sian.com.br/app?component=edit_&page=pages%2Fsale%2FSaleOrderAnalysisOrderList&service=direct&session=T&sp=' . $id;
        $post = $this->getFormAnalise($url, 'form');
        return $post;
    }

    public function aproveOrder($post)
    {
        $url = 'http://aneethun-sian.com.br/app';
        $this->setDomDocument($url, TRUE, TRUE, $post);
    }

    public function getFormAnalise($url, $idForm)
    {
        $fields = [];
        $this->setDomDocument($url);
        $form = $this->dom->getElementById($idForm);
        $elements = $form->getElementsByTagName('input');
        $selects = $this->dom->getElementsByTagName('select');
        foreach($selects as $select)
        {
            $name = $select->getAttribute('name');
            $options = $select->getElementsByTagName('option');
            foreach($options as $option)
            {
                if($option->hasAttribute('selected'))
                {
                    $value = $option->getAttribute('value');
                    $fields[$name] = $value;
                }
            }
        }
        $textareas = $this->dom->getElementsByTagName('textarea');
        if($textareas->length >= 1)
        {
            foreach($textareas as $textarea)
            {
                $fields[$textarea->getAttribute('name')] = $textarea->textContent;
            }
            
        }
        
        
        
        foreach($elements as $element)
        {
            if(!$element->hasAttribute('name')) continue;

            $name = $element->getAttribute('name');
            $value = $element->getAttribute('value');
            if($element->getAttribute('name') == 'For')
            {
                if(!array_key_exists($name, $fields))
                {
                    $fields[$name] = [];
                }
                $fields[$name][] = $value;
            }
            else
            {
                $fields[$name] = $value;
            }
            
            
        }
        
        return $fields;
    }


    public function postAnalise($id)
    {
        $fields = $this->buildPost($id);
        unset($fields['confirm_0']);
        unset($fields['campaign']);
        unset($fields['save']);
        unset($fields['edit']);
        $fields['submitmode'] = 'submit';
        return $fields;
    }

    public function postCancel($id)
    {
        $fields = $this->buildPost($id);
        $fields['confirm_0'] = "Cancelar";
        unset($fields['confirm']);
        unset($fields['campaign']);
        unset($fields['save']);
        unset($fields['edit']);
        $fields['submitmode'] = 'submit';
        $fields['msg'] = 'Cancelado por Luizinho.';
        return $fields;
    }

    public function postSave($id)
    {
         $fields = $this->buildPost($id);
         $fields['submitmode'] = 'submit';
         unset($fields['confirm']);
         unset($fields['confirm_0']);
         unset($fields['campaign']);
         unset($fields['edit']);
         return $fields;
    }

    public function buildPostQuery($array)
    {
        $string1 = http_build_query($array);
        $string2 = preg_replace("/%5B(.*?)%5D/","", $string1);
        $string2 = preg_replace("/%2C/",",", $string2);
        $string2 = preg_replace("/%2F/","/", $string2);
        return $string2;
    }

    public function promoPlex()
    {
        
    }

    private function operacao($value, $sinal)
    {
        $value = str_replace(".","", $value);
        $value = (double) str_replace(",",".", $value);
        if($sinal == '-')
        {
            $value -= 2.0;
        }
        elseif($sinal == '+')
        {
            $value += 2.0;
        }
        else
        {
            $value = $value;
        }
        
        $value = str_replace(".",",", $value);
        return $value;
    }

    public function tirarTaxa($conta_id, $sinal)
    {
        $url = 'http://aneethun-sian.com.br/app?component=edit&page=pages%2Fsale%2FBankSlipManagement&service=direct&session=T&sp='. $conta_id;
        $fields = $this->getHiddenSian($url, 'Form');
        $this->setDomDocument($url);
        $xpath = new \DOMXpath($this->dom);
        $codigo = (int) $xpath->query("//span[@class='code']")->item(0)->textContent;
        
        unset($fields['type']);
        unset($fields['confirm']);
        //dd($fields);
        $fields['Submit'] = 'Aguarde...';
        $fields['submitmode'] = 'submit';
        $fields['obs'] = utf8_decode($fields['obs']);
        $valor = $this->operacao($fields['value'], $sinal);
        $fields['value'] = $valor;
        //dd($fields['value']);
        $url = 'http://aneethun-sian.com.br/app';
        if(in_array($codigo, $this->liberadoTaxa))
        {
            $this->setDomDocument($url, TRUE, TRUE, $fields);
        }
        
    }

    public function getBoletos($pedido_id, $sinal)
    {
        $data = [
            'component' =>   'filter.filterForm',
            'filterBankSlipStatus'  =>    0,
            'filterBillToReceiveCode'   => '', 
            'filterClientNameOrCode'    => '',
            'filterSaleOrderCode'   => $pedido_id,
            'formids'   => 'filterBillToReceiveCode,filterSaleOrderCode,filterClientNameOrCode,filterBankSlipStatus,Submit,Submit_0',
            'page'  =>    'pages/sale/BankSlipManagement',
            'service'   => 'direct',
            'session'   => 'T',
            'Submit'    =>  'Filtrar',
            'submitmode'    =>  'submit',
            'submitname'    => ''
        ];
        $url = 'http://aneethun-sian.com.br/app';
        $this->setDomDocument($url, TRUE, TRUE, $data);
        $xpath = new \DOMXpath($this->dom);
        
        $lista = $xpath->query("//table[@class='list-table']/tbody/tr[@class='even' or @class='odd']");
        foreach($lista as $dadoscontas)
        {
            $conta;
            $conta = (int) $dadoscontas->getElementsByTagName('td')[0]->textContent;
            $this->tirarTaxa($conta, $sinal);
        }
        
    }

    public function consultaSerasa()
    {
        $url = 'https://sitenet05.serasa.com.br/LogonPersonalizado/sincovave/Logon.aspx';
    }

    public function localizaPedido()
    {
        $url = 'http://aneethun-sian.com.br/app?page=pages%2Fsale%2FSaleOrderSearch&service=page';
        $fields = $this->getHiddenSian($url, 'filterForm');
        $fields['submitmode'] = 'submit';
        unset($fields['Submit_0']);
        dd($fields);
    }

    public function sugestaoCompra()
    {

        $url = 'http://aneethun-sian.com.br/app?page=pages%2Fpurchase%2FSendPurchaseOrder&service=page';
        $this->setDomDocument($url);
        $trs = $this->getAnaliseList($this->dom);
        $lista1 = [];
        foreach($trs as $tr)
        {
            $item['nome'] = trim($tr->getElementsByTagName('td')[1]->getElementsByTagName('label')[0]->textContent);
            $item['caixa'] = (int) trim($tr->getElementsByTagName('td')[3]->textContent);
            //dd($item['nome']);
            $item['inputname'] = $tr->getElementsByTagName('td')[2]->getElementsByTagName('input')[0]->getAttribute('id');
            //dd($item['inputname']);
            $lista1[] = $item;
        }
        //dd($lista1);
        $url = 'http://aneethun-sian.com.br/app?page=pages%2Fpurchase%2FBufferSupply&service=page';
        $this->setDomDocument($url);
        $xpath = new \DOMXpath($this->dom);
        $tabelaItens = $xpath->query("//table[@class='list-table']")->item(0);
        $trs = $tabelaItens->getElementsByTagName('tr');
        $lista2 = [];
        foreach($trs as $tr)
        {
            if($tr->getElementsByTagName('td')->length >=1)
            {
                if($tr->getAttribute('class') == 'even' || $tr->getAttribute('class') == 'odd')
                {
                    $produto['nome'] = trim($tr->getElementsByTagName('td')[0]->getElementsByTagName('label')[0]->textContent);
                    //dd($produto['nome']);
                    foreach($lista1 as $item)
                    {
                        if($item['nome'] == $produto['nome'])
                        {
                            $produto['inputname'] = $item['inputname'];
                            $produto['caixa'] = $item['caixa'];
                            break;
                        }
                        else
                        {
                            $produto['inputname'] = 'fora de linha';
                            $produto['caixa'] = 1;
                        }
                    }
                    $produto['media'] = (int) str_replace('.', '',trim($tr->getElementsByTagName('td')[4]->textContent));
                    $produto['estoque'] = (int) str_replace('.', '',trim($tr->getElementsByTagName('td')[9]->textContent));
                    $produto['pordia'] = ceil($produto['media'] / 30);
                    $produto['precisa'] =  ceil(((ceil($produto['media'] / 30 * 43)) - $produto['estoque']) / $produto['caixa']);
                    $produto['grupo'] = FALSE;
                    $produto['nomegrupo'] = '';
                    $produto['style'] = '';
                    //$produto['nome'] = trim($tr->getElementsByTagName('td')[2]->textContent);
                    //$produto['cidade'] = trim($tr->getElementsByTagName('td')[4]->textContent);
                    //$produto['total'] = trim($tr->getElementsByTagName('td')[7]->textContent);
                    //$produto['statuscliente'] = trim($tr->getElementsByTagName('td')[2]->getElementsByTagName('span')[0]->getAttribute('class'));
                    $lista2[] = $produto;
                }
                elseif($tr->getAttribute('class') == 'group')
                {
                    $produto['nome'] = '';
                    $produto['grupo'] = TRUE;
                    $produto['inputname'] = '';
                    $produto['caixa'] = '';
                    $produto['media'] = '';
                    $produto['estoque'] = '';
                    $produto['pordia'] = '';
                    $produto['precisa'] = '';
                    $produto['nomegrupo'] = trim($tr->getElementsByTagName('td')[0]->textContent);
                    $produto['style'] = $tr->getAttribute('style');
                    $lista2[] = $produto;
                }
                else
                {
                    continue;
                }
            }

            
        }

        return $lista2;
    }

    public function editarPedido($id)
    {
        $url = 'http://aneethun-sian.com.br/app?component=edit_&page=pages%2Fsale%2FSaleOrderAnalysisOrderList&service=direct&session=T&sp='.$id;
        $fields = $this->getFormAnalise($url, 'form');
        $fields['submitmode'] = 'submit';
        //$fields['publicObs'] = utf8_decode($fields['publicObs']);
        //$fields['privateObs'] = utf8_decode($fields['privateObs']);
        unset($fields['save']);
        unset($fields['confirm']);
        unset($fields['confirm_0']);
        unset($fields['campaign']);
        $post = $this->buildPostQuery($fields);
        $url = 'http://aneethun-sian.com.br/app';
        //dd($post);
        $this->setDomDocument($url, TRUE, TRUE, $post);
        $fields = $this->getFormAnalise2($url, 'form');
        $fields['submitmode'] = 'submit';
        unset($fields['campaign']);
        unset($fields['confirm']);
        unset($fields['confirm_0']);
        unset($fields['edit']);
        
        //dd($fields);
        $xpath = new \DOMXpath($this->dom);
        $discount = trim($xpath->query("//th[@class='number']")->item(0)->textContent);
        $fields['discountValue'] = $discount;
        $fields = $this->buildPostQuery($fields);
        $this->setDomDocument($url, TRUE, TRUE, $fields);
        //dd($discount);
        
    }

    public function getFormAnalise2($url, $idForm)
    {
        $fields = [];
        //$this->setDomDocument($url);
        $form = $this->dom->getElementById($idForm);
        $elements = $form->getElementsByTagName('input');
        $selects = $this->dom->getElementsByTagName('select');
        foreach($selects as $select)
        {
            $name = $select->getAttribute('name');
            $options = $select->getElementsByTagName('option');
            foreach($options as $option)
            {
                if($option->hasAttribute('selected'))
                {
                    $value = $option->getAttribute('value');
                    $fields[$name] = $value;
                }
            }
        }
        $textareas = $this->dom->getElementsByTagName('textarea');
        if($textareas->length >= 1)
        {
            foreach($textareas as $textarea)
            {
                $fields[$textarea->getAttribute('name')] = $textarea->textContent;
            }
            
        }
        
        
        
        foreach($elements as $element)
        {
            if(!$element->hasAttribute('name')) continue;

            $name = $element->getAttribute('name');
            $value = $element->getAttribute('value');
            if(substr($element->getAttribute('name'), 0, 3) == 'For')
            {
                if(!array_key_exists($name, $fields))
                {
                    $fields[$name] = [];
                }
                $fields[$name][] = $value;
            }
            else
            {
                $fields[$name] = $value;
            }
            
            
        }
        
        return $fields;
    }

    public function sianMetodo()
    {
        echo 'metodo sian';
    }

    public function comparativo($request){
        $url = 'http://aneethun-sian.com.br/app?page=pages%2Fperformance%2FPerformanceComparison&service=page';
        $form = $this->getHiddenSian($url, 'config');
        $areas = $this->dom->getElementById('input_0')->getElementsByTagName('option');
        foreach($areas as $area){
            if($area->textContent == Auth::user()->sian_user){
                $form['input_0'] = $area->getAttribute('value');
            }
        }
        if($request->isMethod('post')){
            $form['client'] = $request->input('cliente_id');
            $form['valueUnit'] = $request->input('valueUnit');
        }elseif($request->isMethod('get')){
            $form['client'] = '';
        }
        $form['submitmode'] = 'submit';
        $form['Submit'] = 'Aguarde...';
        unset($form['year']);
        unset($form['year']);
        unset($form['month']);
        $url = 'http://aneethun-sian.com.br/app';
        //dd($post);
        $this->setDomDocument($url, TRUE, TRUE, $form);
        $xpath = new \DOMXpath($this->dom);
        $table = $xpath->query("//table[@class='list-table']")->item(0);
        $tabela = [];
        $tabela['exist'] = false;
        if($table){
            $ths = $table->getElementsByTagName('thead')->item(0)->getElementsByTagName('th');
            $thsft = $table->getElementsByTagName('tfoot')->item(0)->getElementsByTagName('th');
            $trs = $table->getElementsByTagName('tbody')->item(0)->getElementsByTagName('tr');
            
            $tabela['exist'] = true;
            $tabela['ths'] = [];
            $tabela['thsft'] = [];
            $tabela['trs'] = [];
            foreach ($ths as $key => $value) {
                $th = [];
                $th['text'] = trim($value->textContent);
                $th['colspan'] = $value->getAttribute('colspan');
                $tabela['ths'][] = $th;
            }
            foreach ($thsft as $key => $value) {
                $th = [];
                if($value->getAttribute('class') == 'number'){
                    $th['text'] = trim($value->textContent);
                    $tabela['thsft'][] = $th;
                }
            }
            foreach ($trs as $key => $value) {
                $tr = [];
                if($value->getAttribute('class') == 'even' or $value->getAttribute('class') == 'odd'){
                    $tds = $value->getElementsByTagName('td');
                    foreach ($tds as $key => $value) {
                        if($value->getAttribute('class') == 'smallText nowrap'){
                            continue;
                        }
                        $td = trim($value->textContent);
                        $tr['tds'][] = $td;
                    }
                }else{
                    continue;
                }
                $tabela['trs'][] = $tr;
            }
        }
        
        //dd($tabela['trs']);

        return $tabela;
    }



    
}
