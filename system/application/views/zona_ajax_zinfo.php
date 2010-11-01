<?php header('Content-type: application/xml'); ?>
<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"; ?>
<zonainfo>
<?php if ($query->num_rows() >0): ?>
<?php foreach($query->result() as $row): ?>
<zona>
<MODELO><?=$row->MODELO?></MODELO>
<PLACAS><?=$row->PLACAS?></PLACAS>
<USUARIO><?=$row->USUARIO?></USUARIO>
<NUMDIST><?=$numdist?></NUMDIST>
<imei><?=$row->imei?></imei>
</zona>
<?php endforeach; ?>
<?php endif; ?>
</zonainfo>