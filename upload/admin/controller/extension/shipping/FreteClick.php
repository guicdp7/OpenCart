<?php
/*
Author:       Guilherme Cristino
Author URI:   http://twitter.com/guilhermeCDP7
*/

class ControllerExtensionShippingFreteClick extends Controller {
	public $app = array(
		"name" => "shipping_freteclick",
		"folder" => "shipping/FreteClick"
	);
	private $error = array();
	private $url_shipping_quote = "https://api.freteclick.com.br/sales/shipping-quote.json";
	private $url_origin_company = "https://app.freteclick.com.br/sales/add-quote-origin-company.json";
	private $url_destination_client = "https://app.freteclick.com.br/sales/add-quote-destination-client.json";
	private $campos = array(
		'FC_CITY_ORIGIN' => "",
		'FC_CEP_ORIGIN' => "",
		'FC_STREET_ORIGIN' => "",
		'FC_NUMBER_ORIGIN' => "",
		'FC_COMPLEMENT_ORIGIN' => "",
		'FC_STATE_ORIGIN' => "",
		'FC_CONTRY_ORIGIN' => "",
		'FC_DISTRICT_ORIGIN' => "",
		'FC_INFO_PROD' => "",
		'FC_SHOP_CART' => "",
		'FC_API_KEY' => "",
		'FC_CARRIERS_NUMBER' => ""
	);
	private $FC_status;
	private $FC_position;
	
	public function index() {   
		$this->load->language('extension/'.$this->app["folder"]);
		
		$data = array();
		$data["app"] = $this->app;
		$data['heading_title'] = $this->language->get('heading_title');
		
		$this->document->setTitle($data['heading_title']);
		
		$this->load->model('setting/setting');

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()){
			$this->FC_status = $this->request->post[$this->app["name"]."_status"];
			$this->FC_position = $this->request->post[$this->app["name"]."_sort_order"];
			unset($this->request->post[$this->app["name"]."_status"]);
			unset($this->request->post[$this->app["name"]."_sort_order"]);

			$this->model_setting_setting->editSetting($this->app["name"], array(
				$this->app["name"]."_campos" => $this->request->post,
				$this->app["name"]."_status" => $this->FC_status,
				$this->app["name"]."_sort_order" => $this->FC_position
			));

			$this->session->data['success'] = $this->language->get('text_success');			
			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping', true));
		}

		$data['action'] = $this->url->link('extension/'.$this->app["folder"], 'user_token=' . $this->session->data['user_token'], true);
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping', true);

		$data['breadcrumbs'] = array();
   		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping', true)
		);
		   	
   		$data['breadcrumbs'][] = array(
			'text' => $data['heading_title'],
			'href' => $this->url->link('extension/'.$this->app["folder"], 'user_token=' . $this->session->data['user_token'], true)
		);

		/*Configuração FreteClick */		
		$this->document->addScript('view/javascript/'.$this->app["name"].'.js');
		
		$result = $this->model_setting_setting->getSetting($this->app["name"]);
		$campos = $result[$this->app["name"]."_campos"];
		$this->FC_status = $result[$this->app["name"]."_status"];
		$this->FC_position = $result[$this->app["name"]."_sort_order"];

		$this->campos['FC_CITY_ORIGIN'] = isset($this->request->post['FC_CITY_ORIGIN']) ? $this->request->post['FC_CITY_ORIGIN'] : $campos['FC_CITY_ORIGIN'];
        $this->campos['FC_CEP_ORIGIN'] = isset($this->request->post['FC_CEP_ORIGIN']) ? $this->request->post['FC_CEP_ORIGIN'] : $campos['FC_CEP_ORIGIN'];
		$this->campos['FC_STREET_ORIGIN'] = isset($this->request->post['FC_STREET_ORIGIN']) ? $this->request->post['FC_STREET_ORIGIN'] : $campos['FC_STREET_ORIGIN'];
		$this->campos['FC_NUMBER_ORIGIN'] = isset($this->request->post['FC_NUMBER_ORIGIN']) ? $this->request->post['FC_NUMBER_ORIGIN'] : $campos['FC_NUMBER_ORIGIN'];
		$this->campos['FC_COMPLEMENT_ORIGIN'] = isset($this->request->post['FC_COMPLEMENT_ORIGIN']) ? $this->request->post['FC_COMPLEMENT_ORIGIN'] : $campos['FC_COMPLEMENT_ORIGIN'];
		$this->campos['FC_STATE_ORIGIN'] = isset($this->request->post['FC_STATE_ORIGIN']) ? $this->request->post['FC_STATE_ORIGIN'] : $campos['FC_STATE_ORIGIN'];
		$this->campos['FC_CONTRY_ORIGIN'] = isset($this->request->post['FC_CONTRY_ORIGIN']) ? $this->request->post['FC_CONTRY_ORIGIN'] : $campos['FC_CONTRY_ORIGIN'];
		$this->campos['FC_DISTRICT_ORIGIN'] = isset($this->request->post['FC_DISTRICT_ORIGIN']) ? $this->request->post['FC_DISTRICT_ORIGIN'] : $campos['FC_DISTRICT_ORIGIN'];
		$this->campos['FC_API_KEY'] = isset($this->request->post['FC_API_KEY']) ? $this->request->post['FC_API_KEY'] : $campos['FC_API_KEY'];
		$this->campos['FC_CARRIERS_NUMBER'] = isset($this->request->post['FC_CARRIERS_NUMBER']) ? $this->request->post['FC_CARRIERS_NUMBER'] : $campos['FC_CARRIERS_NUMBER'];
		$this->FC_status = isset($this->request->post[$this->app["name"].'_status']) ? $this->request->post[$this->app["name"].'_status'] : $this->FC_status;
		$this->FC_position = isset($this->request->post[$this->app["name"].'_sort_order']) ? $this->request->post[$this->app["name"].'_sort_order'] : $this->FC_position;

		$data['data'] = $this->campos;		
		$data[$this->app["name"].'_status'] = $this->FC_status;		
		$data[$this->app["name"].'_sort_order'] = $this->FC_position;		   

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/'.$this->app["folder"], $data));
	}
	public function install() {
		$this->load->model('setting/setting');
		$result = $this->model_setting_setting->getSetting($this->app["name"]);
		if(!$result) {
			$campos = json_encode($this->campos);
		   
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET store_id = '0', `code` = '".$this->app["name"]."', `key` =  '".$this->app["name"]."_campos', `value` = '". $campos . "', `serialized` = '1'");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET store_id = '0', `code` = '".$this->app["name"]."', `key` =  '".$this->app["name"]."_status', `value` = '0'");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET store_id = '0', `code` = '".$this->app["name"]."', `key` =  '".$this->app["name"]."_sort_order', `value` = ''");
		}
	}
	public function uninstall(){
		$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE `code` = '".$this->app["name"]."'");
	}
	protected function validate() {
		if (!$this->user->hasPermission('modify', "extension/".$this->app["folder"])) {
			$this->load->language('extension/'.$this->app["folder"]);
		  	$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;	 
	}
}