import Swal from "sweetalert2";

(function() {
	let eventos = [];
	const $eventosBoton = document.querySelectorAll('.evento__agregar'),
		  $resumen = document.querySelector('#registro-resumen');
	$eventosBoton.forEach(boton => boton.addEventListener('click', seleccionarEvento));

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
	}
})();