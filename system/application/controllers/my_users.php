<?php
class My_users extends Controller {

// Used for registering and changing password form validation
	var $min_username = 4;
	var $max_username = 20;
	var $min_password = 4;
	var $max_password = 20;
	
	function My_users()
	{
		parent::Controller();
		$this->load->scaffolding('zona');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('DX_Auth');
		$this->load->library('MyMenu');	
		$this->load->library('MyHeader');
		$this->load->library('Form_validation');
		$this->load->model('dx_auth/users', 'users');
		$this->load->model('dx_auth/roles', 'roles');
		$this->load->model('dx_auth/permissions', 'permissions');
		$this->dx_auth->check_uri_permissions();
	}
	
	function index()
	{
		$data['title'] = "CPANEL IM";
		$data['heading'] = utf8_encode("Usuarios");
		$data['query'] = $this->db->get('zona');
		$menu  = new MyMenu;
		$header = new MyHeader;
		$data['menu'] = $menu->show_menu();
		$data['header'] = $header->show_header();
		$data['footer'] = "&copy;2010 Todos los derechos reservados.  &#149;  Dise&ntilde;ado por InteligenciaMec&aacute;nica.";
		
		
		// Search checkbox in post array
		foreach ($_POST as $key => $value)
		{
			// If checkbox found
			if (substr($key, 0, 9) == 'checkbox_')
			{
				
				if (isset($_POST['reset_pass']))
				{
					// Set default message
					$data['reset_message'] = 'Reset password failed';
				
					// Get user and check if User ID exist
					if ($query = $this->users->get_user_by_id($value) AND $query->num_rows() == 1)
					{		
						// Get user record				
						$user = $query->row();
						
						// Create new key, password and send email to user
						if ($this->dx_auth->forgot_password($user->username))
						{
							// Query once again, because the database is updated after calling forgot_password.
							$query = $this->users->get_user_by_id($value);
							// Get user record
							$user = $query->row();
														
							// Reset the password
							if ($this->dx_auth->reset_password($user->username, $user->newpass_key))
							{							
								$data['reset_message'] = 'Reset password success';
							}
						}
					}
				}
			}				
		}
		
		/* Showing page to user */
		
		// Get offset and limit for page viewing
		$offset = (int) $this->uri->segment(3);
		// Number of record showing per page
		$row_count = 9999;
		
		// Get all users
		$data['users'] = $this->users->get_all(0, $row_count)->result();
		
		//print_r($data['users']);
		// Load view
		$this->load->view('my_users_view', $data);
	}
	
	function ban()
	{
	$entry = $this->uri->segment(3);
	$this->users->ban_user($entry);
	redirect('my_users');
	}
	
	function unban()
	{
	$entry = $this->uri->segment(3);
	$this->users->unban_user($entry);
	redirect('my_users');
	}
	
	function cancel()
	{
	$entry = $this->uri->segment(3);
	$this->users->delete_user($entry);
	redirect('my_users');
	}
	
	function reset_password()
	{
	$user_id = $_POST['user_id'];

	// Set default message
		$data['auth_message'] = 'Reset password failed';
	
		// Get user and check if User ID exist
		if ($query = $this->users->get_user_by_id($user_id) AND $query->num_rows() == 1)
		{		
			// Get user record				
			$user = $query->row();
			
			// Create new key, password and send email to user
			if ($this->dx_auth->forgot_password($user->username))
			{
				// Query once again, because the database is updated after calling forgot_password.
				$query = $this->users->get_user_by_id($user_id);
				// Get user record
				$user = $query->row();
											
				// Reset the password
				if ($this->dx_auth->reset_password($user->username, $user->newpass_key))
				{							
					$data['auth_message'] = 'Reset password success';
				}
			}
		}
		$this->load->view($this->dx_auth->change_password_success_view, $data);
	}
	
