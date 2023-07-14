<main class="pagina">
	<h2 class="pagina__heading"><?= $titulo; ?></h2>
	<p class="pagina__descripcion">Tu boleto - Te recomendamos almacenarlo, puedes compartirlo en redes sociales.</p>

	<div class="boleto-virtual">
		<div class="boleto boleto--<?= strtolower($registro->paquete->nombre); ?> boleto--acceso">
			<div class="boleto__contenido">
				<h4 class="boleto__logo">&#60;DevWebCamp/></h4>
				<p class="boleto__plan"><?= $registro->paquete->nombre; ?></p>
				<p class="boleto__nombre"><?= $registro->usuario->nombre . " " . $registro->usuario->apellido; ?></p>
			</div>
			<p class="boleto__codigo"><?= "#".$registro->token; ?></p>
		</div>
	</div>
</main>