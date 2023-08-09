(function() {
	const $tagsInput = document.querySelector('#tags_input');
	if($tagsInput) {
		const $tagsDiv = document.querySelector('#tags');
		const $tagsinputHidden = document.querySelector('[name="tags"]');
		let tags = [];

		// Recuperar del input oculto
		if($tagsinputHidden.value !== '') {
			tags = $tagsinputHidden.value.split(',');
			mostrarTags();
		}
		// Escuchar los cambios en el input
		$tagsInput.addEventListener('keypress', guardarTag);

		function guardarTag(e) {
			if(e.keyCode === 44){
				e.preventDefault();
				if(e.target.value.trim() === '' || e.target.value.lenght < 1 || repeatedTag(tags, e.target.value)) {
					$tagsInput.value = '';
					return;
				}
				
				tags = [...tags, e.target.value.trim()];
				$tagsInput.value = '';
				mostrarTags();
			}
		}

		function mostrarTags() {
			$tagsDiv.textContent = '';
			tags.forEach(tag => {
				const etiqueta = document.createElement('LI');
				etiqueta.classList.add('formulario__tag');
				etiqueta.textContent = tag;
				etiqueta.title = `Doble click para eliminar ${tag}`;
				etiqueta.ondblclick = eliminarTag;
				$tagsDiv.appendChild(etiqueta);
			});
			actualizarInputHidden();
		}

		function actualizarInputHidden() {
			$tagsinputHidden.value = tags.toString();
		}

		function eliminarTag(e) {
			e.target.remove();
			tags = tags.filter(tag => tag!== e.target.textContent);
			console.log(tags);
		}
	}
	function repeatedTag(tags, needle){
		let iguales = false;
		tags.forEach(tag => {
			if(tag.toLowerCase().trim() === needle.toLowerCase().trim()){
				iguales = true;
			}
		});
		return iguales;
	}
})();

