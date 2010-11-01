<?php header('Content-type: application/xml'); ?>
<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"; ?>
<route>

<?php foreach ($points as $point):?>
	<point>
	<id><?=$id?></id>
	<IMEI><?=$point->IMEI?></IMEI>
	<latitud><?=$point->latitud?></latitud>
	<longitud><?=$point->longitud?></longitud>
	<timestamp><?=$point->timestamp?></timestamp>
	<speed><?=$point->speed?></speed>
	<course><?=$point->course?></course>
	<iodata><?=$point->iodata?></iodata>
	<analog><?=$point->analog?></analog>
	<gpssats><?=$point->gpssats?></gpssats>
	<alt><?=$point->alt?></alt>
	<regist><?=$point->regist?></regist>
	<dyn><?=$point->dyn?></dyn>
	</point>
<?php endforeach?>
</route>
