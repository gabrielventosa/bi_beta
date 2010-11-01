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
<link rel="stylesheet" type="text/css" href="http://www.inteligenciamecanica.com/styles/edit_style.css"/>

</head>
<body>
<div id="center_div" class="center_div">
<h1><?=$heading?></h1>

<?php foreach($query->result() as $row): ?>
<?=form_open('auto/save');?>
<?=form_hidden('id', $this->uri->segment(3));?>

	<table>
		<tbody>
			<tr><td>MODELO: </td><td><input type="text" name="modelo" class="input" value="<?=$row->MODELO?>" DISABLED/></td></tr>
			<tr><td>PLACAS: </td><td><input type="text" name="placas" class="input" value="<?=$row->PLACAS?>" DISABLED/></td></tr>
			<tr><td>GPS SERIE:</td><td><input type="text" name="imei" class="input" value="<?=$row->imei?>" DISABLED/></td></tr>
			<tr><td>USUARIO: </td><td><input type="text" name="usuario" class="input" value="<?=$row->USUARIO?>"/></td></tr>
			<tr><td>ZONA: </td><td><select  name="zona" class="select"/>
				<?php foreach($zonas->result() as $zona): ?>
					<OPTION value="<?=$zona->id?>" 
					<?php if($row->ZONA == $zona->id): ?>
							selected
							<?php endif;?> /><?=$zona->nombre?>
				<?php endforeach; ?>
				</select></td></tr>
		</tbody>
	</table>
	<p><input type ="submit" value="Guardar" class="submit"/></p>
</form>
<?php endforeach; ?>
</div>
</body>
</html>
