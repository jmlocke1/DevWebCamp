<fieldset class="formulario__fieldset">
	<legend class="formulario__legend">Información Evento</legend>

	<div class="formulario__campo">
		<label for="nombre" class="formulario__label">Nombre Evento</label>
		<input 
			type="text" 
			name="nombre" 
			id="nombre" 
			class="formulario__input" 
			placeholder="Nombre Evento"
			value="<?= $evento->nombre; ?>"
		>
	</div>

	<div class="formulario__campo">
		<label for="descripcion" class="formulario__label">Descripción</label>
		<textarea  
			name="descripcion" 
			id="descripcion" 
			class="formulario__input" 
			placeholder="Descripción Evento"
			rows="8"
		><?= $evento->descripcion; ?></textarea>
	</div>
	<div class="formulario__campo">
		<label for="categoria" class="formulario__label">Categoría o Tipo de Evento</label>
		<select
			class="formulario__select"
			name="categoria_id" 
			id="categoria"
		>
				<option value="">-- Seleccionar --</option>
			<?php foreach($categorias as $categoria){ ?>
				<option 
					value="<?= $categoria->id; ?>"
					<?= $categoria->id === $evento->categoria_id ? 'selected' : ''; ?>
				><?= $categoria->nombre; ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="formulario__campo">
		<label for="categoria" class="formulario__label">Selecciona el día</label>

		<div class="formulario__radio">
			<?php foreach ($dias as $dia) { ?>
				<div>
					<label for="<?= strtolower($dia->nombre); ?>"><?= $dia->nombre; ?></label>
					<input 
						type="radio" 
						name="dia" 
						id="<?= strtolower($dia->nombre); ?>"
						value="<?= $dia->id; ?>"
					>
				</div>
			<?php } ?>
		</div>
		<input type="hidden" name="dia_id" value="">
	</div>
	<div id="horas" class="formulario__campo">
		<label for="horas" class="formulario__label">Seleccionar Hora</label>

		<ul id="horas" class="horas">
			<?php foreach($horas as $hora) { ?>
				<li data-hora-id="<?= $hora->id; ?>" class="horas__hora horas__hora--deshabilitada"><?= $hora->hora; ?></li>
			<?php } ?>
		</ul>
		<input type="hidden" name="hora_id" value="">
	</div>
</fieldset>

<fieldset class="formulario__fieldset">
	<legend class="formulario__legend">Información Extra</legend>

	<div class="formulario__campo">
		<label for="ponentes" class="formulario__label">Nombre Evento</label>
		<input 
			type="text"
			id="ponentes" 
			class="formulario__input" 
			placeholder="Buscar Ponente"
		>
	</div>
	<div class="formulario__campo">
		<label for="disponibles" class="formulario__label">Lugares Disponibles</label>
		<input 
			type="number"
			min="1"
			id="disponibles" 
			name="disponibles" 
			class="formulario__input" 
			placeholder="Ej. 20"
			value="<?= $evento->disponibles; ?>"
		>
	</div>
</fieldset>