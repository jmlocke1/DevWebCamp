function paginaActual(){
	const urlActual = window.location;
	const enlace = document.querySelector(`a[href="${urlActual.pathname}"]`);
	if(enlace){
		enlace.classList.add('dashboard__enlace--actual');
	}
}

window.addEventListener('load', function() {
	paginaActual();
});