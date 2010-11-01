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

	//Global variables
	var idate;
	var edate;
	var days;
	var rdays;
	var i=0;
	var ServerArray = new Array();
	var nLaborarray = new Array();
	var imei;
	var period_days = 0;
	
	
	Array.prototype.DateExist = function (date){
			var ret= false;
			for( var i=0;i<this.length;i++){
					if(this[i].toDateString() == date.toDateString()){
					ret = true;
					break;
					}
				}
			return ret;
			}
	
	Array.prototype.DateRemove = function (date){
			var ret= false;
			for( var i=0;i<this.length;i++){
					if(this[i].toDateString() == date.toDateString()){
					this.splice(i,1);
					ret = true;
					break;
					}
				}
			return ret;
			}
	
	function XMLDateObject(){
		this.dateObj =new Date();
		this.KM=0;
		this.Segs=0;
		this.rdate="No date";
		
		}
	$(function(){
			
		$('.date_input').datepicker({
					numberOfMonths: 3,
					showButtonPanel: true,
					dateFormat: 'D, d M yy'	
				});
				
		$('#add_nday').datepicker({
					numberOfMonths: 3,
					showButtonPanel: true,
					dateFormat: 'D, d M yy'	
				});
				
		$('#zone_selector').change(function(){
					$('#z_asign_info').slideUp();
					$("#progressbar").hide();
					$.post("http://www.inteligenciamecanica.com/ci/index.php/zona/ajax_zinfo", { zid: $('#zone_selector').val()},function(xml_data){
										$(xml_data).find("zona").each(function() {
												var modelo = $(this).find('MODELO').text();
												var usuario = $(this).find('USUARIO').text();
												var num_zonas = $(this).find('NUMDIST').text();
												imei = $(this).find('imei').text();
												$('#z_asign_vmodel').html(modelo);
												$('#z_asign_user').html(usuario);
												$('#z_dist_num').html(num_zonas);
												$('#z_asign_info').slideDown();
												});
										},'xml');
					});
		
		$('#zone_selector').trigger('change');
		
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
		
				
		$('#add_nday').change(function(){
						var date = new Date($('#add_nday').datepicker('getDate'));
						var date1 = $('#date1').val().split('-');
						var date2 = $('#date2').val().split('-');
						idate = new Date;
						idate.setFullYear(parseInt(date1[0]),parseInt(date1[1])-1,parseInt(date1[2]));
						edate = new Date;
						edate.setFullYear(parseInt(date2[0]),parseInt(date2[1])-1,parseInt(date2[2]));
						if(!nLaborarray.DateExist(date) && date >= idate && date <= edate){
								nLaborarray.push(date);
								var days= '<p style="font-size:90%" class="del_date">'+ date.toLocaleDateString() +
								'<a href="#"><span style="font-size:90%;color:red;float: right">|Borrar</span></a>' +
								'</p>';
								$('#nday_container').append(days);
								//$('#nday_container').html(days);
								$('#nday_container').children('p:last').data('date',date);
								}
						$('#add_nday').val($('#nday_container').children().length);
						}
					);
					
		$('.del_date').live('click',function(){
								nLaborarray.DateRemove( $(this).data('date'));
								$(this).remove();
								$('#add_nday').val($('#nday_container').children().length);
								}
					);
		
		
		$("#dialog").dialog({
					bgiframe: true,
					height: 160,
					autoOpen: false,
					modal: false,
					title: 'Progreso de busqueda'
					});
		
				
				$("#progressbar").progressbar({
								value: 0
				});
				
				
		$("#progressbar").bind('progressbarchange', function(){
						if (rdays == days){
								$("#dialog").dialog('close');
								var totalKM =0;
								var totalHrs =0;
								var totalSegs =0;
								for (i=0;i<ServerArray.length;i++){
									totalSegs += parseInt(ServerArray[i].Segs);
									}
								totalHrs = totalSegs/3600
								$('#gpstime').val(totalHrs.toFixed(3));
								} 
						});		

		$('#hrsaval').click(function() {
						var horasdia = $('#horasdia').val();
						var hrsaval = horasdia * period_days;
						$(this).val(hrsaval);
						});
		
		$('#hrsfood').click(function() {
						$(this).val(period_days);
						});
							
		$('#realhrs').click(function() {
						$(this).val($('#hrsaval').val() - $('#hrsfood').val());
						});
		
		$('#gpsdata_button').click(function() {
				$("#progressbar").show();
				period_days = 0;
				var date1 = $('#date1').val().split('-');
				var date2 = $('#date2').val().split('-');
				idate = new Date;
				idate.setFullYear(parseInt(date1[0]),parseInt(date1[1])-1,parseInt(date1[2]));
				edate = new Date;
				edate.setFullYear(parseInt(date2[0]),parseInt(date2[1])-1,parseInt(date2[2]));
				days = (((edate -idate)/(3600*1000*24))+1)|0;
				rdays = 0;
				$("#progressbar").progressbar('value',0);
				//$("#dialog").dialog('open');
				for (i=0;i<days;i++){
					var requestDate=new Date(idate);
					requestDate.setDate(requestDate.getDate()+i);
					requestDate.setHours(0,0,0,0);
					var Year = requestDate.getFullYear();
					var Month = requestDate.getMonth()+1;
					var Day = requestDate.getDate();
					if(((requestDate.getDay()==6 ||requestDate.getDay()==0) && !($("#weekends").is(":checked"))) || nLaborarray.DateExist(requestDate)){
							ServerArray[i]= new XMLDateObject();
							ServerArray[i].KM ="0";
							ServerArray[i].Segs ="0";
							ServerArray[i].rdate ="0";
							var Progress = $("#progressbar").progressbar('option','value');
							Progress += 100/days;
							rdays++;
							$("#progressbar").progressbar('value',Progress);
							}
					else {
							period_days++;
							Day = (Day<10)?'0'+Day:Day;
							Month = (Month<10)?'0'+Month:Month;
							var DateString = Year+'-'+Month+'-'+Day;
							ServerArray[i]= new XMLDateObject();
							ServerArray[i].dateObj = requestDate;
							$.post("http://www.inteligenciamecanica.com/ubi-car/Statistics/ci_test.php", { idate: DateString, rindex: i, imei: imei},function(xml_data){
								var KM = parseFloat($(xml_data).find('distance').text());
								var Segs = parseFloat($(xml_data).find('elaptime').text());
								var rdate = $(xml_data).find('date').text();
								var rindex = parseInt($(xml_data).find('rindex').text());
								$('#date_dialog_text').html('Kilometros: '+ KM);
								$('#date_dialog_segs').html('Segundos: '+ Segs);
								$('#date_dialog_date').html('Fecha: '+ rdate);
								ServerArray[rindex].KM =KM;
								ServerArray[rindex].Segs =Segs;
								ServerArray[rindex].rdate =rdate;
								var Progress = $("#progressbar").progressbar('option','value');
								Progress += 100/days;
								rdays++;
								$("#progressbar").progressbar('value',Progress);}
								,'xml');
							}
						}
				
				});
	
	});
	
	
