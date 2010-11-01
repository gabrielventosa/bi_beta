<?php
class Auto extends Controller {
	function Auto()
	{
		parent::Controller();
		$this->load->scaffolding('auto');
		$this->load->model('autos');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('DX_Auth');
	        $this->load->library('MyMenu');	
		$this->load->library('MyHeader');
		$this->dx_auth->check_uri_permissions();
		if(!($this->dx_auth->get_permission_value('auto_access_allow') == 'accept' || $this->dx_auth->is_admin())){
			$this->dx_auth->deny_access();
		}
		
	}
	
	function index()
	{
	$data['title'] = "CPANEL IM";
	$data['heading'] = utf8_encode("Mis vehículos");
	$data['query'] = $this->autos->get_all();
	$data['zonas'] = $this->db->get('zona');
	$menu  = new MyMenu;
	$header = new MyHeader;
	$data['menu'] = $menu->show_menu();
	$data['header'] = $header->show_header();
	$data['footer'] = "&copy;2010 Todos los derechos reservados.  &#149;  Dise&ntilde;ado por InteligenciaMec&aacute;nica.";
	$this->load->view('auto_view', $data);
	}
	
	function edit()
	{
	$data['title'] = "CPANEL IM";
	$data['heading'] = utf8_encode("Modificar datos de vehículo");

	$entry = $this->uri->segment(3);
	$data['zonas'] = $this->db->get('zona');
	$data['query'] = $this->db->where('id',$entry)->get('auto');
	$menu  = new MyMenu;
	$header = new MyHeader;
	$data['menu'] = $menu->show_menu();
	$data['header'] = $header->show_header();
	$data['footer'] = "&copy;2010 Todos los derechos reservados.  &#149;  Dise&ntilde;ado por InteligenciaMec&aacute;nica.";
	$this->load->view('auto_edit', $data);
	}
	function save()
	{
	$this->db->where('id',$_POST['id']);
	$this->db->update('auto',$_POST);
	redirect('auto');
	}

	function get_all_vehicles()
	{
		$data['vehicles'] = $this->db->get('auto')->result();
		$this->load->view('/auto/xml/get_all_vehicles_xml', $data);
	}

	function get_vehicle_gpspos_xml()
	{
		$id = $this->input->post('id');
		$vehicle_pos = $this->autos->get_vehicle_gpspos($id);
		if($vehicle_pos->num_rows < 1){
			echo('Error');
		}else{
			$data['id'] = $id;
			$data['vehicles'] = $vehicle_pos->result();
			$this->load->view('/auto/xml/get_vehicles_gpspos_xml',$data);
		}
	}

	function get_vehicle_actual_route_xml()
	{
		$id = $this->input->post('id');
		$vehicle_route = $this->autos-> get_vehicle_actual_route($id);
		if($vehicle_route->num_rows < 1){
			echo('Error');
		}else{
			$data['id'] = $id;
			$data['points'] = $vehicle_route->result();
			$this->load->view('/auto/xml/get_vehicle_actual_route_xml',$data);
		}
	}


}

?>
