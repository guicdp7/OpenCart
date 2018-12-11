<?php
class ControllerExtensionShippingFreteClick extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('extension/shipping/FreteClick');
		
		$data = array();
		$data['heading_title'] = $this->language->get('heading_title');
		
		$this->document->setTitle($data['heading_title']);
		
		$this->load->model('setting/setting');

				

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
		   

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/shipping/FreteClick', $data));
	}
}