<?php include_once __DIR__ . '/conferencias.php'; ?>

<section class="resumen">
	<div class="resumen__grid">
		<div class="resumen__bloque">
			<p class="resumen__texto resumen__texto--numero"><?= $ponentes_total; ?></p>
			<p class="resumen__texto">Speakers</p>
		</div>
		<div class="resumen__bloque">
			<p class="resumen__texto resumen__texto--numero"><?= $conferencias_total; ?></p>
			<p class="resumen__texto">Conferencias</p>
		</div>
		<div class="resumen__bloque">
			<p class="resumen__texto resumen__texto--numero"><?= $workshops_total; ?></p>
			<p class="resumen__texto">Workshops</p>
		</div>
		<div class="resumen__bloque">
			<p class="resumen__texto resumen__texto--numero">500</p>
			<p class="resumen__texto">Asistentes</p>
		</div>
	</div>
</section>

<section class="speakers">
	<h2 class="speakers__heading">Speakers</h2>
	<p class="speakers__descripcion">Conoce a nuestros expertos de DevWebCamp</p>
	<div class="speakers__grid">
		<?php foreach ($ponentes as $ponente) {  ?>
			<div class="speaker">
				<?= $ponente->getImagenHTML("speaker__imagen"); ?>
				<div class="speaker__informacion">
					<h4 class="speaker__nombre"><?= $ponente->nombre . ' ' . $ponente->apellido; ?></h4>

					<p class="speaker__ubicacion"><?= $ponente->ciudad . ', ' . $ponente->pais; ?></p>

					<nav class="speaker-sociales">
						<?php 
							$redes = json_decode( $ponente->redes );
						?>
						<?php if(!empty($redes->facebook)){ ?>
							<a class="speaker-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?= $redes->facebook; ?>">
								<span class="speaker-sociales__ocultar">Facebook</span>
							</a>
						<?php } 
							if(!empty($redes->twitter)) {
						?>
							<a class="speaker-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?= $redes->twitter; ?>">
								<span class="speaker-sociales__ocultar">Twitter</span>
							</a>
						<?php 
							}
							if(!empty($redes->youtube)) {
						?>
							<a class="speaker-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?= $redes->youtube; ?>">
								<span class="speaker-sociales__ocultar">YouTube</span>
							</a>
						<?php 
							}
							if(!empty($redes->instagram)) {
						?>
							<a class="speake-socialesr__enlace" rel="noopener noreferrer" target="_blank" href="<?= $redes->instagram; ?>">
								<span class="speaker-sociales__ocultar">Instagram</span>
							</a>
						<?php 
							}
							if(!empty($redes->tiktok)) {
						?>
							<a class="speaker-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?= $redes->tiktok; ?>">
								<span class="speaker-sociales__ocultar">Tiktok</span>
							</a>
						<?php 
							}
							if(!empty($redes->github)) {
						?>
							<a class="speaker-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?= $redes->github; ?>">
								<span class="speaker-sociales__ocultar">Github</span>
							</a>
						<?php } ?>
					</nav>
					<ul class="speaker__listado-skills">
						<?php 
							$tags = explode(',', $ponente->tags);
							foreach ($tags as $tag) {
						?>
							<li class="speaker__skill"><?= $tag; ?></li>
						<?php } ?>
					</ul>
				</div>
			</div>
			
		<?php } ?>
	</div>
</section>

<div id="map" class="mapa"></div>

<section class="boletos">
	<h2 class="boletos__heading">Boletos & Precios</h2>
	<p class="boletos__descripcion">Precios para DevWebCamp</p>

	<div class="boletos__grid">
		<div class="boleto boleto--presencial">
			<p class="boleto__logo">&#60;DevWebCamp/></p>
			<p class="boleto__plan">Presencial</p>
			<p class="boleto__precio">199 €</p>
		</div>
		<div class="boleto boleto--virtual">
			<p class="boleto__logo">&#60;DevWebCamp/></p>
			<p class="boleto__plan">Virtual</p>
			<p class="boleto__precio">49 €</p>
		</div>
		<div class="boleto boleto--gratis">
			<p class="boleto__logo">&#60;DevWebCamp/></p>
			<p class="boleto__plan">Gratis</p>
			<p class="boleto__precio">Gratis - 0 €</p>
		</div>
	</div>

	<div class="boleto__enlace-contenedor">
		<a href="/paquetes" class="boleto__enlace">Ver Paquetes</a>
	</div>
</section>