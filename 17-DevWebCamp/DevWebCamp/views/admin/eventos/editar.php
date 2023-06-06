<script>
	let editar = {
		categoria: +<?= $evento->categoria_id; ?>,
		dia: +<?= $evento->dia_id; ?>,
		hora: +<?= $evento->hora_id; ?>
	}
</script>
<h2 class="dashboard__heading"><?= $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
	<a class="dashboard__boton" href="/admin/eventos">
		<i class="fa-solid fa-circle-arrow-left"></i>
		Volver
	</a>
</div>

<div class="dashboard__formulario">
	<?php require_once __DIR__ . '/../../templates/alertas.php' ?>
	<form method="POST" class="formulario">
		<?php include_once __DIR__ . '/formulario.php';?>
		<input class="formulario__submit formulario__submit--registrar" type="submit" value="Guardar Cambios">
	</form>
</div>