<html>
<head>
<title><?=$title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<h1><?=$heading?></h1>

<?php if($query->num_rows() >0): ?>

<table style="text-align: left; width: 90%;"
 cellpadding="2" cellspacing="2">
	<tbody>
		<tr>
		<th>NUMERO</th>
		<th>NOMBRE</th>
		<th>ZONA</th>
		<th>DESDE</th>
		<th>HASTA</th>
		<th>DIAS NO LABORADOS</th>
		<th>HORAS DE RECORRIDO</th>
		<th>HORAS/DIA</th>
		<th>Acciones</th>
		</tr>
		<?php $zona = $zonas->result_array(); ?>
		<?php foreach($query->result() as $row): ?>
			<tr>
			<td><?=$row->id?></td>
			<td><?=$row->nombre?></td>
			<td><?=$zona[($row->zona)-1]["nombre"]?></td>
			<td><?=$row->desde?></td>
			<td><?=$row->hasta?></td>
			<td><?=$row->dnlaboral?></td>
			<td><?=$row->horascarretera?></td>
			<td><?=$row->horasdia?></td>
			<td><?=anchor('informe/edit/'.$row->id,"Editar")?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php else: ?>
<p>No informes  definidos</p>
<?php endif; ?>
<td><?=anchor('informe/add/',"Agregar un informe")?></td>
</body>
</html>
