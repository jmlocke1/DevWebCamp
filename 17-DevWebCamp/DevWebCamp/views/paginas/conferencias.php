<main class="agenda">
	<h2 class="agenda__heading"><?= $titulo; ?></h2>
	<p class="agenda__descripcion">Talleres y Conferencias dictados por expertos en desarrollo web</p>

	<div class="eventos">
		<h3 class="eventos__heading">&lt;Conferencias /></h3>
		<p class="eventos__fecha">Viernes 6 de Octubre</p>

		<div class="eventos__listado">
			<?php foreach($eventos['conferencias']['viernes'] as $evento) { ?>
				<div class="evento">
					<p class="evento__hora"><?= $evento->hora->hora; ?></p>

					<div class="evento__informacion">
						<h4 class="evento__nombre"><?= $evento->nombre; ?></h4>
						
						<p class="evento__introduccion"><?= $evento->descripcion; ?></p>
						
						<div class="evento__autor-info">
							<?= $evento->ponente->getImagenHTML('evento__imagen-autor'); ?>
							<p class="evento__autor-nombre"><?= $evento->ponente->nombre . " " . $evento->ponente->apellido; ?></p>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>

		<p class="eventos__fecha">Sábado 7 de Octubre</p>

		<div class="eventos__listado">
			
		</div>
	</div>

	<div class="eventos eventos--workshops">
		<h3 class="eventos__heading">&lt;Workshops /></h3>
		<p class="eventos__fecha">Viernes 6 de Octubre</p>

		<div class="eventos__listado">

		</div>

		<p class="eventos__fecha">Sábado 7 de Octubre</p>

		<div class="eventos__listado">
			
		</div>
	</div>
</main>