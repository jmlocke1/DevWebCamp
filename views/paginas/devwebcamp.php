<main class="devwebcamp">
	<h2 class="devwebcamp__heading"><?= $titulo; ?></h2>

	<p class="devwebcamp__descripcion">Conoce la conferencia más importante de Latinoamérica</p>

	<div class="devwebcamp__grid">
		<div <?= aos_animacion(); ?> class="devwebcamp__imagen">
			<picture>
				<source srcset="/build/img/sobre_devwebcamp.avif" type="image/avif">
				<source srcset="/build/img/sobre_devwebcamp.webp" type="image/webp">
				<img loading="lazy" src="/build/img/sobre_devwebcamp.jpg" alt="Imagen Devwebcamp" title="Imagen Devwebcamp">
			</picture>
		</div>

		<div class="devwebcamp__contenido">
			<p <?= aos_animacion(); ?> class="devwebcamp__texto">Nullam sodales justo sit amet nunc blandit, vel viverra tortor scelerisque. Fusce non dui quis neque malesuada eleifend. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Fusce augue orci, condimentum non mi id, scelerisque egestas elit. Donec dignissim, arcu id consequat pretium, mi nisi tempor nisl, quis finibus est felis pharetra sapien. Donec sed risus nec ipsum faucibus interdum quis consequat odio. Morbi hendrerit viverra orci, rutrum dapibus diam sollicitudin eget. Donec vitae nibh quis magna euismod laoreet. Proin molestie magna et orci vulputate, quis tincidunt sapien aliquet. Sed aliquet lacinia sem, sed congue elit interdum eget. Donec ac luctus mauris.</p>
			
			<p <?= aos_animacion(); ?> class="devwebcamp__texto">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin pretium ante sed arcu sagittis pulvinar. In hac habitasse platea dictumst. Suspendisse imperdiet dignissim pharetra. Vivamus eleifend dapibus hendrerit. Phasellus sed auctor justo. In non imperdiet leo. Proin consequat imperdiet varius. Vivamus feugiat finibus auctor. Duis dui diam, volutpat non blandit vitae, varius in urna. Vivamus tincidunt risus sit amet finibus congue. Aenean eget augue tortor. Integer ac massa vitae metus dapibus vehicula. </p>
		</div>
	</div>
</main>