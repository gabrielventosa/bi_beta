<?php
class My_profile extends Controller {
	
	var $min_username = 4;
	var $max_username = 20;
	var $min_password = 4;
	var $max_password = 20;
	
	function My_profile()
	{
		parent::Controller();
		$this->load->scaffolding('zona');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('DX_Auth');
		$this->load->library('MyMenu');	
		$this->load->library('MyHeader');
		$this->load->library('Table');
		$this->load->library('Form_validation');

		$this->dx_auth->check_uri_permissions();
	}
	function index()
	{
	$this->load->model('dx_auth/users', 'users');	
	$my_ID = $this->dx_auth->get_user_id();
	$data['users'] = $this->users->get_user_by_id($my_ID)->result();
	$data['title'] = "CPANEL IM";
	$data['heading'] = utf8_encode("Mi Perfil");
	$menu  = new MyMenu;
	$header = new MyHeader;
	$data['menu'] = $menu->show_menu();
	$data['header'] = $header->show_header();
	$data['footer'] = "&copy;2010 Todos los derechos reservados.  &#149;  Dise&ntilde;ado por InteligenciaMec&aacute;nica.";
	$this->load->view('my_profile_view', $data);
	}
	
	
	function change_password()
	{	
		
		// Check if user logged in or not
		if ($this->dx_auth->is_logged_in())
		{			
			$val = $this->form_validation;
			
			// Set form validation
			$val->set_rules('old_password', 'Old Password', 'trim|required|xss_clean|min_length['.$this->min_password.']|max_length['.$this->max_password.']');
			$val->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->min_password.']|max_length['.$this->max_password.']|matches[confirm_new_password]');
			$val->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean');
			
			// Validate rules and change password
			if ($val->run() AND $this->dx_auth->change_password($val->set_value('old_password'), $val->set_value('new_password')))
			{
				$data['auth_message'] = 'Password cambiado exitosamente.';
				$this->load->view($this->dx_auth->change_password_success_view, $data);
			}
			else
			{
				$data['auth_message'] = 'Error en datos.';
				$this->load->view($this->dx_auth->change_password_success_view, $data);
			}
		}
		else
		{
			// Redirect to login page
			$this->dx_auth->deny_access('login');
		}
	}	
}

?>
