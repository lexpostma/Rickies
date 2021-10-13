function toggle_search() {
	var searchbox = document.getElementById('fixed_search');
	var toggle_button = document.getElementById('search_button');
	var search_field = document.getElementById('search_input');

	if (searchbox.classList.contains('open')) {
		searchbox.classList.remove('open');
		toggle_button.classList.remove('open');
		search_field.blur();
		document.body.style.overflowY = '';
		document.body.style.height = '';
		document.getElementsByTagName('html')[0].style.height = '';
	} else {
		searchbox.classList.add('open');
		toggle_button.classList.add('open');
		search_field.focus();
		document.body.style.overflowY = 'hidden';
		document.body.style.height = '100%';
		document.getElementsByTagName('html')[0].style.height = '100%';
	}
}
