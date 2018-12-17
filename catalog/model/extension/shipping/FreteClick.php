<?php
/*
Author:       Guilherme Cristino
Author URI:   http://twitter.com/guilhermeCDP7
*/

class ModelExtensionShippingFreteClick extends Controller {
    private $peso_min = 0.3;// em kg
	private $comp_min = 16;	// em cm
	private $larg_min = 11; // em cm
    private $altu_min = 2; 	// em cm
    
    private $quote_data = array();
	
	private $cep_destino;
    private $cep_origem;
    
    private $mensagem_erro = array();
	
    private $total_compra;
    
	private $zone_id;
    
    public function getQuote($address) {
		$this->load->language('extension/shipping/FreteClick');

        $produtos = $this->removeProdutosSemFrete($this->cart->getProducts());
        
        
		if (!empty($produtos)) {
			$this->cep_destino = preg_replace ("/[^0-9]/", '', $address['postcode']);
            $this->total_compra = $this->cart->getSubTotal();

			if((int)$address['zone_id']) {
				$this->zone_id = (int)$address['zone_id'];
			} else {
				$this->zone_id = $this->getZoneIdByPostcode($address['postcode']);
			}
            /*Dados de origem*/
			$array_data = array(
				'city-origin' => $this->config->get('FC_CITY_ORIGIN'),
				'cep-origin' => $this->config->get('FC_CEP_ORIGIN'),
				'street-origin' => $this->config->get('FC_STREET_ORIGIN'),
				'address-number-origin' => $this->config->get('FC_NUMBER_ORIGIN'),
				'complement-origin' => strlen($this->config->get('FC_COMPLEMENT_ORIGIN')) > 0 ? $this->config->get('FC_COMPLEMENT_ORIGIN') : "",
				'district-origin' => $this->config->get('FC_DISTRICT_ORIGIN'),
				'state-origin' => $this->config->get('FC_STATE_ORIGIN'),
				'country-origin' => $this->config->get('FC_CONTRY_ORIGIN')
            );
            echo json_encode($array_data); exit;
        }
    }
    private function removeProdutosSemFrete($products) {

		foreach ($products as $key => $product) {
  			
			if (!$product['shipping']) {
  				unset($products[$key]);
  			}	
  		}
  		return $products;
    }
    private function getZoneIdByPostcode($postcode){
		
		$zone_id = 0;
		
		$postcode = preg_replace ("/[^0-9]/", '', $postcode); 
			
		$tabela['ac'] = array(
			'cepini' => '69900000',
			'cepfim' => '69999999' 
		);
		$tabela['al'] = array(
			'cepini' => '57000000',
			'cepfim' => '57999999' 
		);
		$tabela['am'] = array(
			'cepini' => '69000000',
			'cepfim' => '69299999' 
		);
		$tabela['am.2'] = array(
			'cepini' => '69400000',
			'cepfim' => '69899999' 
		);		
		$tabela['ap'] = array(
			'cepini' => '68900000',
			'cepfim' => '68999999' 
		);
		$tabela['ba'] = array(
			'cepini' => '40000000',
			'cepfim' => '48999999 '
		);
		$tabela['ce'] = array(
			'cepini' => '60000000',
			'cepfim' => '63999999' 
		);
		$tabela['df'] = array(
			'cepini' => '70000000',
			'cepfim' => '72799999'
		);
		$tabela['df.2'] = array(
			'cepini' => '73000000',
			'cepfim' => '73699999'
		);				
		$tabela['es'] = array(
			'cepini' => '29000000',
			'cepfim' => '29999999' 
		);
		$tabela['go'] = array(
			'cepini' => '72800000',
			'cepfim' => '72999999' 
		);
		$tabela['go.2'] = array(
			'cepini' => '73700000',
			'cepfim' => '76799999' 
		);		
		$tabela['ma'] = array(
			'cepini' => '65000000',
			'cepfim' => '65999999' 
		);
		$tabela['mg'] = array(
			'cepini' => '30000000',
			'cepfim' => '39999999' 
		);
		$tabela['ms'] = array(
			'cepini' => '79000000',
			'cepfim' => '79999999' 
		);
		$tabela['mt'] = array(
			'cepini' => '78000000',
			'cepfim' => '78899999' 
		);
		$tabela['pa'] = array(
			'cepini' => '66000000',
			'cepfim' => '68899999' 
		);
		$tabela['pb'] = array(
			'cepini' => '58000000',
			'cepfim' => '58999999' 
		);
		$tabela['pe'] = array(
			'cepini' => '50000000',
			'cepfim' => '56999999' 
		);		
		$tabela['pi'] = array(
			'cepini' => '64000000',
			'cepfim' => '64999999' 
		);		
		$tabela['pr'] = array(
			'cepini' => '80000000',
			'cepfim' => '87999999' 
		);		
		$tabela['rj'] = array(
			'cepini' => '20000000',
			'cepfim' => '28999999' 
		);		
		$tabela['rn'] = array(
			'cepini' => '59000000',
			'cepfim' => '59999999' 
		);		
		$tabela['ro'] = array(
			'cepini' => '76800000',
			'cepfim' => '76999999' 
		);		
		$tabela['rr'] = array(
			'cepini' => '69300000',
			'cepfim' => '69399999' 
		);		
		$tabela['rs'] = array(
			'cepini' => '90000000',
			'cepfim' => '99999999' 
		);
		$tabela['sc'] = array(
			'cepini' => '88000000',
			'cepfim' => '89999999' 
		);		
		$tabela['se'] = array(
			'cepini' => '49000000',
			'cepfim' => '49999999' 
		);
		$tabela['sp'] = array(
			'cepini' => '01000000',
			'cepfim' => '19999999'
		);
		$tabela['to'] = array(
			'cepini' => '77000000',
			'cepfim' => '77999999' 
		);
		
		foreach($tabela as $zone_code => $postcode_range){
			
			if((int)$postcode >= (int)$postcode_range['cepini'] && (int)$postcode <= (int)$postcode_range['cepfim']){
				$key = explode('.', $zone_code);
				
				$zone_info = $this->getZoneIdByCode($key[0]);
				
				$zone_id = $zone_info['zone_id'];
				
				break;
			}
		}
		
		return $zone_id;				
    }
    private function getZoneIdByCode($zone_code) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone WHERE code = '" . $this->db->escape(strtoupper($zone_code)) . "' AND country_id = '" . (int)$this->config->get('config_country_id') . "' AND status = '1'");
		
		return $query->row;
	}
}
