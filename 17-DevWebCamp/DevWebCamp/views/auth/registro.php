<main class="auth">
	<h2 class="auth__heading"><?= $titulo; ?></h2>

	<p class="auth__texto">Regístrate en DevWebcamp</p>

	<?php require_once __DIR__ . '/../templates/alertas.php' ?>

	<form method="POST" action="/registro" class="formulario">
		<div class="formulario__campo">
			<label for="nombre" class="formulario__label">Nombre</label>
			<input class="formulario__input" type="text" name="nombre" id="nombre" placeholder="Tu Nombre" value="<?= $usuario->nombre; ?>">
		</div>
		<div class="formulario__campo">
			<label for="apellido" class="formulario__label">Apellidos</label>
			<input class="formulario__input" type="text" name="apellido" id="apellido" placeholder="Tus Apellidos" value="<?= $usuario->apellido; ?>">
		</div>
		<div class="formulario__campo">
			<label for="email" class="formulario__label">Email</label>
			<input class="formulario__input" type="email" name="email" id="email" placeholder="Tu Email" value="<?= $usuario->email; ?>">
		</div>
		<div class="formulario__campo">
			<label for="password" class="formulario__label">Password</label>
			<input class="formulario__input" type="password" name="password" id="password" placeholder="Tu Password">
		</div>
		<div class="formulario__campo">
			<label for="password2" class="formulario__label">Repetir Password</label>
			<input class="formulario__input" type="password" name="password2" id="password2" placeholder="Repite Tu Password">
		</div>
		<input type="submit" class="formulario__submit" value="Crear Cuenta">
	</form>
	<div class="acciones">
		<a href="/login" class="acciones__enlace">¿Ya tienes cuenta? Iniciar sesión</a>
		<a href="/olvide" class="acciones__enlace">¿Olvidaste tu Password?</a>
	</div>
</main>