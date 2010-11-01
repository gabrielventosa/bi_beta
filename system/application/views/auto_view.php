<html>
<head>
<title><?=$title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv='expires' content='-1' />
<meta http-equiv= 'pragma' content='no-cache' />
<!---
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAA6VPcVzDMqz0sgSNQ1nNpJhT7iu-aH7t0l1YuL6uiYulVE1zxKhT36G3r3dKUgE_qEAxV1PeJDsK8kA" type="text/javascript"></script>
-->
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<!--- Jquery-->
<link type="text/css" href="<?php echo base_url();?>js/jquery-ui-1.8.2.custom/css/ui-lightness/jquery-ui-1.8.2.custom.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-ui-1.8.2.custom/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-ui-1.8.2.custom/js/jquery-ui-1.8.2.custom.min.js"></script> 
<!--- Jquery --->
<script type="text/javascript" src="<?php echo base_url();?>js/dataTables-1.6/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.hotkeys-0.7.9/jquery.hotkeys.js"></script>


<!--- JQuery Google MAPS  
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.googlemaps/jquery.googlemaps1.01.js"></script> -->


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
			.geo_field {text-transform: none; font-size:80%;color:blue;border:solid blue thin;}
		</style>

<script type="text/javascript">

jQuery.fn.slideBlink = function() {
	this.slideDown();
	var element = this;
	window.setTimeout(function(){
		element.slideUp();
	},3000);
	return this;
}

