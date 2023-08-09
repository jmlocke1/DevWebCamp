function paginaActual(){
	const urlActual = window.location.pathname;
	const isAdmin = urlActual.includes('admin');
	const classToAdd = isAdmin ? 'dashboard__enlace--actual' : 'navegacion__enlace--actual';
	const typeNavigation = isAdmin ? '.dashboard__menu' : '.navegacion';
	const enlace = document.querySelector(`${typeNavigation} a[href="${urlActual}"]`);
	if(enlace){
		enlace.classList.add(classToAdd);
	}
}

window.addEventListener('load', function() {
	paginaActual();
});