<?php header('Content-type: application/xml'); ?>
<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"; ?>
<vehicles>

<?php foreach ($vehicles as $vehicle):?>
	<vehicle>
	<id><?=$id?></id>
	<IMEI><?=$vehicle->IMEI?></IMEI>
	<latitud><?=$vehicle->latitud?></latitud>
	<longitud><?=$vehicle->longitud?></longitud>
	<timestamp><?=$vehicle->timestamp?></timestamp>
	<speed><?=$vehicle->speed?></speed>
	<course><?=$vehicle->course?></course>
	<iodata><?=$vehicle->iodata?></iodata>
	<analog><?=$vehicle->analog?></analog>
	<dyn><?=$vehicle->dyn?></dyn>
	</vehicle>
<?php endforeach?>
</vehicles>
