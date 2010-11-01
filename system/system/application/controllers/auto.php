<?php
class Auto extends Controller {
	function Auto()
	{
		parent::Controller();
		$this->load->scaffolding('auto');
		$this->load->helper('url');
		$this->load->helper('form');
	}
	function index()
	{
	$data['title'] = "CPANEL IM";
	$data['heading'] = utf8_encode("Mis vehículos");
	$data['query'] = $this->db->get('auto');
	$data['zonas'] = $this->db->get('zona');
	$this->load->view('auto_view', $data);
	}
	
	function edit()
	{
	$data['title'] = "CPANEL IM";
	$data['heading'] = utf8_encode("Modificar datos de vehículo");

	$entry = $this->uri->segment(3);
	$data['zonas'] = $this->db->get('zona');
	$data['query'] = $this->db->where('id',$entry)->get('auto');
	$this->load->view('auto_edit', $data);
	}
	function save()
	{
	$this->db->where('id',$_POST['id']);
	$this->db->update('auto',$_POST);
	redirect('auto');
	}
}

?>
