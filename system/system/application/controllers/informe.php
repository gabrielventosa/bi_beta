<?php
class Informe extends Controller {
	function Informe()
	{
		parent::Controller();
		$this->load->scaffolding('informe');
		$this->load->helper('url');
		$this->load->helper('form');
	}
	function index()
	{
	$data['title'] = "CPANEL IM";
	$data['heading'] = utf8_encode("Mis informes");
	$data['zonas'] = $this->db->get('zona');
	$data['query'] = $this->db->get('informe');
	$this->load->view('informe_view', $data);
	}
	
	function edit()
	{
	$data['title'] = "CPANEL IM";
	$data['heading'] = utf8_encode("Modificar datos de informe");

	$entry = $this->uri->segment(3);
	$data['zonas'] = $this->db->get('zona');
	$data['query'] = $this->db->where('id',$entry)->get('informe');
	$this->load->view('informe_edit', $data);
	}
	function save()
	{
	$this->db->where('id',$_POST['id']);
	$this->db->update('informe',$_POST);
	redirect('informe');
	}
	
	function add()
	{
	$data['title'] = "CPANEL IM";
	$data['heading'] = utf8_encode("Agregar un informe nuevo");
	$data['zonas'] = $this->db->get('zona');
	$this->load->view('informe_add', $data);
	}
	
	function insert()
	{
	$this->db->insert('informe',$_POST);
	redirect('informe');
	}
	
}

?>