</script>

<!--- Jquery function ---->
</head>
<body>
<div id="center_div" class="center_div">
<h1><?=$heading?></h1>
<?php if ($query->num_rows() >0): ?>
<?php foreach($query->result() as $row): ?>
<?=form_open('informe/save');?>
<?=form_hidden('id', $this->uri->segment(3));?>

	<table>
		<tbody>
			<tr><td>NUMERO: </td><td><input type="text" name="id" class="input" value="<?=$row->id?>" DISABLED/></td></tr>
			<tr><td>NOMBRE: </td><td><input type="text" name="nombre" class="input" value="<?=$row->nombre?>" /></td></tr>
			<tr><td>ZONA: </td><td><select  id="zone_selector" name="zona" class="select" />
				<?php foreach($zonas->result() as $zona): ?>
					<OPTION value="<?=$zona->id?>" 
					<?php if($row->zona == $zona->id): ?>
							selected
							<?php endif;?> /><?=$zona->nombre?>
				<?php endforeach; ?>
				</select>
				<div id="z_asign_info">
					<p style="font-size:90%;color:blue;float: left">
									   Auto: <span id="z_asign_vmodel"></span>
									   Usuar&iacute;o: <span id="z_asign_user"></span>
									   No. de dist: <span id="z_dist_num"></span>
					</p>
						<div id="progressbar"></div>
				</div></td></tr>
			<tr><td>DESDE: </td><td><input type="text" name="desde" id="date1" class="date_input" value="<?=$row->desde?>"/></td></tr>
			<tr><td>HASTA: </td><td><input type="text" name="hasta" id="date2" class="date_input" value="<?=$row->hasta?>"/></td></tr>
			<tr><td>DIAS NO LABORADOS: </td><td><input type="text" id= "add_nday" class="input" name="dnlaboral" value="<?=$row->dnlaboral?>"/>
							<div id="nday_container">
							</div></td></tr>
			<tr><td>HORAS DE RECORRIDO: </td><td>
			<table style="border:0px; widht:100%">
			<tr><td><input type="text" id="gpstime" class="input" name="horascarretera" value="<?=$row->horascarretera?>" style="width:300px"/></td>
			<td><input id="weekends" type="checkbox"><span style="font-size: 10px">Incluir Sabados y Domingos.</span></td>
			<td><a href="#" id="gpsdata_button" style="font-size:90%;color:red;float: right">|GPS</a></td></tr></table>
			</td></tr>
			<tr><td>HORAS/DIA: </td><td><input type="text" id="horasdia" class="input" name="horasdia" value="<?=$row->horasdia?>"/></td></tr>
			<tr><td>HORAS DISPONIBLES: </td><td><input type="text" id="hrsaval" class="input" name="hrsaval"/></td></tr>
			<tr><td>HORAS ALIMENTOS: </td><td><input type="text" id="hrsfood" class="input" name="hrsfood"/></td></tr>
			<tr><td>HORAS REALES: </td><td><input type="text" id="realhrs" class="input" name="realhrs" /></td></tr>
			<tr><td>HORAS CON DISTRIBUIDOR: </td><td><input type="text" id="disthrs" class="input" name="disthrs" /></td></tr>
		</tbody>
	</table>
	<p><input type ="submit" value="Guardar" class="submit" /></p>
</form>
<?php endforeach; ?>
<?php else: ?>
<p>No hay informes definidos</p>
<?php endif; ?>
</div>

<div id="dialog" title="Basic modal dialog">
	<p id="date_dialog_date">Fecha</p>
	<p id="date_dialog_text">Kilómetros</p>
	<p id="date_dialog_segs">Segundos</p>
</div>

</body>
</html>
