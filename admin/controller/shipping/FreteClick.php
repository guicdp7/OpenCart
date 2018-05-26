<?php
class ControllerShippingFreteClick extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('shipping/FreteClick');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('FreteClick', $this->request->post);		
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->response->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');		
		$data['text_sedex'] = $this->language->get('text_sedex');
		$data['text_sedex_cobrar'] = $this->language->get('text_sedex_cobrar');
		$data['text_pac'] = $this->language->get('text_pac');
		$data['text_sedex_10'] = $this->language->get('text_sedex_10');
		$data['text_esedex'] = $this->language->get('text_esedex');
		
		$data['text_sedex_cobrar_contrato'] = $this->language->get('text_sedex_cobrar_contrato');
		$data['text_sedex_hoje'] = $this->language->get('text_sedex_hoje');
		$data['text_sedex_contrato_40096'] = $this->language->get('text_sedex_contrato_40096');
		$data['text_sedex_contrato_40436'] = $this->language->get('text_sedex_contrato_40436');
		$data['text_sedex_contrato_40444'] = $this->language->get('text_sedex_contrato_40444');
		$data['text_sedex_contrato_40568'] = $this->language->get('text_sedex_contrato_40568');
		$data['text_sedex_contrato_40606'] = $this->language->get('text_sedex_contrato_40606');
		$data['text_pac_contrato'] = $this->language->get('text_pac_contrato');
		$data['text_esedex_prioritario'] = $this->language->get('text_esedex_prioritario');
		$data['text_esedex_express'] = $this->language->get('text_esedex_express');
		$data['text_esedex_grupo1'] = $this->language->get('text_esedex_grupo1');
		$data['text_esedex_grupo2'] = $this->language->get('text_esedex_grupo2');
		$data['text_esedex_grupo3'] = $this->language->get('text_esedex_grupo3');

		$data['entry_cost'] = $this->language->get('entry_cost');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_servicos'] = $this->language->get('entry_servicos');
		$data['entry_prazo_adicional'] = $this->language->get('entry_prazo_adicional');
		$data['entry_contrato'] = $this->language->get('entry_contrato');
		$data['entry_contrato_codigo'] = $this->language->get('entry_contrato_codigo');
		$data['entry_contrato_senha'] = $this->language->get('entry_contrato_senha');
		
		$data['help_mao_propria'] = $this->language->get('help_mao_propria');
		$data['help_aviso_recebimento'] = $this->language->get('help_aviso_recebimento');
		$data['help_declarar_valor'] = $this->language->get('help_declarar_valor');
		$data['help_adicional'] = $this->language->get('help_adicional');
		$data['help_servicos'] = $this->language->get('help_servicos');
		$data['help_prazo_adicional'] = $this->language->get('help_prazo_adicional');
		$data['help_contrato'] = $this->language->get('help_contrato');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		$data['tab_general'] = $this->language->get('tab_general');
		
		$data['entry_postcode']= $this->language->get('entry_postcode');
		$data['entry_mao_propria']= $this->language->get('entry_mao_propria');
		$data['entry_aviso_recebimento']= $this->language->get('entry_aviso_recebimento');
		$data['entry_declarar_valor']= $this->language->get('entry_declarar_valor');
		$data['entry_adicional']= $this->language->get('entry_adicional');
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->error['postcode'])) {
			$data['error_postcode'] = $this->error['postcode'];
		} else {
			$data['error_postcode'] = '';
		}

		$data['breadcrumbs'] = array();
   		
   		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
   		);
   		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_shipping'),
			'href' => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL')
   		);
   		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('shipping/FreteClick', 'token=' . $this->session->data['token'], 'SSL')
   		);
		
   		$data['action'] = $this->url->link('shipping/FreteClick', 'token=' . $this->session->data['token'], 'SSL');
		
   		$data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->post['FreteClick_status'])) {
			$data['FreteClick_status'] = $this->request->post['FreteClick_status'];
		} else {
			$data['FreteClick_status'] = $this->config->get('FreteClick_status');
		}
		if (isset($this->request->post['FreteClick_tax_class_id'])) {
			$data['FreteClick_tax_class_id'] = $this->request->post['FreteClick_tax_class_id'];
		} else {
			$data['FreteClick_tax_class_id'] = $this->config->get('FreteClick_tax_class_id');
		}
		if (isset($this->request->post['FreteClick_geo_zone_id'])) {
			$data['FreteClick_geo_zone_id'] = $this->request->post['FreteClick_geo_zone_id'];
		} else {
			$data['FreteClick_geo_zone_id'] = $this->config->get('FreteClick_geo_zone_id');
		}
		if (isset($this->request->post['FreteClick_postcode'])) {
			$data['FreteClick_postcode'] = $this->request->post['FreteClick_postcode'];
		} else {
			$data['FreteClick_postcode'] = $this->config->get('FreteClick_postcode');
		}
		
		if (isset($this->request->post['FreteClick_mao_propria'])) {
			$data['FreteClick_mao_propria'] = $this->request->post['FreteClick_mao_propria'];
		} else {
			$data['FreteClick_mao_propria'] = $this->config->get('FreteClick_mao_propria');
		}
		if (isset($this->request->post['FreteClick_aviso_recebimento'])) {
			$data['FreteClick_aviso_recebimento'] = $this->request->post['FreteClick_aviso_recebimento'];
		} else {
			$data['FreteClick_aviso_recebimento'] = $this->config->get('FreteClick_aviso_recebimento');
		}
		if (isset($this->request->post['FreteClick_declarar_valor'])) {
			$data['FreteClick_declarar_valor'] = $this->request->post['FreteClick_declarar_valor'];
		} else {
			$data['FreteClick_declarar_valor'] = $this->config->get('FreteClick_declarar_valor');
		}
		if (isset($this->request->post['FreteClick_adicional'])) {
			$data['FreteClick_adicional'] = $this->request->post['FreteClick_adicional'];
		} else {
			$data['FreteClick_adicional'] = $this->config->get('FreteClick_adicional');
		}
		if (isset($this->request->post['FreteClick_prazo_adicional'])) {
			$data['FreteClick_prazo_adicional'] = $this->request->post['FreteClick_prazo_adicional'];
		} else {
			$data['FreteClick_prazo_adicional'] = $this->config->get('FreteClick_prazo_adicional');
		}
		if (isset($this->request->post['FreteClick_contrato_codigo'])) {
			$data['FreteClick_contrato_codigo'] = $this->request->post['FreteClick_contrato_codigo'];
		} else {
			$data['FreteClick_contrato_codigo'] = $this->config->get('FreteClick_contrato_codigo');
		}
		if (isset($this->request->post['FreteClick_contrato_senha'])) {
			$data['FreteClick_contrato_senha'] = $this->request->post['FreteClick_contrato_senha'];
		} else {
			$data['FreteClick_contrato_senha'] = $this->config->get('FreteClick_contrato_senha');
		}						

		if (isset($this->request->post['FreteClick_41106'])) {
			$data['FreteClick_41106'] = $this->request->post['FreteClick_41106'];
		} else {
			$data['FreteClick_41106'] = $this->config->get('FreteClick_41106');
		}
		
		if (isset($this->request->post['FreteClick_40010'])) {
			$data['FreteClick_40010'] = $this->request->post['FreteClick_40010'];
		} else {
			$data['FreteClick_40010'] = $this->config->get('FreteClick_40010');
		}
		
		if (isset($this->request->post['FreteClick_40045'])) {
			$data['FreteClick_40045'] = $this->request->post['FreteClick_40045'];
		} else {
			$data['FreteClick_40045'] = $this->config->get('FreteClick_40045');
		}
		
		if (isset($this->request->post['FreteClick_40215'])) {
			$data['FreteClick_40215'] = $this->request->post['FreteClick_40215'];
		} else {
			$data['FreteClick_40215'] = $this->config->get('FreteClick_40215');
		}

		if (isset($this->request->post['FreteClick_81019'])) {
			$data['FreteClick_81019'] = $this->request->post['FreteClick_81019'];
		} else {
			$data['FreteClick_81019'] = $this->config->get('FreteClick_81019');
		}
		
		// sedex a cobrar com contrato
		if (isset($this->request->post['FreteClick_40126'])) {
			$data['FreteClick_40126'] = $this->request->post['FreteClick_40126'];
		} else {
			$data['FreteClick_40126'] = $this->config->get('FreteClick_40126');
		}		
		
		// sedex hoje
		if (isset($this->request->post['FreteClick_40290'])) {
			$data['FreteClick_40290'] = $this->request->post['FreteClick_40290'];
		} else {
			$data['FreteClick_40290'] = $this->config->get('FreteClick_40290');
		}
		
		// sedex com contrato
		if (isset($this->request->post['FreteClick_40096'])) {
			$data['FreteClick_40096'] = $this->request->post['FreteClick_40096'];
		} else {
			$data['FreteClick_40096'] = $this->config->get('FreteClick_40096');
		}

		// sedex com contrato
		if (isset($this->request->post['FreteClick_40436'])) {
			$data['FreteClick_40436'] = $this->request->post['FreteClick_40436'];
		} else {
			$data['FreteClick_40436'] = $this->config->get('FreteClick_40436');
		}
		
		// sedex com contrato
		if (isset($this->request->post['FreteClick_40444'])) {
			$data['FreteClick_40444'] = $this->request->post['FreteClick_40444'];
		} else {
			$data['FreteClick_40444'] = $this->config->get('FreteClick_40444');
		}
		
		// sedex com contrato
		if (isset($this->request->post['FreteClick_40568'])) {
			$data['FreteClick_40568'] = $this->request->post['FreteClick_40568'];
		} else {
			$data['FreteClick_40568'] = $this->config->get('FreteClick_40568');
		}
		
		// sedex com contrato
		if (isset($this->request->post['FreteClick_40606'])) {
			$data['FreteClick_40606'] = $this->request->post['FreteClick_40606'];
		} else {
			$data['FreteClick_40606'] = $this->config->get('FreteClick_40606');
		}
		
		// pac com contrato
		if (isset($this->request->post['FreteClick_41068'])) {
			$data['FreteClick_41068'] = $this->request->post['FreteClick_41068'];
		} else {
			$data['FreteClick_41068'] = $this->config->get('FreteClick_41068');
		}
		
		// pac com contrato
		if (isset($this->request->post['FreteClick_41068'])) {
			$data['FreteClick_41068'] = $this->request->post['FreteClick_41068'];
		} else {
			$data['FreteClick_41068'] = $this->config->get('FreteClick_41068');
		}
		
		// e-sedex prioritário
		if (isset($this->request->post['FreteClick_81027'])) {
			$data['FreteClick_81027'] = $this->request->post['FreteClick_81027'];
		} else {
			$data['FreteClick_81027'] = $this->config->get('FreteClick_81027');
		}
		
		// e-sedex express
		if (isset($this->request->post['FreteClick_81035'])) {
			$data['FreteClick_81035'] = $this->request->post['FreteClick_81035'];
		} else {
			$data['FreteClick_81035'] = $this->config->get('FreteClick_81035');
		}
		
		// e-sedex grupo 1
		if (isset($this->request->post['FreteClick_81868'])) {
			$data['FreteClick_81868'] = $this->request->post['FreteClick_81868'];
		} else {
			$data['FreteClick_81868'] = $this->config->get('FreteClick_81868');
		}
		
		// e-sedex grupo 2
		if (isset($this->request->post['FreteClick_81833'])) {
			$data['FreteClick_81833'] = $this->request->post['FreteClick_81833'];
		} else {
			$data['FreteClick_81833'] = $this->config->get('FreteClick_81833');
		}
		
		// e-sedex grupo 3
		if (isset($this->request->post['FreteClick_81850'])) {
			$data['FreteClick_81850'] = $this->request->post['FreteClick_81850'];
		} else {
			$data['FreteClick_81850'] = $this->config->get('FreteClick_81850');
		}
		
		if (isset($this->request->post['FreteClick_sort_order'])) {
			$data['FreteClick_sort_order'] = $this->request->post['FreteClick_sort_order'];
		} else {
			$data['FreteClick_sort_order'] = $this->config->get('FreteClick_sort_order');
		}
		$this->load->model('localisation/tax_class');
		
		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
		
		$this->load->model('localisation/geo_zone');
		
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('shipping/FreteClick.tpl', $data));
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/FreteClick')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}