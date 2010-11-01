<?php header('Content-type: application/xml'); ?>
<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"; ?>
<vehicles>

<?php foreach ($vehicles as $vehicle):?>
	<vehicle>
	<id><?=$vehicle->id?></id>
	<modelo><?=$vehicle->MODELO?></modelo>
	<placas><?=$vehicle->PLACAS?></placas>
	<usuario><?=$vehicle->USUARIO?></usuario>
	<zona><?=$vehicle->ZONA?></zona>
	</vehicle>
<?php endforeach?>
</vehicles>
