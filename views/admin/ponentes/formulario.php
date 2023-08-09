<fieldset class="formulario__fieldset">
	<legend class="formulario__legend">Información Personal</legend>

	<div class="formulario__campo">
		<label for="nombre" class="formulario__label">Nombre</label>
		<input 
			type="text" 
			name="nombre" 
			id="nombre" 
			class="formulario__input" 
			placeholder="Nombre Ponente"
			value="<?= $ponente->nombre ?? ''; ?>"
		>
	</div>
	<div class="formulario__campo">
		<label for="apellido" class="formulario__label">Apellidos</label>
		<input 
			type="text" 
			name="apellido" 
			id="apellido" 
			class="formulario__input" 
			placeholder="Apellidos del Ponente"
			value="<?= $ponente->apellido ?? ''; ?>"
		>
	</div>
	<div class="formulario__campo">
		<label for="ciudad" class="formulario__label">Ciudad</label>
		<input 
			type="text" 
			name="ciudad" 
			id="ciudad" 
			class="formulario__input" 
			placeholder="Ciudad del Ponente"
			value="<?= $ponente->ciudad ?? ''; ?>"
		>
	</div>
	<div class="formulario__campo">
		<label for="pais" class="formulario__label">País</label>
		<input 
			type="text" 
			name="pais" 
			id="pais" 
			class="formulario__input" 
			placeholder="País del Ponente"
			value="<?= $ponente->pais ?? ''; ?>"
		>
	</div>
	<div class="formulario__campo">
        <label for="imagen" class="formulario__label">Imagen</label>
        <input
            type="file"
            class="formulario__input formulario__input--file"
            id="imagen"
            name="imagen"
        >
    </div>
	<?php if(isset($mostrarImagen)) { ?>
		<p class="formulario__texto">Imagen Actual</p>
		<div class="formulario__imagen">
			<?= $ponente->getImagenHTML(); ?>
		</div>

	<?php } ?>
</fieldset>

<fieldset class="formulario__fieldset">
	<legend class="formulario__legend">Información Extra</legend>

	<div class="formulario__campo">
		<label for="tags_input" class="formulario__label">Áreas de experiencia (separadas por comas)</label>
		<input 
			type="text" 
			id="tags_input" 
			class="formulario__input" 
			placeholder="Ej. Node.js, PHP, CSS, Laravel, UX / UI"
		>
		<div id="tags" class="formulario__listado"></div>
		<input type="hidden" name="tags" value="<?= $ponente->tags ?? ''; ?>">
	</div>
</fieldset>

<fieldset class="formulario__fieldset">
	<legend class="formulario__legend">Redes Sociales</legend>

	<div class="formulario__campo">
		<div class="formulario__contenedor-icono">
			<div class="formulario__icono">
				<i class="fa-brands fa-facebook"></i>
			</div>
			<input 
				type="text" 
				name="redes[facebook]"
				class="formulario__input--sociales" 
				placeholder="Facebook"
				value="<?= $redes->facebook ?? ''; ?>"
			>
		</div>
	</div>
	<div class="formulario__campo">
		<div class="formulario__contenedor-icono">
			<div class="formulario__icono">
				<i class="fa-brands fa-twitter"></i>
			</div>
			<input 
				type="text" 
				name="redes[twitter]"
				class="formulario__input--sociales" 
				placeholder="Twitter"
				value="<?= $redes->twitter ?? ''; ?>"
			>
		</div>
	</div>
	<div class="formulario__campo">
		<div class="formulario__contenedor-icono">
			<div class="formulario__icono">
				<i class="fa-brands fa-youtube"></i>
			</div>
			<input 
				type="text" 
				name="redes[youtube]"
				class="formulario__input--sociales" 
				placeholder="YouTube"
				value="<?= $redes->youtube ?? ''; ?>"
			>
		</div>
	</div>
	<div class="formulario__campo">
		<div class="formulario__contenedor-icono">
			<div class="formulario__icono">
				<i class="fa-brands fa-instagram"></i>
			</div>
			<input 
				type="text" 
				name="redes[instagram]"
				class="formulario__input--sociales" 
				placeholder="Instagram"
				value="<?= $redes->instagram ?? ''; ?>"
			>
		</div>
	</div>
	<div class="formulario__campo">
		<div class="formulario__contenedor-icono">
			<div class="formulario__icono">
				<i class="fa-brands fa-tiktok"></i>
			</div>
			<input 
				type="text" 
				name="redes[tiktok]"
				class="formulario__input--sociales" 
				placeholder="Tiktok"
				value="<?= $redes->tiktok ?? ''; ?>"
			>
		</div>
	</div>
	<div class="formulario__campo">
		<div class="formulario__contenedor-icono">
			<div class="formulario__icono">
				<i class="fa-brands fa-github"></i>
			</div>
			<input 
				type="text" 
				name="redes[github]"
				class="formulario__input--sociales" 
				placeholder="GitHub"
				value="<?= $redes->github ?? ''; ?>"
			>
		</div>
	</div>
</fieldset>