jQuery.fn.center = function () {
    this.css("position","absolute");
    this.css("top", ( $(window).height() - this.height() ) / 2+$(window).scrollTop() + "px");
    this.css("left", ( $(window).width() - this.width() ) / 2+$(window).scrollLeft() + "px");
    return this;
}

	$(document).ready(function() {
		$('#sort_table').dataTable({
			"oLanguage": { 
				"sUrl": "<?php echo base_url();?>js/dataTables-1.6/media/language/ES_mx.txt"} });

		$(document).bind('keydown', 'ctrl+c', function(evt){$('.geo').slideUp(); return false;});
		$(document).bind('keydown', 'shift+c', function(evt){$('.geo').slideDown(); return false;});
				

	});

	$(function() {
		$('.geo').hide();
		
		$('.geo').live('position_update', function(){
			var d_name = $(this).parents('td:first').find('.driver_name').html();
			var mapcanvas = $(this).find('.map_canvas').first();
			var marker = $(this).data('vehicle_marker');
			if (marker) {
				var polyline_array = $(this).data('polyline_array');
				var last_gps_info = $(this).data('last_gps_info');
				var latlng = new google.maps.LatLng(last_gps_info.latitude, last_gps_info.longitude);
				marker.setPosition(latlng);
				polyline_array.push(latlng);	
				var image;
				var marker_title = d_name;
			
				if (last_gps_info.dyn == '1'){
					image =new google.maps.MarkerImage('http://www.inteligenciamecanica.com/ubi-car/Historial/icons/dd-start.png',
						new google.maps.Size(20, 32),
						new google.maps.Point(0,0),
						new google.maps.Point(10, 32));
						marker_title = marker_title + ' '+ last_gps_info.speed+' Km/hr';
					
				}else{
					image =new google.maps.MarkerImage('http://www.inteligenciamecanica.com/ubi-car/Historial/icons/dd-end.png',	
						new google.maps.Size(20, 32),
						new google.maps.Point(0,0),
						new google.maps.Point(10, 32));
				}
				marker.setIcon(image);
				marker.setTitle(marker_title);
			}


		});

	
		var update_handler = function(myDiv){
			var last_gps_info = myDiv.data('last_gps_info');
			
			if (last_gps_info.id){
			$.post('<?php echo site_url("auto/get_vehicle_gpspos_xml")?>', {id: last_gps_info.id},
				function(xml_data){
					var last_gps_info = myDiv.data('last_gps_info');
					update_time = $(xml_data).find('timestamp').text();
					var posicion = "<p>Latitud: <span class='latitude'> " + $(xml_data).find('latitud').text() + "</span> Longitud: <span class='longitude'>" 
						+ $(xml_data).find('longitud').text()+"</span>"+
						'<span class="ShowMap" style="font-size:99%;color:red;float: right; cursor: pointer">|Mapa</span></p>';

					if(update_time != last_gps_info.timestamp){ 
						var latitude = myDiv.find('.latitude').html();
						var longitude = myDiv.find('.longitude').html();
						var last_gps_info = new Object();
						last_gps_info.latitude = latitude;
						last_gps_info.longitude = longitude;
						last_gps_info.id = $(xml_data).find('id').text();
						last_gps_info.timestamp = update_time;
						last_gps_info.speed = $(xml_data).find('speed').text();
						last_gps_info.course = $(xml_data).find('course').text();
						last_gps_info.dyn = $(xml_data).find('dyn').text();
						myDiv.data('last_gps_info',last_gps_info);
					
						var status_string = '<span style="font-size:99%;color:red; float: right">'+ ((last_gps_info.dyn==1)?'<span style="color:green">En movimiento a '+
					       	last_gps_info.speed+'Km/hr</span>':'Detenido') +'</span>';
						posicion = posicion+"<p>Actualizado: "+ update_time+ status_string+"</p>";
						myDiv.html(posicion);
						var data="lat="+last_gps_info.latitude+"&lng="+last_gps_info.longitude;
						$.get('http://ws.geonames.org/findNearbyPlaceName', data,
							function(google_data){
								var formated_address = $(google_data).find('name').text() + ' '+ 
									$(google_data).find('countryName').text();
							myDiv.append('<p class="humman_address">'+formated_address+'</p>');
							},'xml');

						myDiv.slideBlink();
						myDiv.trigger('position_update');
					}
					if (last_gps_info.dyn == '1'){
							window.setTimeout(function() {
 							update_handler(myDiv);
							}, 10000);
					}else{
						window.setTimeout(function() {
 							update_handler(myDiv);
						}, 200000);
					}

				},'xml');
				}
		
		}


		$('.geo').each(function(){
			var myDiv = $(this);
			$.post('<?php echo site_url("auto/get_vehicle_gpspos_xml")?>', {id: $(this).attr('id').split('_')[1]},
				function(xml_data){
					update_time = $(xml_data).find('timestamp').text();
					var posicion = "<p>Latitud: <span class='latitude'> " + $(xml_data).find('latitud').text() + "</span> Longitud: <span class='longitude'>" 
						+ $(xml_data).find('longitud').text()+"</span>"+
						'<span class="ShowMap" style="font-size:99%;color:red;float: right; cursor: pointer;">|Mapa</span></p>';
					myDiv.slideDown();
					var latitude = myDiv.find('.latitude').html();
					var longitude = myDiv.find('.longitude').html();
					var last_gps_info = new Object();
					last_gps_info.latitude = latitude;
					last_gps_info.longitude = longitude;
					last_gps_info.id = $(xml_data).find('id').text();
					last_gps_info.timestamp = update_time;
					last_gps_info.speed = $(xml_data).find('speed').text();
					last_gps_info.course = $(xml_data).find('course').text();
					last_gps_info.dyn = $(xml_data).find('dyn').text();
					myDiv.data('last_gps_info',last_gps_info);
					var data="lat="+$(xml_data).find('latitud').text()+"&lng="+$(xml_data).find('longitud').text();
					var status_string = '<span style="font-size:99%;color:red; float: right">'+ ((last_gps_info.dyn==1)?'<span style="color:green">En movimiento a '+ last_gps_info.speed+'Km/hr</span>':'Detenido') +'</span>';
					posicion = posicion+"<p>Actualizado: "+ update_time+ status_string+"</p>";
					myDiv.html(posicion);
					$.get('http://ws.geonames.org/findNearbyPlaceName', data,
						function(google_data){
							var formated_address = $(google_data).find('name').text() + ' '+ 
								$(google_data).find('countryName').text();
							myDiv.append('<p class="humman_address">'+formated_address+'</p>');
							},'xml');

				},'xml');
				window.setTimeout(function() {
 					update_handler(myDiv);
					}, 10000);
			

		});



	
		$('.ShowMap').live('click', function(){
				var geo = $(this).parents('.geo').first();
				last_gps_info = geo.data('last_gps_info');
				var map_dialog_name = 'map_dialog_'+last_gps_info.id;
				if($('#'+map_dialog_name).length < 1){
					var dialog_construct = "<div id='"+ map_dialog_name+ "' class='center_div map_dialog' title='MAPA' style='margin-top:10px;margin-bottom:0px; width:500px;height:300px;'>"+
					"<div class='center_div map_canvas' style='margin-top:0px;margin-bottom:0px; width:100%; height: 98%; position:relative; background-color:rgb(229,227,223);'>"+
					"</div></div>";
					geo.append(dialog_construct);
				}
				var lat=$(this).parent().parent().find('.latitude').html();
				var lng=$(this).parent().parent().find('.longitude').html();
				var d_name = $(this).parents('td:first').find('.driver_name').html();
				if (!d_name){
					d_name = $(this).parents('td:first').prev().html();
				}
				if (!d_name){
					d_name = $(this).parents('td:first').prev().prev().html();
				}
				var map_dialog = $('#'+map_dialog_name);
				
				map_dialog.dialog({autoOpen: false,
					 width: '500',
					 height: '400',
					 position: 'center',
					 resizeStop: function(event,ui){
						var gMap=$(this).find('.map_canvas').data('gMap');
						google.maps.event.trigger(gMap,'resize');
						//map_dialog.parent().css('position','fixed');
					 }
				});
				map_dialog.dialog('open');
				map_dialog.dialog( "option", "title", d_name );
				map_dialog.parent().css('opacity','0.85');
				map_dialog.parent().css('position','fixed');
				map_dialog.append("<div id='"+map_dialog_name+"_opacitycontrol' class='center_div map_dialog' style='display:none;'><div class='slider'></div></div>");
			       //$('#'+map_dialog_name+'_opacitycontrol').show();	
				$('#'+map_dialog_name+'_opacitycontrol').children('.slider').slider({
														orientation: 'vertical',
														range: 'min',
														value:	map_dialog.parent().css('opacity')*100,
														min:	20,
														max:	100,
														slide: function(event, ui){
														map_dialog.parent().css('opacity',ui.value/100);
														}
													});
				var latlng = new google.maps.LatLng(lat, lng);
				var myOptions = {
      				zoom: 14,
      				center: latlng,
      				mapTypeId: google.maps.MapTypeId.ROADMAP
				};
				var MapCanvas = map_dialog.find('.map_canvas')[0];
    				var map = new google.maps.Map(MapCanvas, myOptions);
				
				map_dialog.find('.map_canvas').first().data('gMap',map);
				var marker_title = d_name;
				var image;
				if (last_gps_info.dyn == '1'){
					image =new google.maps.MarkerImage('http://www.inteligenciamecanica.com/ubi-car/Historial/icons/dd-start.png',
						new google.maps.Size(20, 32),
						new google.maps.Point(0,0),
						new google.maps.Point(10, 32));
					marker_title = marker_title + ' '+ last_gps_info.speed+' Km/hr';

					var polyline_array =  new google.maps.MVCArray();
					var route = new google.maps.Polyline({
      						path: polyline_array,
    						strokeColor: "#FF0000",
      						strokeOpacity: 1.0,
      						strokeWeight: 2
    						});		

					$.post('<?php echo site_url("auto/get_vehicle_actual_route_xml")?>', {id: last_gps_info.id},
						function(xml_data){
							$(xml_data).find('point').each(function(){
								var lat = $(this).find('latitud').text();
								var lng = $(this).find('longitud').text();
								polyline_array.push(new google.maps.LatLng(lat, lng));
							});
						test_route = new google.maps.Polyline({
							path: polyline_array,
							map: map,
							strokeColor: "#FF0000",
      							strokeOpacity: 1.0,
      							strokeWeight: 2
						});
						
						geo.data('polyline_array', polyline_array);
						var start_lat = $(xml_data).find('point').first().find('latitud').text();
						var start_lng = $(xml_data).find('point').first().find('longitud').text();
						var start_time = $(xml_data).find('point').first().find('timestamp').text();
						var start_image =new google.maps.MarkerImage('http://www.inteligenciamecanica.com/ubi-car/Historial/icons/dd-end.png',	
						new google.maps.Size(20, 32),
						new google.maps.Point(0,0),
						new google.maps.Point(10, 32));
						var start_latlng = new  google.maps.LatLng(start_lat,start_lng);
						var start_marker = new google.maps.Marker({
      							position: start_latlng, 
    							map: map,
							title: start_time,
							icon: start_image
   				 		});   
				

						
						},'xml');


				}else{
					image =new google.maps.MarkerImage('http://www.inteligenciamecanica.com/ubi-car/Historial/icons/dd-end.png',	
						new google.maps.Size(20, 32),
						new google.maps.Point(0,0),
						new google.maps.Point(10, 32));
				}

				var marker = new google.maps.Marker({
      					  position: latlng, 
    					  map: map,
					  title: marker_title,
					  icon: image
   				 });   
				
				map_dialog.find('.map_canvas').first().data('vehicle_marker',marker);
				geo.data('vehicle_marker',marker);
		});

		$('.geo_field').find("legend").click(function(){
			var element = $(this).parent().find('.geo');
			if (element.is(':hidden')){
				element.slideDown();
				 }
			else{
				element.slideUp();
			}
		});
			
					
	});

