<?php
class ControllerExtensionShippingFreteClick extends Controller {
	private $error = array();
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
	
	public function index() {   
		$this->load->language('extension/shipping/FreteClick');
		
		$data = array();
		$data['heading_title'] = $this->language->get('heading_title');
		
		$this->document->setTitle($data['heading_title']);
		
		$this->load->model('setting/setting');

		if ($this->request->server['REQUEST_METHOD'] == 'POST'){
			$this->model_setting_setting->editSetting('FreteClick', array("FreteClick_campos" => $this->request->post));

			$this->session->data['success'] = $this->language->get('text_success');			
			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping', true));
		}

		$data['action'] = $this->url->link('extension/shipping/FreteClick', 'user_token=' . $this->session->data['user_token'], true);
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
			'href' => $this->url->link('extension/shipping/FreteClick', 'user_token=' . $this->session->data['user_token'], true)
		);

		/*Configuração FreteClick */
		
		$result = $this->model_setting_setting->getSetting('FreteClick');
		$campos = $result["FreteClick_campos"];

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

		$data['data'] = $this->campos;		   

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/shipping/FreteClick', $data));
	}
	public function install() {
		$this->load->model('setting/setting');
		$result = $this->model_setting_setting->getSetting('FreteClick');
		if(!$result) {
			$campos = json_encode($this->campos);
		   
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET store_id = '0', `code` = 'FreteClick', `key` =  'FreteClick_campos', `value` = '". $campos . "', `serialized` = '1'");
		}
	}
}