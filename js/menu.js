  // Gestion du menu responsive

const burgerMenuButton = document.querySelector('.icon-burger')
const burgerMenuButtonIcon = document.querySelector('.icon-burger i')
const burgerMenu = document.querySelector('.burger-menu')

burgerMenuButton.onclick = function(){
	burgerMenu.classList.toggle('open')
	const isOpen = burgerMenu.classList.contains('open')
	burgerMenuButtonIcon.classList = isOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars'
}