<?php
class Zona extends Controller {
	function Zona()
	{
		parent::Controller();
		$this->load->scaffolding('zona');
		$this->load->helper('url');
		$this->load->helper('form');
	}
	function index()
	{
	$data['title'] = "CPANEL IM";
	$data['heading'] = utf8_encode("Mis zonas");
	$data['query'] = $this->db->get('zona');
	$this->load->view('zona_view', $data);
	}
	
	function edit()
	{
	$data['title'] = "CPANEL IM";
	$data['heading'] = utf8_encode("Modificar datos de zona");

	$entry = $this->uri->segment(3);
	$data['query'] = $this->db->where('id',$entry)->get('zona');
	$this->load->view('zona_edit', $data);
	}
	function save()
	{
	$this->db->where('id',$_POST['id']);
	$this->db->update('zona',$_POST);
	redirect('zona');
	}
	
	function add()
	{
	$data['title'] = "CPANEL IM";
	$data['heading'] = utf8_encode("Agregar una zona nueva");
	$this->load->view('zona_add', $data);
	}
	
	function insert()
	{
	$this->db->insert('zona',$_POST);
	redirect('zona');
	}
	
	function ajax_zinfo()
	{
	$data['query'] = $this->db->where('ZONA',$_POST['zid'])->get('auto');
	$this->db->from('distribuidor');
	$this->db->where('zona',$_POST['zid']);
	$data['numdist'] = $this->db->count_all_results();
	$this->load->view('zona_ajax_zinfo', $data);
	}
}

?>
