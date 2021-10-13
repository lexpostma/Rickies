const searchbox = document.getElementById('fixed_search');
const toggle_button = document.getElementById('search_button');
const search_field = document.getElementById('search_input');

function toggle_search() {
	if (searchbox.classList.contains('open')) {
		close_search();
	} else {
		open_search();
	}
}

function open_search() {
	searchbox.classList.add('open');
	toggle_button.classList.add('open');
	search_field.focus();
	document.body.style.overflowY = 'hidden';
	document.body.style.height = 'calc(100% + env(safe-area-inset-top)';
	document.getElementsByTagName('html')[0].style.height = 'calc(100% + env(safe-area-inset-top)';
}
function close_search() {
	searchbox.classList.remove('open');
	toggle_button.classList.remove('open');
	search_field.blur();
	document.body.style.overflowY = '';
	document.body.style.height = '';
	document.getElementsByTagName('html')[0].style.height = '';
}

// Press ESC to close the search box
// Via https://stackoverflow.com/a/3369743
document.onkeydown = function (evt) {
	evt = evt || window.event;
	var isEscape = false;
	if ('key' in evt) {
		isEscape = evt.key === 'Escape' || evt.key === 'Esc';
	} else {
		isEscape = evt.keyCode === 27;
	}
	if (isEscape) {
		close_search();
	}
};

// Click outside the search box to close, but not the search box itself
// Via https://stackoverflow.com/a/41178624
searchbox.onclick = function () {
	close_search();
	// alert('You clicked on parent');
};
document.getElementById('search_form').onclick = function () {
	event.stopPropagation();
	// alert('You clicked on child');
};
