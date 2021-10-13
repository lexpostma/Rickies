function toggle_search() {
	var searchbox = document.getElementById('fixed_search');
	var toggle_button = document.getElementById('search_button');
	var search_field = document.getElementById('search_input');

	if (searchbox.classList.contains('open')) {
		searchbox.classList.remove('open');
		toggle_button.classList.remove('open');
		search_field.blur();
		enableScroll();
	} else {
		searchbox.classList.add('open');
		toggle_button.classList.add('open');
		search_field.focus();
		disableScroll();
	}
}

function disableScroll() {
	// Get the current page scroll position
	scrollTop = window.pageYOffset || document.documentElement.scrollTop;
	(scrollLeft = window.pageXOffset || document.documentElement.scrollLeft),
		// if any scroll is attempted, set this to the previous value
		(window.onscroll = function () {
			window.scrollTo(scrollLeft, scrollTop);
		});
}

function enableScroll() {
	window.onscroll = function () {};
}
