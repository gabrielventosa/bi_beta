<?php
class Zona extends Controller {
	function Zona()
	{
		parent::Controller();
		$this->load->scaffolding('zona');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('DX_Auth');
		$this->load->library('MyMenu');	
		$this->load->library('MyHeader');
		$this->dx_auth->check_uri_permissions();
		if(!($this->dx_auth->get_permission_value('zone_access_allow') == 'accept' || $this->dx_auth->is_admin())){
			$this->dx_auth->deny_access();
		}
	}
	function index()
	{
	$data['title'] = "CPANEL IM";
	$data['heading'] = utf8_encode("Mis zonas");
	$data['query'] = $this->db->get('zona');
	$menu  = new MyMenu;
	$header = new MyHeader;
	$data['menu'] = $menu->show_menu();
	$data['header'] = $header->show_header();
	$data['footer'] = "&copy;2010 Todos los derechos reservados.  &#149;  Dise&ntilde;ado por InteligenciaMec&aacute;nica.";
	$this->load->view('zona_view', $data);
	}
	
	function edit()
	{
	$data['title'] = "CPANEL IM";
	$data['heading'] = utf8_encode("Modificar datos de zona");

	$entry = $this->uri->segment(3);
	$data['query'] = $this->db->where('id',$entry)->get('zona');
	$menu  = new MyMenu;
	$header = new MyHeader;
	$data['menu'] = $menu->show_menu();
	$data['header'] = $header->show_header();
	$data['footer'] = "&copy;2010 Todos los derechos reservados.  &#149;  Dise&ntilde;ado por InteligenciaMec&aacute;nica.";
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
	$menu  = new MyMenu;
	$header = new MyHeader;
	$data['menu'] = $menu->show_menu();
	$data['header'] = $header->show_header();
	$data['footer'] = "&copy;2010 Todos los derechos reservados.  &#149;  Dise&ntilde;ado por InteligenciaMec&aacute;nica.";
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
