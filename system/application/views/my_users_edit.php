<html>
<head>
<title><?=$title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta http-equiv='expires' content='-1' />
<meta http-equiv= 'pragma' content='no-cache' />
<!--- Jquery-->

<link type="text/css" href="http://www.inteligenciamecanica.com/jquery-ui/css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
<script type="text/javascript" src="http://www.inteligenciamecanica.com/jquery-ui/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="http://www.inteligenciamecanica.com/jquery-ui/js/jquery-ui-1.7.2.custom.min.js"></script>
<!--- Jquery--->
<!--- Style --->
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>styles/edit_style.css"/>

<style type="text/css">
			/*demo page css*/
			body{ font: 62.5% "Trebuchet MS", sans-serif; margin: 50px;}
			.demoHeaders { margin-top: 2em; }
			#dialog_link {padding: .4em 1em .4em 20px;text-decoration: none;position: relative;}
			#dialog_link span.ui-icon {margin: 0 5px 0 0;position: absolute;left: .2em;top: 50%;margin-top: -8px;}
			#ShowHideMarkers {padding: .4em 1em .4em 20px;text-decoration: none;position: relative;}
			#ShowHideMarkers span.ui-icon {margin: 0 5px 0 0;position: absolute;left: .2em;top: 50%;margin-top: -8px;}
			#ReturnButton {padding: .4em 1em .4em 20px;text-decoration: none;position: relative;}
			#ReturnButton span.ui-icon {margin: 0 5px 0 0;position: absolute;left: .2em;top: 50%;margin-top: -8px;}
			ul#icons {margin: 0; padding: 0;}
			ul#icons li {margin: 2px; position: relative; padding: 4px 0; cursor: pointer; float: left;  list-style: none;}
			ul#icons span.ui-icon {float: left; margin: 0 4px;}

			#sortable1, #sortable2 { list-style-type: none; margin: 0; padding: 0; float: left; margin-right: 10px; }
			#sortable1 li, #sortable2 li { margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; width: 120px; }
	

		</style>

<script type="text/javascript">
		
	$(function() { 
		$('.modal_dialog').dialog({autoOpen: false,
					 width: 'auto',
					 height: 'auto',
					 modal: true});
		
		$('#p_change').click(function(){
					$('#p_change_diag').dialog('open');
					$.post('<?php echo current_url();?>/../../reset_password', {
						user_id:<?=$this->uri->segment(3) ?> },
							function(xml_data){
									var message = $(xml_data).find('message').text();
									$('#p_change_diag').dialog('close');
									alert(message);
									}
							);
					});
					
		$("#tabs").tabs();
		$('#permissions_tab').click(function(){
				$('.permission_details').hide();
				$('.permission_control').each(function(){
					$(this).find('input:checkbox:checked').each(function(){
						$(this).parent().find('.permission_details').slideDown();
					});
				});
		});
		
		$('.permission_enable_button').click(function(){
			if ($(this).is(':checked')){
				$(this).parent().find('.permission_details').slideDown();
				 }
			else{
				$(this).parent().find('.permission_details').slideUp();
			}
		});
		
		$('#select_autos_button').click(function(){
			$('#sortable1').empty();
			$('#sortable2').empty();
			$('#sortable1').append('<li class ="ui-state-default ui-state-disabled">Vehículos Disponibles</li>');
			$('#sortable2').append('<li class ="ui-state-default ui-state-disabled">Permitir Acceso</li>');
			$('#select_autos_diag').dialog('open');
			$.post('<?php echo site_url("auto/get_all_vehicles")?>', { } ,
				function(xml_data){
					var message = $(xml_data).find('vehicle').each(function(){
						var auto = "<li class='ui-state-default' id='autoid_"+$(this).find('id').text() 
							+"'>"+$(this).find('modelo').text()+ " "+ $(this).find('placas').text()+"</li>";
						$('#sortable1').append(auto);
					});
				$("#sortable1, #sortable2").sortable({
					connectWith: '.connectedSortable',
					items: 'li:not(.ui-state-disabled)'
					}).disableSelection();
			
				},'xml');
					

		});
	
		$('#select_autos_save').click(function(){
			$('#sortable1').sortable("refresh");
			var data = $('#sortable2').sortable("serialize");
			$.post('<?php echo site_url('my_users/save_vehicles/'.$this->uri->segment(3))?>', data, function(xml_data){
				var message = $(xml_data).find('message').text();
				alert(message);
			$('#select_autos_diag').dialog('close');
			},'xml');
			$('#select_autos_button').find(':radio').attr('checked',true);
		});


	});
				
					 
</script>
</head>
<body>
<?php echo $header; ?>
<?php echo $menu; ?>

<div id="center_div" class="center_div">
<h1 id="header_left"><?=$heading?></h1>

<?php foreach($users as $user): ?>
<?=form_open('my_users/edit/'.$user->id);?>
<?=form_hidden('id', $this->uri->segment(3));?>

