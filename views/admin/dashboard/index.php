<h2 class="dashboard__heading"><?= $titulo; ?></h2>

<div class="bloques">
	<div class="bloques__grid">
		<div class="bloque">
			<h3 class="bloque__heading">Últimos Registros</h3>

			<?php foreach($registros as $registro) { ?>
				<div class="bloque__contenido">
					<p class="bloque__texto">
						<?= $registro->usuario->nombre . " " . $registro->usuario->apellido; ?>
					</p>
				</div>
			<?php } ?>
		</div>
		<div class="bloque">
			<h3 class="bloque__heading">Ingresos</h3>
			<p class="bloque__texto--cantidad">$ <?= $ingresos; ?></p>
		</div>
		<div class="bloque">
			<h3 class="bloque__heading">Eventos con menos lugares Disponibles</h3>
			<?php foreach($menos_disponibles as $evento){ ?>
				<div class="bloque__contenido">
					<p class="bloque__texto">
						<?= $evento->nombre . " " . $evento->disponibles; ?>
					</p>
				</div>
			<?php } ?>
		</div>
		<div class="bloque">
			<h3 class="bloque__heading">Eventos con más lugares Disponibles</h3>
			<?php foreach($mas_disponibles as $evento){ ?>
				<div class="bloque__contenido">
					<p class="bloque__texto">
						<?= $evento->nombre . " " . $evento->disponibles; ?>
					</p>
				</div>
			<?php } ?>
		</div>
	</div>
</div>