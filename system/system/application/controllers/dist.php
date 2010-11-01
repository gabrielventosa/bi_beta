<?php
class Dist extends Controller {
	function Dist()
	{
		parent::Controller();
		$this->load->scaffolding('distribuidor');
		$this->load->helper('url');
		$this->load->helper('form');
	}
	function index()
	{
	$data['title'] = "CPANEL IM";
	$data['heading'] = utf8_encode("Mis distribuidores");
	$data['zonas'] = $this->db->get('zona');
	$data['query'] = $this->db->get('distribuidor');
	$this->load->view('dist_view', $data);
	}
	
	function edit()
	{
	$data['title'] = "CPANEL IM";
	$data['heading'] = utf8_encode("Modificar datos de distribuidor");

	$entry = $this->uri->segment(3);
	$data['zonas'] = $this->db->get('zona');
	$data['query'] = $this->db->where('id',$entry)->get('distribuidor');
	$this->load->view('dist_edit', $data);
	}
	function save()
	{
	$this->db->where('id',$_POST['id']);
	$this->db->update('distribuidor',$_POST);
	redirect('dist');
	}
	
	function add()
	{
	$data['title'] = "CPANEL IM";
	$data['heading'] = utf8_encode("Agregar un distribuidor nuevo");
	$data['zonas'] = $this->db->get('zona');
	$this->load->view('dist_add', $data);
	}
	
	function insert()
	{
	$this->db->insert('distribuidor',$_POST);
	redirect('dist');
	}
	
}

?>
