<main class="agenda">
	<h2 class="agenda__heading">Workshops y Conferencias</h2>
	<p class="agenda__descripcion">Talleres y Conferencias dictados por expertos en desarrollo web</p>

	<div class="eventos">
		<h3 class="eventos__heading">&lt;Conferencias /></h3>
		<p class="eventos__fecha">Viernes 6 de Octubre</p>

		<div class="eventos__listado slider swiper">
			<div class="swiper-wrapper">
				<?php foreach($eventos['conferencias']['viernes'] as $evento) { ?>
					<?php include __DIR__ . '../../templates/evento.php'; ?>
				<?php } ?>
			</div>
			<div class="swiper-button-prev"></div>
  			<div class="swiper-button-next"></div>
		</div>

		<p class="eventos__fecha">Sábado 7 de Octubre</p>

		<div class="eventos__listado slider swiper">
			<div class="swiper-wrapper">
				<?php foreach($eventos['conferencias']['sabado'] as $evento) { ?>
					<?php include __DIR__ . '../../templates/evento.php'; ?>
				<?php } ?>
			</div>
			<div class="swiper-button-prev"></div>
  			<div class="swiper-button-next"></div>
		</div>
	</div>

	<div class="eventos eventos--workshops">
		<h3 class="eventos__heading">&lt;Workshops /></h3>
		<p class="eventos__fecha">Viernes 6 de Octubre</p>

		<div class="eventos__listado slider swiper">
			<div class="swiper-wrapper">
				<?php foreach($eventos['workshops']['viernes'] as $evento) { ?>
					<?php include __DIR__ . '../../templates/evento.php'; ?>
				<?php } ?>
			</div>
			<div class="swiper-button-prev"></div>
  			<div class="swiper-button-next"></div>
		</div>

		<p class="eventos__fecha">Sábado 7 de Octubre</p>

		<div class="eventos__listado slider swiper">
			<div class="swiper-wrapper">
				<?php foreach($eventos['workshops']['sabado'] as $evento) { ?>
					<?php include __DIR__ . '../../templates/evento.php'; ?>
				<?php } ?>
			</div>
			<div class="swiper-button-prev"></div>
  			<div class="swiper-button-next"></div>
		</div>
	</div>
</main>