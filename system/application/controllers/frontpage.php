<?php
class Frontpage extends Controller {
	function Frontpage()
	{
		parent::Controller();
		$this->load->scaffolding('auto');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('DX_Auth');
	        $this->load->library('MyMenu');	
		$this->load->library('MyHeader');
		$this->dx_auth->check_uri_permissions();

		if($this->dx_auth->get_permission_value('auto_access_allow') == 'accept' || $this->dx_auth->is_admin()){
			redirect('/auto/', 'location');			
		}
		else if ($this->dx_auth->get_permission_value('zone_access_allow') == 'accept' || $this->dx_auth->is_admin()){
			redirect('/zona/','location');
		}
		else if ($this->dx_auth->get_permission_value('dist_access_allow') == 'accept' || $this->dx_auth->is_admin()){
			redirect('/dist/','location');
		}
		else if ($this->dx_auth->get_permission_value('inform_access_allow') == 'accept' || $this->dx_auth->is_admin()){
			redirect('/informe/','location');
		}
		else
		{
			redirect('/my_profile/','location');
		}

	}
	


}

?>
