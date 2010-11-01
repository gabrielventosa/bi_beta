<html>
<head>
<?php if(isset($title)):?>
<title><?=$title?></title>
<?php else:?>
<title>InteligenciaMec�nica</title>
<?php endif;?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv='expires' content='-1' />
<meta http-equiv= 'pragma' content='no-cache' />


<link type="text/css" href="<?php echo base_url();?>js/jquery-ui/css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-ui/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-ui/js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/dataTables-1.6/media/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/dataTables-1.6/media/js/jquery.dataTables.js"></script>

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
		</style>
</head>
<body>
<?php if(isset($header)):?>
	<?php echo $header; ?>
	<?php echo $menu; ?>
	<h1 id="header_left"><?=$heading?></h1>
<?php endif;?>

<div id="center_div" class="center_div">
<h2>
<?php echo $auth_message ?>
<h2>
</div>
<?php if(isset($footer)):?>
<div id="footer">
<?=$footer?>
</div>
<?php endif;?>
</body>
</html>
