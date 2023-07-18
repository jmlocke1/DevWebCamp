
	<h2 class="pagina__heading"><?= $titulo; ?></h2>
	<p class="pagina__descripcion">Elige hasta 5 eventos para asistir de forma presencial.</p>
<div class="eventos-registro">
	<main class="eventos-registro__listado">
		<h3 class="eventos-registro__heading--conferencias">&lt;Conferencias /></h3>
		<p class="eventos-registro__fecha">Viernes 6 de Octubre</p>

		<div class="eventos-registro__grid">
			<?php foreach($eventos['conferencias']['viernes'] as $evento) { ?>
				<?php include __DIR__ . '/evento.php'; ?>
			<?php } ?>
		</div>
	</main>

	<aside class="registro">
				<h2 class="registro__heading">Tu Registro</h2>
	</aside>
</div>
	