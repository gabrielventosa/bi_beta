<?php
$username = array(
	'name'	=> 'username',
	'id'	=> 'username',
	'size'	=> 30,
	'value' => set_value('username')
);

$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30
);

$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
	'style' => 'margin:0;padding:0'
);

$confirmation_code = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8
);

?>
<html>
<head>
<title>InteligenciaMec&aacute;nica BI Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv='expires' content='-1' />
<meta http-equiv= 'pragma' content='no-cache' />


<link type="text/css" href="<?php echo base_url();?>js/jquery-ui/css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-ui/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-ui/js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/dataTables-1.6/media/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/dataTables-1.6/media/js/jquery.dataTables.js"></script>

<!--- Jquery--->
<!--- Style --->

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/dataTables-1.6/media/css/demo_table.css"/>

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

</head>

<body>
<div id='logo'>
	<span style='font-family: Gill Sans MT; font-weight: bold; font-size:16pt;'>INTELIGENCIA</span>
	<br style='font-family: Gill Sans MT;'><span style='font-family: Gill Sans MT;font-weight: bold; font-size:16pt;'>MEC&Aacute;NICA</span>
</div>

<div id='login_form' style='width:400px; float: right; margin-top:150px;'>

<fieldset><legend>Login</legend>
<?php echo form_open($this->uri->uri_string())?>

<?php echo $this->dx_auth->get_auth_error(); ?>


<dl>	
	<dt><?php echo form_label('Nombre de Usuario', $username['id']);?></dt>
	<dd>
		<?php echo form_input($username)?>
    <?php echo form_error($username['name']); ?>
	</dd>

  <dt><?php echo form_label('Password', $password['id']);?></dt>
	<dd>
		<?php echo form_password($password)?>
    <?php echo form_error($password['name']); ?>
	</dd>

<?php if ($show_captcha): ?>

	<dt>Introduzca el codigo exactamente como aparece. No hay cero.</dt>
	<dd><?php echo $this->dx_auth->get_captcha_image(); ?></dd>

	<dt><?php echo form_label('Codigo de confirmaci&oacute;n.', $confirmation_code['id']);?></dt>
	<dd>
		<?php echo form_input($confirmation_code);?>
		<?php echo form_error($confirmation_code['name']); ?>
	</dd>
	
<?php endif; ?>

	<dt></dt>
	<dd>
		<?php echo form_checkbox($remember);?> <?php echo form_label('Recordarme', $remember['id']);?> 
		<?php echo anchor($this->dx_auth->forgot_password_uri, 'Recuperar password');?> 
		<?php
			if ($this->dx_auth->allow_registration) {
				echo anchor($this->dx_auth->register_uri, 'Registrar');
			};
		?>
	</dd>

	<dt></dt>
	<dd><?php echo form_submit('login','Login');?></dd>
</dl>

<?php echo form_close()?>
</fieldset>
</div>

</body>