</script>
</head>
<body>
<?php echo $header; ?>
<?php echo $menu; ?>
<h1 id="header_left"><?=$heading?></h1>
<div  style='position:relative; margin-left:auto; margin-right:auto;'>
<table style="text-align: left; position: relative; width: 100%; float:left;"
 cellpadding="2" cellspacing="2" id="sort_table">
	<thead>
		<tr>
		<th>MODELO</th>
		<th>PLACAS</th>
		<th>USUARIO</th>
		<th>ZONA</th>
		<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
		<?php $zona = $zonas->result_array(); ?>
		<?php if($query != NULL):?>
		<?php foreach($query->result() as $row): ?>
			<tr>
			<td><?=$row->MODELO?></td>
			<td><?=$row->PLACAS?></td>
			<td><bold><span class="driver_name"><?=$row->USUARIO?></span></bold>
				<fieldset class="geo_field"><legend style="cursor: pointer;">Posici&oacute;n</legend><div class="geo ui-corner-all" id='vehicle_<?=$row->id?>' name='vehicle_<?=$row->id?>'></fieldset></div></td>
			<td><?php foreach($zonas->result() as $zona): 
				if ($zona->id == $row->ZONA){
					echo $zona->nombre;
					break;
				}
				endforeach;?></td>
			<td style ="text-transform: lowercase;"><?=anchor('auto/edit/'.$row->id,"Editar")?></td>
			</tr>
		<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>
</div>
<div class='spacer'></div>
<div id="footer">
<?=$footer?>
</div>
</body>
</html>
