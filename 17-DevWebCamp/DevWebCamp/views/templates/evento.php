					<div class="evento swiper-slide">
						<p class="evento__hora"><?= $evento->hora->hora; ?></p>

						<div class="evento__informacion">
							<h4 class="evento__nombre" title="<?= $evento->nombre; ?>"><?= $evento->nombre; ?></h4>
							
							<p class="evento__introduccion"><?= $evento->descripcion; ?></p>
							
							<div class="evento__autor-info">
								<?= $evento->ponente->getImagenHTML('evento__imagen-autor'); ?>
								<p class="evento__autor-nombre"><?= $evento->ponente->nombre . " " . $evento->ponente->apellido; ?></p>
							</div>
						</div>
					</div>