	function edit()
	{
	$data['title'] = "CPANEL IM";
	$data['heading'] = utf8_encode("Editar usuario");
	$entry = $this->uri->segment(3);
	$data['users'] = $this->users->get_user_by_id($entry)->result();
	$menu  = new MyMenu;
	$header = new MyHeader;
	$data['menu'] = $menu->show_menu();
	$data['header'] = $header->show_header();
	$data['footer'] = "&copy;2010 Todos los derechos reservados.  &#149;  Dise&ntilde;ado por InteligenciaMec&aacute;nica.";
	
	$this_user=0;
	foreach ($data['users'] as $user) {
		$this_user = $user;
		}

		$role_id = $this_user->role_id;
	
	
	if($this->input->post('id')){
		
		if ($role_id <= 2){
			$rolname = 'user_'.$this_user->username;
			$role = $this->roles->get_role_by_name($rolname)->row();
			if(!$role){
				$role = $this->roles->create_role($rolname, 1);
				$role = $this->roles->get_role_by_name($rolname)->row();
			}
			$role_id = $role->id;
			$this->users->set_role($this_user->id,$role->id);
		}
					
		$permission_data = $this->permissions->get_permission_data($role_id);
		// Set value in permission data array
		$permission_data['auto_access_allow'] = $this->input->post('auto_access_allow');
		$permission_data['auto_access'] = $this->input->post('auto_access');
		$permission_data['zone_access_allow'] = $this->input->post('zone_access_allow');
		$permission_data['dist_access_allow'] = $this->input->post('dist_access_allow');
		$permission_data['inform_access_allow'] = $this->input->post('inform_access_allow');

			
			// Set permission data for role_id
		$this->permissions->set_permission_data($role_id, $permission_data);
		$this->index();	

	}
	else{
		// Default role_id that will be showed
		
		// Get permissions
		$data['auto_access_allow'] = $this->permissions->get_permission_value($role_id, 'auto_access_allow');
		$data['auto_access'] = $this->permissions->get_permission_value($role_id, 'auto_access');
		$data['zone_access_allow'] = $this->permissions->get_permission_value($role_id, 'zone_access_allow');
		$data['dist_access_allow'] = $this->permissions->get_permission_value($role_id, 'dist_access_allow');
		$data['inform_access_allow'] = $this->permissions->get_permission_value($role_id, 'inform_access_allow');
	
		$this->load->view('my_users_edit', $data);
	}

	}
		
	function add()
	{
	$data['title'] = "CPANEL IM";
	$data['heading'] = utf8_encode("Agregar una usuario nuevo");
	$menu  = new MyMenu;
	$header = new MyHeader;
	$data['menu'] = $menu->show_menu();
	$data['header'] = $header->show_header();
	$data['footer'] = "&copy;2010 Todos los derechos reservados.  &#149;  Dise&ntilde;ado por InteligenciaMec&aacute;nica.";
	if (isset($_POST['username']))
		{
			$val = $this->form_validation;
			
			// Set form validation rules			
			$val->set_rules('username', 'Username', 'trim|required|xss_clean|min_length['.$this->min_username.']|max_length['.$this->max_username.']|callback_username_check|alpha_dash');
			$val->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email|callback_email_check');
			
			
			if ($val->run())
			{	
				$user = $this->dx_auth->register($_POST['username'], $this->dx_auth->_gen_pass(), $_POST['email']);
				if($user){
					// Set success message accordingly
						if ($this->dx_auth->email_activation)
						{
							$data['auth_message'] = 'Usuario registrado exitosamente. Informaci&oacute;n para el ingreso en la cuenta de email.';
						}
						else
						{					
							$data['auth_message'] = 'You have successfully registered. '.anchor(site_url($this->dx_auth->login_uri), 'Login');
						}
						
						//$this->roles->create_role('user_'.$_POST['username'],1);
						//print_r($this->users->get_user_by_username($_POST['username'])->row()->username);
						//$this->users->set_role($this->users->get_user_by_username($_POST['username']),'user_'.$_POST['username']);
						
						// Load registration success page
						
						$this->load->view($this->dx_auth->register_success_view, $data);
					}
				}
			else {
				$this->load->view('my_users_add', $data);
				 }
		}
		
		else{
			
			$this->load->view('my_users_add', $data);
			
			}
	}

	function save_vehicles(){
			
		$selected_vehicles = $this->input->post('autoid');
		$selected_vehicles_serial = serialize($selected_vehicles);
		$entry = $this->uri->segment(3);
		$data['users'] = $this->users->get_user_by_id($entry)->result();
		$this_user=0;
		foreach ($data['users'] as $user) {
		$this_user = $user;
		}

		$role_id = $this_user->role_id;
		
		if ($role_id <= 2){
			$rolname = 'user_'.$this_user->username;
			$role = $this->roles->get_role_by_name($rolname)->row();
			if(!$role){
				$role = $this->roles->create_role($rolname, 1);
				$role = $this->roles->get_role_by_name($rolname)->row();
			}
			$role_id = $role->id;
			$this->users->set_role($this_user->id,$role->id);
		}
		
		$permission_data = $this->permissions->get_permission_data($role_id);
		// Set value in permission data array
		$permission_data['authorized_vehicles'] = $selected_vehicles_serial;
			// Set permission data for role_id
		$this->permissions->set_permission_data($role_id, $permission_data);
		$autos = $this->permissions->get_permission_value($role_id,'authorized_vehicles');
		$message['auth_message'] = 'Datos almacenados, presiones guardar en la siguiente pantalla para aplicar cambios ';
		$this->load->view('/auth/general_message_xml',$message);

	}
	

	
	
	//callback functions.
	function username_check($username)
	{
		$result = $this->dx_auth->is_username_available($username);
		if ( ! $result)
		{
			$this->form_validation->set_message('username_check', 'Username already exist. Please choose another username.');
		}
				
		return $result;
	}

	function email_check($email)
	{
		$result = $this->dx_auth->is_email_available($email);
		if ( ! $result)
		{
			$this->form_validation->set_message('email_check', 'Email is already used by another user. Please choose another email address.');
		}
				
		return $result;
	}
}

?>
