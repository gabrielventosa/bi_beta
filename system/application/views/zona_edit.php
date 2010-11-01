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
<h1 id="header_left"><?=$heading?></h1>
<?php if ($query->num_rows() >0): ?>
<?php foreach($query->result() as $row): ?>
<?=form_open('zona/save');?>
<?=form_hidden('id', $this->uri->segment(3));?>

	<table>
		<tbody>
			<tr><td>NUMERO: </td><td><input type="text" name="id" class="input" value="<?=$row->id?>" DISABLED/></td></tr>
			<tr><td>ZONA: </td><td><input type="text" name="nombre" class="input" value="<?=$row->nombre?>"/></td></tr>
		</tbody>
	</table>
	<p><input type ="submit" value="Guardar" class="submit"/></p>
</form>
<?php endforeach; ?>
<?php else: ?>
<p>No hay zonas definidas</p>
<?php endif; ?>
</div>
<div id="footer">
<?=$footer?>
</div>
</body>
</html>
