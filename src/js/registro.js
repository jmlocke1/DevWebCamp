import Swal from "sweetalert2";

(function() {
	const $resumen = document.querySelector('#registro-resumen');

	if($resumen){
		let eventos = [];
		const $eventosBoton = document.querySelectorAll('.evento__agregar'),
			  $formularioRegistro = document.querySelector('#registro');
		$eventosBoton.forEach(boton => boton.addEventListener('click', seleccionarEvento));

		$formularioRegistro.addEventListener('submit', submitFormulario);

		mostrarEventos();

		function seleccionarEvento({target}) {
			if(eventos.length < 5) {
				eventos = [...eventos, {
					id: target.dataset.id,
					titulo: target.parentElement.querySelector('.evento__nombre').textContent.trim()
				}];
				// Deshabilitar el evento
				target.disabled = true;
				mostrarEventos();
			} else {
				Swal.fire({
					title: 'Error',
					text: 'Puedes seleccionar un máximo de cinco eventos',
					icon: 'error',
					confirmButtonText: 'OK'
				});
			}
			
		}

		function mostrarEventos() {
			// Limpiar el HTML
			limpiarEventos();

			if(eventos.length > 0) {
				eventos.forEach( evento => {
					const $evento = document.createElement('DIV');
					$evento.classList.add('registro__evento');
					const titulo = document.createElement('H3');
					titulo.classList.add('registro__nombre');
					titulo.textContent = evento.titulo;

					const botonEliminar = document.createElement('BUTTON');
					botonEliminar.classList.add('registro__eliminar');
					botonEliminar.innerHTML = '<i class="fa-solid fa-trash"></i>';
					botonEliminar.onclick = () => eliminarEvento(evento.id);
					botonEliminar.title = `Eliminar ${evento.titulo}`;
					// Renderizar en el HTML
					$evento.appendChild(titulo);
					$evento.appendChild(botonEliminar);
					$resumen.appendChild($evento);
				});
			} else {
				const $noRegistro = document.createElement('P');
				$noRegistro.textContent = 'No hay eventos, añade hasta 5 del lado izquierdo';
				$noRegistro.classList.add('registro__texto');
				$resumen.appendChild($noRegistro);
			}
		}

		function eliminarEvento(id) {
			eventos = eventos.filter( evento => evento.id !== id);
			let boton = document.querySelector(`[data-id="${id}"]`);
			boton.disabled = false;
			mostrarEventos();
		}

		function limpiarEventos() {
			while($resumen.firstChild) {
				$resumen.removeChild($resumen.firstChild);
			}
		}

		async function submitFormulario(e) {
			e.preventDefault();

			// Obtener el regalo
			const regaloId = document.querySelector('#regalo').value;
			const eventosId = eventos.map(evento => evento.id);
			if(eventosId.length === 0 || regaloId === ''){
				Swal.fire({
					title: 'Error',
					text: 'Elige al menos un Evento y un Regalo',
					icon: 'error',
					confirmButtonText: 'OK'
				});
				return;
			}

			// Objetos de formdata
			const datos = new FormData();
			datos.append('eventos', eventosId);
			datos.append('regalo_id', regaloId);

			const url = '/finalizar-registro/conferencias';
			const respuesta = await fetch(url, {
				method: 'POST',
				body: datos
			});
			const resultado = await respuesta.json();
			console.log(resultado);

			if(resultado.resultado){
				Swal.fire({
					icon: 'success',
					title: 'Registro exitoso',
					html: mensajeAlertas(resultado.alertas)
				}).then( () => location.href = `/boleto?id=${resultado.token}`);
			}else {
				Swal.fire({
					title: 'Error',
					html: mensajeAlertas(resultado.alertas),
					icon: 'error',
					confirmButtonText: 'OK'
				}).then( () => location.reload());
			}
		}

		function mensajeAlertas(alertas) {
			let html = '';
			Object.keys(alertas).forEach(tipo => {
				alertas[tipo].forEach(mensaje => {
					html += `<div class="alerta alerta__${tipo}">${mensaje}</div>`;
				});
			});
			return html;
		}
	}
	
})();