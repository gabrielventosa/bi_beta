<?php
class Dist extends Controller {
	function Dist()
	{
		parent::Controller();
		$this->load->scaffolding('distribuidor');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('DX_Auth');
		$this->load->library('MyMenu');	
		$this->load->library('MyHeader');
		$this->dx_auth->check_uri_permissions();
		if(!($this->dx_auth->get_permission_value('dist_access_allow') == 'accept' || $this->dx_auth->is_admin())){
			$this->dx_auth->deny_access();
		}

	}
	function index()
	{
	$this->dx_auth->check_uri_permissions();
	$data['title'] = "CPANEL IM";
	$data['heading'] = utf8_encode("Mis distribuidores");
	$data['zonas'] = $this->db->get('zona');
	$data['query'] = $this->db->get('distribuidor');
	$menu  = new MyMenu;
	$header = new MyHeader;
	$data['menu'] = $menu->show_menu();
	$data['header'] = $header->show_header();
	$data['footer'] = "&copy;2010 Todos los derechos reservados.  &#149;  Dise&ntilde;ado por InteligenciaMec&aacute;nica.";
	$this->load->view('dist_view', $data);
	}
	
	function edit()
	{
	$this->dx_auth->check_uri_permissions();
	$data['title'] = "CPANEL IM";
	$data['heading'] = utf8_encode("Modificar datos de distribuidor");

	$entry = $this->uri->segment(3);
	$data['zonas'] = $this->db->get('zona');
	$data['query'] = $this->db->where('id',$entry)->get('distribuidor');
	$menu  = new MyMenu;
	$header = new MyHeader;
	$data['menu'] = $menu->show_menu();
	$data['header'] = $header->show_header();
	$data['footer'] = "&copy;2010 Todos los derechos reservados.  &#149;  Dise&ntilde;ado por InteligenciaMec&aacute;nica.";
	$this->load->view('dist_edit', $data);
	}
	function save()
	{
	$this->dx_auth->check_uri_permissions();
	$this->db->where('id',$_POST['id']);
	$this->db->update('distribuidor',$_POST);
	redirect('dist');
	}
	
	function add()
	{
	$this->dx_auth->check_uri_permissions();
	$data['title'] = "CPANEL IM";
	$data['heading'] = utf8_encode("Agregar un distribuidor nuevo");
	$data['zonas'] = $this->db->get('zona');
	$menu  = new MyMenu;
	$header = new MyHeader;
	$data['menu'] = $menu->show_menu();
	$data['header'] = $header->show_header();
	$data['footer'] = "&copy;2010 Todos los derechos reservados.  &#149;  Dise&ntilde;ado por InteligenciaMec&aacute;nica.";
	$this->load->view('dist_add', $data);
	}
	
	function insert()
	{
	$this->dx_auth->check_uri_permissions();
	$this->db->insert('distribuidor',$_POST);
	redirect('dist');
	}
	
}

?>
