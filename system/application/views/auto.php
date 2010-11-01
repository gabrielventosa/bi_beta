<html>
<head>
<title><?=$title?></title>
</head>
<body>
<h1><?=$heading?></h1>

<?php foreach($query->result() as $row): ?>
<p><?=$row->MODELO?></p>
<p><?=$row->PLACAS?></p>
<p><?=$row->USUARIO?></p>
<p><?=$row->ZONA?></p>
<hr>
<?php endforeach; ?>
</body>
</html>
