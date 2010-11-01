<?php
class MyMenu{
   function show_menu(){
		$obj =& get_instance();
		$obj->load->helper('url');
		$obj->load->library('DX_Auth');

		$menu = "<div id='siteNav'>";
		$menu  .= "<ul>";
		if($obj->dx_auth->get_permission_value('auto_access_allow') == 'accept' || $obj->dx_auth->is_admin()){
		$menu .= "<li>";
		$menu .= anchor("auto","Mis Veh&iacute;culos");
		$menu .= "</li>";
		}
		if($obj->dx_auth->get_permission_value('zone_access_allow') == 'accept' || $obj->dx_auth->is_admin()){		
		$menu .= "<li>";     
		$menu .= anchor("zona","Mis Zonas");       
		$menu .= "</li>";
		}
		if($obj->dx_auth->get_permission_value('dist_access_allow') == 'accept' || $obj->dx_auth->is_admin()){		
		$menu .= "<li>";
		$menu .= anchor("dist","Mis Distribuidores");
		$menu .= "</li>";
		}
		if($obj->dx_auth->get_permission_value('informe_access_allow') == 'accept' || $obj->dx_auth->is_admin()){		
		$menu .= "<li>";
		$menu .= anchor("informe","Mis Informes");
		$menu .= "</li>";
		}
		$menu .= '<li style="float: right;">';
		$menu .= anchor("auth/logout", "Logout");
		$menu .= "</li>";
		$menu .= '<li style="float: right;">';
		$menu .= anchor("my_profile", "Usuario: ".$obj->dx_auth->get_username());
		$menu .= "</li>";
		if($obj->dx_auth->is_admin()){
			$menu .= '<li style="float: right;">';
			$menu .= anchor("my_users", "Usuarios");
			$menu .= "</li>";
			}
		$menu .= "</ul>";
		$menu .="</div>";
		return $menu;
		}
	}
?>
