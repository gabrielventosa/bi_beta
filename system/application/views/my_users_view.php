<html>
<head>
<title><?=$title?></title>
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

<script type="text/javascript">
	$(document).ready(function() {
		$('#sort_table').dataTable({
			"oLanguage": { 
				"sUrl": "<?php echo base_url();?>js/dataTables-1.6/media/language/ES_mx.txt"} });
	});
</script>
</head>

<body>
<?php echo $header; ?>
<?php echo $menu; ?>
<h1 id="header_left"><?=$heading?></h1>

<?php if(count($users) >0): ?>
<div  style='position:relative; margin-left:auto; margin-right:auto;'>
<table style="text-align: left; position: relative; width: 100%; float:left;"
 cellpadding="2" cellspacing="2" id="sort_table">
	<thead>
		<tr>
		<th>Username</th>
		<th>Email</th>
		<th>Rol</th>
		<th>Bloqueado</th>
		<th>Ultima IP</th>
		<th>Ultimo Login</th>
		<th>Creado</th>
		<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($users as $user): ?>
			<tr>
			<td style ="text-transform: none;"><?=$user->username?></td>
			<td style ="text-transform: none;"><?=$user->email?></td>
			<td><?=$user->role_name?></td>
			<td><?=$banned = ($user->banned == 1) ? 'Si' : 'No';?></td>
			<td><?=$user->last_ip?></td>
			<td><?=($user->last_login == "0000-00-00 00:00:00") ? 'No': date('Y-m-d', strtotime($user->last_login))?></td>
			<td><?=date('Y-m-d', strtotime($user->created))?></td>
			<td style ="text-transform: lowercase;">
			<?php if($user->role_id != 2): ?> 
					<?=anchor('my_users/edit/'.$user->id,"Editar")?>
					<?=($user->banned == 1) ? anchor('my_users/unban/'.$user->id,"/Desbloquear") : anchor('my_users/ban/'.$user->id,"/Bloquear")?>
					<?=anchor('my_users/cancel/'.$user->id,"/Eliminar")?>
			<?php endif; ?> 
			</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
</div>
<div class='spacer'></div>
<?php else: ?>
<p>No hay usuarios definidos</p>
<?php endif; ?>
<td><?=anchor('my_users/add/',"Agregar un usuario")?></td>

<div id="footer">
<?=$footer?>
</div>
</body>
</html>
