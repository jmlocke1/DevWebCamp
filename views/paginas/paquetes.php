<main class="paquetes">
	<h2 class="paquetes__heading"><?= $titulo; ?></h2>

	<p class="paquetes__descripcion">Compara los paquetes de DevWebCamp</p>

	<div class="paquetes__grid">
		<div <?= aos_animacion(); ?> class="paquete">
			<h3 class="paquete__nombre">Pase Gratis</h3>
			<ul class="paquete__lista">
				<li class="paquete__elemento">Acceso Virtual a DevWebCamp</li>
			</ul>
			<p class="paquete__precio">$<?= $pass::FREE_PASS; ?></p>
		</div>
		<div <?= aos_animacion(); ?> class="paquete">
			<h3 class="paquete__nombre">Pase Presencial</h3>
			<ul class="paquete__lista">
				<li class="paquete__elemento">Acceso Presencial a DevWebCamp</li>
				<li class="paquete__elemento">Pase por 2 días</li>
				<li class="paquete__elemento">Acceso a Talleres y Conferencias</li>
				<li class="paquete__elemento">Acceso a las Grabaciones</li>
				<li class="paquete__elemento">Camisa del Evento</li>
				<li class="paquete__elemento">Comida y Bebida</li>
			</ul>
			<p class="paquete__precio">$<?= $pass::FACE_TO_FACE_PASS; ?></p>
		</div>
		<div <?= aos_animacion(); ?> class="paquete">
			<h3 class="paquete__nombre">Pase Virtual</h3>
			<ul class="paquete__lista">
				<li class="paquete__elemento">Acceso Virtual a DevWebCamp</li>
				<li class="paquete__elemento">Pase por 2 días</li>
				<li class="paquete__elemento">Enlace a Talleres y Conferencias</li>
				<li class="paquete__elemento">Acceso a las Grabaciones</li>
			</ul>
			<p class="paquete__precio">$<?= $pass::VIRTUAL_PASS; ?></p>
		</div>
	</div>
</main>