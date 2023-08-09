<main class="auth">
	<h2 class="auth__heading"><?= $titulo; ?></h2>

	<p class="auth__texto">Coloca tu nuevo Password</p>

	<?php require_once __DIR__ . '/../templates/alertas.php' ?>
	<?php if($token_valido){ ?>
	<form method="POST" class="formulario">
		<div class="formulario__campo">
			<label for="password" class="formulario__label">Email</label>
			<input class="formulario__input" type="password" name="password" id="password" placeholder="Tu Password">
		</div>
		
		<input type="submit" class="formulario__submit" value="Guardar Password">
	</form>
	<?php } ?>
	<div class="acciones">
		
		<a href="/login" class="acciones__enlace">¿Ya tienes cuenta? Iniciar sesión</a>
		<a href="/registro" class="acciones__enlace">¿Aún no tienes una cuenta? Obtener una</a>
	</div>
</main>