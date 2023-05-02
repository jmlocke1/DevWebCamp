<main class="auth">
	<h2 class="auth__heading"><?= $titulo; ?></h2>

	<p class="auth__texto">Inicia sesión en DevWebcamp</p>

	<?php require_once __DIR__ . '/../templates/alertas.php' ?>

	<?php if(isset($alertas['exito'])) { ?>
	<div class="acciones--centrar">
		<a href="/login" class="acciones__enlace">Iniciar sesión</a>
	</div>
	<?php } ?>
</main>