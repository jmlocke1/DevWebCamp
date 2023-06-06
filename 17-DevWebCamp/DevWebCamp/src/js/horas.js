(function() {
	const $horas = document.querySelector('#horas');
	if($horas){
		const 	$dias = document.querySelectorAll('[name="dia"]'),
				$inputHiddenDia = document.querySelector('[name="dia_id"]'),
				$inputHiddenHora = document.querySelector('[name="hora_id"]'),
				$categoria = document.querySelector('[name="categoria_id"]'),
				$categoriaOpciones = document.querySelectorAll('#categoria option'),
				$categoriaSeleccionada = document.querySelector('#categoria'),
				$diaSeleccionado = document.querySelector('[name="dia"]:checked') || '';
		let busqueda = {
			categoria_id: +$categoriaSeleccionada.value || '',
			dia: +$diaSeleccionado.value
		};
		
		try {
			if(editar){
				(async () => {
					await buscarEventos();
					activaHoraAEditar();
				})();
			}
		} catch (error) {
			// No estamos editando, por tanto, no hacemos nada
		}
		
		$categoria.addEventListener('change', terminoBusqueda);
		$dias.forEach(dia => dia.addEventListener('change', terminoBusqueda));

		function activaHoraAEditar(selecciona = true) {
			try {
				const $categoriaEd = document.querySelector('#categoria'),
						$dia = document.querySelector('[name="dia"]:checked');
				
				if(+$categoriaEd.value == editar.categoria && +$dia.value == editar.dia){
					const $horaSeleccionada = document.querySelector(`[data-hora-id="${editar.hora}"]`);
					$horaSeleccionada.classList.remove('horas__hora--deshabilitada');
					if(selecciona) $horaSeleccionada.classList.add('horas__hora--seleccionada');
					$horaSeleccionada.onclick = seleccionarHora;
				}

			} catch (error) {
				return; // No estamos editando
			}
		}

		function deselect(){
			$dias.forEach( dia => dia.checked = false);
			$categoriaOpciones.forEach( categoria => categoria.selected = false);
		}

		function terminoBusqueda(e) {
			busqueda[e.target.name] = e.target.value;

			// Reiniciar los campos ocultos y el selector de horas
			$inputHiddenHora.value = '';
			$inputHiddenDia.value = '';
			const $horaPrevia = document.querySelector('.horas__hora--seleccionada');
			
			if($horaPrevia){
				$horaPrevia.classList.remove('horas__hora--seleccionada');
			}

			if(Object.values(busqueda).includes('')) {
				return;
			}
			buscarEventos();
		}

		async function buscarEventos() {
			const { dia, categoria_id } = busqueda;
			const url = `/api/eventos-horario?dia_id=${dia}&categoria_id=${categoria_id}`;
			const resultado = await fetch(url);
			const eventos = await resultado.json();
			console.log("Eventos desde la base de datos", eventos)
			obtenerHorasDisponibles(eventos);
		}

		function obtenerHorasDisponibles(eventos) {
			// Reiniciar las horas
			const $listadoHoras = document.querySelectorAll('#horas li');
			$listadoHoras.forEach( li => li.classList.add('horas__hora--deshabilitada'));

			// Comprobar eventos ya tomados y quitar la variable de deshabilitado
			const horasTomadas = eventos.map( evento => evento.hora_id);
			const listadoHorasArray = Array.from($listadoHoras);

			const resultado = listadoHorasArray.filter( li => !horasTomadas.includes(li.dataset.horaId));
			resultado.forEach( li => li.classList.remove('horas__hora--deshabilitada'));

			const $horasNoDisponibles = document.querySelectorAll('.horas__hora--deshabilitada');
			Array.from($horasNoDisponibles).map( hora => hora.removeEventListener('click', seleccionarHora));

			const $horasDisponibles = document.querySelectorAll('#horas li:not(.horas__hora--deshabilitada)');
			$horasDisponibles.forEach( hora => hora.addEventListener('click', seleccionarHora));
			activaHoraAEditar(false);
		}

		function seleccionarHora(e) {
			// Deshabilitar la hora previa, si hay un nuevo click
			const $horaPrevia = document.querySelector('.horas__hora--seleccionada');
			
			if($horaPrevia){
				$horaPrevia.classList.remove('horas__hora--seleccionada');
			}
			// Agregar clase de seleccionado
			e.target.classList.add('horas__hora--seleccionada');

			$inputHiddenHora.value = e.target.dataset.horaId;

			// Llenar el campo oculto de dia
			$inputHiddenDia.value = document.querySelector('[name="dia"]:checked').value;
		}
	} 
})();