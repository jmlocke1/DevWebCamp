<main class="auth">
	<h2 class="auth__heading"><?= $titulo; ?></h2>

	<p class="auth__texto">Recupera tu acceso en DevWebcamp</p>

	<form action="" class="formulario">
		<div class="formulario__campo">
			<label for="email" class="formulario__label">Email</label>
			<input class="formulario__input" type="email" name="email" id="email" placeholder="Tu Email">
		</div>
		
		<input type="submit" class="formulario__submit" value="Enviar Instrucciones">
	</form>
	<div class="acciones">
		
		<a href="/login" class="acciones__enlace">¿Ya tienes cuenta? Iniciar sesión</a>
		<a href="/registro" class="acciones__enlace">¿Aún no tienes una cuenta? Obtener una</a>
	</div>
</main>