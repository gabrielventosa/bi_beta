<html>
<head>
<title><?=$title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta http-equiv='expires' content='-1' />
<meta http-equiv= 'pragma' content='no-cache' />

<link type="text/css" href="http://www.inteligenciamecanica.com/jquery-ui/css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
<script type="text/javascript" src="http://www.inteligenciamecanica.com/jquery-ui/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="http://www.inteligenciamecanica.com/jquery-ui/js/jquery-ui-1.7.2.custom.min.js"></script>
<!--- Jquery--->
<!--- Style --->
<link rel="stylesheet" type="text/css" href="http://www.inteligenciamecanica.com/styles/edit_style.css"/>
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
<?php echo $header; ?>
<?php echo $menu; ?>
<div id="center_div" class="center_div">

	<h1 id="header_left"><?=$heading?></h1>	<?=form_open('dist/insert');?>
	<?=form_hidden('id', $this->uri->segment(3));?>

		<table>
			<tbody>
				<tr><td>NOMBRE: </td><td><input type="text" class="input" name="nombre"/></td></tr>
				<tr><td>ZONA: </td><td><select  name="zona" class="select"/>
					<?php foreach($zonas->result() as $zona): ?>
						<OPTION value="<?=$zona->id?>"  /><?=$zona->nombre?>
					<?php endforeach; ?>
					</select></td></tr>
				<tr><td>CIUDAD: </td><td><input type="text" class="input" name="ciudad" /></td></tr>
				<tr><td>ESTADO: </td><td><input type="text" class="input" name="estado" /></td></tr>
				<tr><td>DIRECCI&Oacute;N: </td><td><input type="text" class="input" name="direccion" /></td></tr>
				<tr><td>NUMERO: </td><td><input type="text" class="input" name="Numero" /></td></tr>
				<tr><td>INTERIOR: </td><td><input type="text" class="input" name="interior" /></td></tr>
				<tr><td>CRUZAMIENTO: </td><td><input type="text" class="input" name="cruzamiento" /></td></tr>
				<tr><td>CP: </td><td><input type="text" class="input" name="cp" /></td></tr>
				<tr><td>TIPO: </td><td><input type="text" class="input" name="tipo" /></td></tr>
			</tbody>
		</table>
		<p><input type ="submit" class="submit" value="Guardar"/></p>
	</form>
</div>
<div id="footer">
<?=$footer?>
</div>
</body>
</html>