<div id="tabs" style="background:none">
	<ul style="background:none no-repeat scroll left top #DE2600">
		<li><a href="#tab1">Datos Generales</a></li>
		<li><a href="#tab2" id="permissions_tab">Permisos</a></li>
	</ul>
	
	<div id="tab1">
	<table>
		<tbody>
			<tr><td>Username: </td><td><input type="text" name="id" class="input" value="<?=$user->username?>" style ="text-transform: none;" DISABLED/></td></tr>
			<tr><td>Email: </td><td><input type="text" name="nombre" class="input" value="<?=$user->email?>" style ="text-transform: none;" /></td></tr>
			<tr><td>Rol: </td><td><input type="text" name="role" class="input" value="<?=$this->roles->get_role_by_id($user->role_id)->row()->name?>" DISABLED/></td></tr>
			<tr><td>Ultima IP: </td><td><input type="text" name="last_ip" class="input" value="<?=$user->last_ip?>" DISABLED/></td></tr>
			<tr><td>Ultimo acceso: </td><td><input type="text" name="last_login" class="input" value="<?=($user->last_login == "0000-00-00 00:00:00") ? 'No': date('Y-m-d', strtotime($user->last_login))?>" DISABLED/></td></tr>
			<tr><td>Creado: </td><td><input type="text" name="created" class="input" value="<?=date('Y-m-d', strtotime($user->created))?>" DISABLED/></td></tr>
		</tbody>
	</table>
	</div>
	<div id="tab2" >
	<table>
		<tbody>
			<tr><td style ="text-transform: none;">Acceso a Vehículos: </td><td style="width: 600px;text-transform: none;" class="permission_control"><?php 
											$check = ($auto_access_allow == 'accept') ? TRUE : FALSE;
											$data=array(
											'name'=>'auto_access_allow',
											'class'=>'permission_enable_button',
											'value'=>'accept',
											'checked'=>$check);
											echo form_checkbox($data);?>Habilitar
								<div id="auto_permissions" class="permission_details">
								<p style="font-size:90%;">&nbsp&nbsp&nbsp<?php echo form_radio('auto_access', 'all', ($auto_access == 'all') ? TRUE : FALSE);?>Todos</p>
								<p style="font-size:90%;" id="select_autos_button">&nbsp&nbsp&nbsp<?php echo form_radio('auto_access', 'selected', ($auto_access == 'selected') ? TRUE : FALSE);?>Editar   </p>
								</div>
								</td></tr>
			<tr><td style ="text-transform: none;">Acceso a Zonas: </td><td  style="width: 600px;text-transform: none;" class="permission_control"><?php
											$check = ($zone_access_allow == 'accept') ? TRUE : FALSE;																	$data=array(
											'name'=>'zone_access_allow',
											'class'=>'permission_enable_button',
											'value'=>'accept',
											'checked'=>$check);
											echo form_checkbox($data);?>Habilitar
								<div id="zone_permissions" class="permission_details">
								<p style="font-size:90%;">&nbsp&nbsp&nbsp<?=form_radio('zone_access_write', 'accept', TRUE)?>Solo lectura </p>
								<p style="font-size:90%;">&nbsp&nbsp&nbsp<?=form_radio('zone_access_write', 'accept', FALSE)?>Editar   </p>
								</div>
								</td></tr>
			<tr><td style ="text-transform: none;">Acceso a Distribuidores: </td><td  style="width: 600px;text-transform: none;" class="permission_control"><?php
											$check = ($dist_access_allow == 'accept') ? TRUE : FALSE;
											$data=array(
												'name'=>'dist_access_allow',
												'class'=>'permission_enable_button',
												'value'=>'accept',
												'checked'=>$check);
											echo form_checkbox($data);?>Habilitar
								<div id="dist_permissions" class="permission_details">
								<p style="font-size:90%;">&nbsp&nbsp&nbsp<?=form_radio('dist_access_write', 'accept', TRUE)?>Solo lectura </p>
								<p style="font-size:90%;">&nbsp&nbsp&nbsp<?=form_radio('dist_access_write', 'accept', FALSE)?>Editar   </p>
								</div>
								</td></tr>
								<tr><td style ="text-transform: none;">Acceso a Informes: </td><td  style="width: 600px;text-transform: none;" class="permission_control"><?php
											$check = ($inform_access_allow == 'accept') ? TRUE : FALSE;
											$data=array(
												'name'=>'inform_access_allow',
												'class'=>'permission_enable_button',
												'value'=>'accept',
												'checked'=>$check);
											echo form_checkbox($data);?>Habilitar
								<div id="inform_permissions" class="permission_details">
								<p style="font-size:90%;">&nbsp&nbsp&nbsp<?=form_radio('inform_access_write', 'accept', TRUE)?>Solo lectura  </p>
								<p style="font-size:90%;">&nbsp&nbsp&nbsp<?=form_radio('inform_access_write', 'accept', FALSE)?>Editar    </p>
								</div>
								</td></tr>
		</tbody>
	</table>
	</div>
</div>
	<p>
		<input type ="submit" class="submit" value="Guardar"/>
		<input type ="button" class="submit" value="Resetear Password" id="p_change"/>
	</p>
</form>
<?php endforeach; ?>

</div>

<div id="p_change_diag"  class="modal_dialog" title="Restablecer Password">
<p id="change_diag_msg">Restableciendo Password...<p>
</div>
<div id="select_autos_diag" class="modal_dialog" title="Seleccione Vehículos">
<div id="vehicle_list" >
<ul id="sortable1" class="connectedSortable">
<li class ="ui-state-default ui-state-disabled">
Mis Vehículos disponibles
</li>
</ul>
<ul id="sortable2" class="connectedSortable" >
<li class ="ui-state-default ui-state-disabled">
Permitir Acceso
</li>
</ul>
<input type ="button" class="submit" value="Guardar" id="select_autos_save"/>
</div>
</div>


<div id="footer">
<?=$footer?>
</div>
</body>
</html>
