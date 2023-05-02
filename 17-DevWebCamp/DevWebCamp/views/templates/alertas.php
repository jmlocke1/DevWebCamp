<?php
$alertas = $alertas ?? [];  
foreach ($alertas as $tipo => $alerta) {
	foreach($alerta as $mensaje) {
?>
	<div class="alerta alerta__<?= $tipo; ?>"><?= $mensaje; ?></div>
<?php 
	}
}