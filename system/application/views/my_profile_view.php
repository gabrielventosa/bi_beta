<html>
<head>
<title><?=$title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
		</style>

<script type="text/javascript">
		
	$(function() { 
		$('#p_change_diag').dialog({autoOpen: false,
					 width: 'auto',
					 height: 'auto',
					 modal: true});
		
		$('#p_change').click(function(){
					$('#p_change_diag').dialog('open');
					});
				
		$('#submit_password').click(function(){
					$.post('<?php echo current_url();?>/change_password', {
							old_password: $('#old_password').val(),
							new_password: $('#new_password').val(),
							confirm_new_password: $('#confirm_new_password').val() },
							function(xml_data){
									var message = $(xml_data).find('message').text();
									$('#p_change_diag').dialog('close');
									alert(message);
									}
							);
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
<?=form_open('my_profile/save');?>
<?=form_hidden('id', $this->uri->segment(3));?>

	<table>
		<tbody>
			<tr><td>Username: </td><td><input type="text" name="id" class="input" value="<?=$user->username?>" style ="text-transform: none;" DISABLED/></td></tr>
			<tr><td>Email: </td><td><input type="text" name="nombre" class="input" value="<?=$user->email?>" style ="text-transform: none;" DISABLED/></td></tr>
			<tr><td>Rol: </td><td><input type="text" name="role" class="input" value="<?=$this->dx_auth->get_role_name()?>" DISABLED/></td></tr>
			<tr><td>Ultima IP: </td><td><input type="text" name="last_ip" class="input" value="<?=$user->last_ip?>" DISABLED/></td></tr>
			<tr><td>Ultimo acceso: </td><td><input type="text" name="last_login" class="input" value="<?=($user->last_login == "0000-00-00 00:00:00") ? 'No': date('Y-m-d', strtotime($user->last_login))?>" DISABLED/></td></tr>
			<tr><td>Creado: </td><td><input type="text" name="created" class="input" value="<?=date('Y-m-d', strtotime($user->created))?>" DISABLED/></td></tr>
		</tbody>
	</table>
	<p>
		<input type ="button" class="submit" value="Cambiar Password" id="p_change"/>
	</p>
</form>
<?php endforeach; ?>

</div>

<div id="p_change_diag" title="Cambiar Password">
<?php
$old_password = array(
	'name'	=> 'old_password',
	'id'		=> 'old_password',
	'size' 	=> 30,
	'value' => set_value('old_password')
);

$new_password = array(
	'name'	=> 'new_password',
	'id'		=> 'new_password',
	'size'	=> 30
);

$confirm_new_password = array(
	'name'	=> 'confirm_new_password',
	'id'		=> 'confirm_new_password',
	'size' 	=> 30
);

?>
<fieldset>
<legend>Cambiar Password</legend>
<?php echo form_open($this->uri->uri_string()); ?>

<?php echo $this->dx_auth->get_auth_error(); ?>

<dl>
	<dt><?php echo form_label('Password anterior', $old_password['id']); ?></dt>
	<dd>
		<?php echo form_password($old_password); ?>
		<?php echo form_error($old_password['name']); ?>
	</dd>

	<dt><?php echo form_label('Password Nuevo', $new_password['id']); ?></dt>
	<dd>
		<?php echo form_password($new_password); ?>
		<?php echo form_error($new_password['name']); ?>
	</dd>

	<dt><?php echo form_label('Confirmar Password', $confirm_new_password['id']); ?></dt>
	<dd>
		<?php echo form_password($confirm_new_password); ?>
		<?php echo form_error($confirm_new_password['name']); ?>
	</dd>

	<dt></dt>
	<dd><?php echo form_button('change', 'Cambiar Password','id="submit_password" class="submit"'); ?></dd>
</dl>

<?php echo form_close(); ?>
</fieldset>
</div>

<div id="footer">
<?=$footer?>
</div>
</body>
</html>