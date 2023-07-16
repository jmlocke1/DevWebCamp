<main class="registro">
	<h2 class="registro__heading"><?= $titulo; ?></h2>
	<p class="registro__descripcion">Elige tu plan</p>

	<div class="paquetes__grid">
		<div <?= aos_animacion(); ?> class="paquete">
			<h3 class="paquete__nombre">Pase Gratis</h3>
			<ul class="paquete__lista">
				<li class="paquete__elemento">Acceso Virtual a DevWebCamp</li>
			</ul>
			<p class="paquete__precio">$<?= $pass::FREE_PASS; ?></p>

			<form action="/finalizar-registro/gratis" method="post">
				<input type="submit" value="Inscripción Gratis" class="paquetes__submit">
			</form>
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

			<div id="smart-button-container">
				<div style="text-align: center;">
					<div id="paypal-button-container"></div>
				</div>
			</div>
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



<script src="https://www.paypal.com/sdk/js?client-id=ATO3_sG9omx3jR3nDYF0y-Ozb18OnwEJ3bzNEmrfhyoLwjYptiU0LxSf4qbVjB4mjYSc4SUy3mk5028M&enable-funding=venmo&currency=USD" data-sdk-integration-source="button-factory"></script>
 
<script>
    function initPayPalButton() {
      paypal.Buttons({
        style: {
          shape: 'rect',
          color: 'blue',
          layout: 'vertical',
          label: 'pay',
        },
 
        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{"description":"1","amount":{"currency_code":"USD","value":199}}]
          });
        },
 
        onApprove: function(data, actions) {
          return actions.order.capture().then(function(orderData) {
 
            // Full available details
            // console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
 
            // // Show a success message within this page, e.g.
            // const element = document.getElementById('paypal-button-container');
            // element.innerHTML = '';
            // element.innerHTML = '<h3>Thank you for your payment!</h3>';
 
            // Or go to another URL:  actions.redirect('thank_you.html');
			const datos = new FormData();
			datos.append('paquete_id', orderData.purchase_units[0].description)
			datos.append('pago_id', orderData.purchase_units[0].payments.captures[0].id)
            
			fetch('/finalizar-registro/pagar', {
				method: 'POST',
				body: datos
			})
			.then( respuesta => respuesta.json())
			.then( resultado => {
				if(resultado.resultado) {
					const url = window.location.origin + '/finalizar-registro/conferencias';
					actions.redirect(url);
				}
			})
          });
        },
 
        onError: function(err) {
          console.log(err);
        }
      }).render('#paypal-button-container');
    }
 
  initPayPalButton();
</script>