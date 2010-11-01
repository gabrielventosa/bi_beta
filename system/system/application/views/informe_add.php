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
<!--- Jquery function ---->

<script type="text/javascript">
	$(function(){
	
		$('.date_input').datepicker({
					numberOfMonths: 3,
					showButtonPanel: true,
					dateFormat: 'D, d M yy'
				});
		
		$('.date_input').change(function(){
					var date = new Date($(this).datepicker('getDate'));
					var Year = date.getFullYear();
					var Month = date.getMonth()+1;
					var Day = date.getDate();
					Day = (Day<10)?'0'+Day:Day;
					Month = (Month<10)?'0'+Month:Month;
					var DateString = Year+'-'+Month+'-'+Day;
					$(this).val(DateString);
					});
				
		$('#add_nday').live('change',function(){
						var current_days = $('#nday_container').html();
						var date = new Date($('#add_nday').datepicker('getDate'));
						var days= current_days + 
						'<p style="font-size:90%">'+ date.toLocaleDateString() +
						'<a href="#" class="del_date"><span style="font-size:90%;color:red;float: right">|Borrar</span></a>' +
						'</p>';
						$('#nday_container').html(days);
						$('#add_nday').val($('#nday_container').children().length);
										}
					);
					
		$('.del_date').live('click',function(){
								$(this).parent().remove();
								}
					);
								
	
	});
</script>

<!--- Jquery function ---->
</head>
<body>
<div id="center_div" class="center_div">
<h1><?=$heading?></h1>
<?=form_open('informe/insert');?>

	<table>
		<tbody>
			<tr><td>NOMBRE: </td><td><input type="text" name="nombre" class="input" /></td></tr>
			<tr><td>ZONA: </td><td><select  name="zona" class="select" />
				<?php foreach($zonas->result() as $zona): ?>
					<OPTION value="<?=$zona->id?>"/><?=$zona->nombre?>
				<?php endforeach; ?>
				</select></td></tr>
			<tr><td>DESDE: </td><td><input type="text" name="desde" class="date_input"/></td></tr>
			<tr><td>HASTA: </td><td><input type="text" name="hasta" class="date_input"/></td></tr>
			<tr><td>DIAS NO LABORADOS: </td><td><input type="text" id= "add_nday" class="date_input" name="dnlaboral"/>
							<div id="nday_container">
							</div></td></tr>
			<tr><td>HORAS DE RECORRIDO: </td><td><input type="text" class="input" name="horascarretera"/></td></tr>
			<tr><td>HORAS/DIA: </td><td><input type="text" class="input" name="horasdia"/></td></tr>
		</tbody>
	</table>
	<p><input type ="submit" value="Guardar" class="submit" /></p>
</form>
</div>
</body>
</html>
