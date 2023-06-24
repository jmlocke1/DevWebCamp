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

	<?php foreach ($ponentes as $ponente) {  ?>
		<div class="speaker">
			<?= $ponente->getImagenHTML("speaker__imagen"); ?>
		</div>
		<div class="speaker__informacion">
			<h4 class="speaker__nombre"><?= $ponente->nombre . ' ' . $ponente->apellido; ?></h4>

			<p class="speaker__ubicacion"><?= $ponente->ciudad . ', ' . $ponente->pais; ?></p>

			<nav class="speaker__sociales">
				<?php 
					$redes = json_decode( $ponente->redes );
				 ?>
				<?php if(!empty($redes->facebook)){ ?>
					<a class="speaker__enlace" rel="noopener noreferrer" target="_blank" href="<?= $redes->facebook; ?>">
						<span class="speaker__ocultar">Facebook</span>
					</a>
				<?php } 
					if(!empty($redes->twitter)) {
				?>
					<a class="speaker__enlace" rel="noopener noreferrer" target="_blank" href="<?= $redes->twitter; ?>">
						<span class="speaker__ocultar">Twitter</span>
					</a>
				<?php 
					}
					if(!empty($redes->youtube)) {
				?>
					<a class="speaker__enlace" rel="noopener noreferrer" target="_blank" href="<?= $redes->youtube; ?>">
						<span class="speaker__ocultar">YouTube</span>
					</a>
				<?php 
					}
					if(!empty($redes->instagram)) {
				 ?>
					<a class="speaker__enlace" rel="noopener noreferrer" target="_blank" href="<?= $redes->instagram; ?>">
						<span class="speaker__ocultar">Instagram</span>
					</a>
				<?php 
					}
					if(!empty($redes->tiktok)) {
				 ?>
					<a class="speaker__enlace" rel="noopener noreferrer" target="_blank" href="<?= $redes->tiktok; ?>">
						<span class="speaker__ocultar">Tiktok</span>
					</a>
				<?php 
					}
					if(!empty($redes->github)) {
				 ?>
					<a class="speaker__enlace" rel="noopener noreferrer" target="_blank" href="<?= $redes->github; ?>">
						<span class="speaker__ocultar">Github</span>
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
	<?php } ?>
</section>