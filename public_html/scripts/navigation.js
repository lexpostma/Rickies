// Get #anchor from the URL to trigger the navigation function
function get_anchor_from_url() {
	var anchor = window.location.hash.substr(1);

	if (anchor.includes('-')) {
		// For picks, the menu and pick id are combined with a dash
		// Here we split them and set the anchor for the menu, and a scroll_to to the pick
		var scroll_to = anchor.split('-')[1];
		anchor = anchor.split('-')[0];
	}

	if (anchor == '' || anchor == 'top' || anchor == 'results') {
		var menu_items = document.getElementsByClassName('menu_item');
		var first_item = menu_items[0].id.replace('menu_', '');
		navigate_section(first_item, true);
	} else {
		navigate_section(anchor);
	}

	if (scroll_to) {
		// Define element with ID
		scroll_to = document.getElementById(scroll_to);
		if (scroll_to) {
			// After delay scroll to element and add .target class
			// Add delay because browser anchor and navigation is being done first
			setTimeout(function () {
				scroll_to.classList.add('target');
				scroll_to.scrollIntoView({ behavior: 'smooth', block: 'center', inline: 'nearest' });
			}, 50);
		}
	}
}
document.addEventListener('DOMContentLoaded', function (event) {
	get_anchor_from_url();
});

// Show the active menu, hide the others
function navigate_section(section, first = false) {
	// Remove the "active" class from all menu items
	Array.from(document.querySelectorAll('.menu_item')).forEach(function (el) {
		el.classList.remove('active');
	});
	// Remove the "active" class from all sections
	Array.from(document.querySelectorAll('section.navigate_with_mobile_menu')).forEach(function (el) {
		el.classList.remove('active');
	});
	// Remove the "active" class from all grid elements
	Array.from(document.querySelectorAll('.host_stats')).forEach(function (el) {
		el.classList.remove('active');
	});

	// Add the "active" class to the chosen section and menu item
	var active_menu = document.getElementById('menu_' + section);
	var active_section = document.getElementById(section);
	active_menu.classList.add('active');

	// If the section is "stats", make sure the first column inside is also active
	// and the accompanying menu item too
	// so that there's something to see when user resizes window
	if (section == 'stats') {
		if (!triple_j) {
			var col_id = 'myke';
		} else {
			var col_id = 'jason';
		}
		document.getElementById('menu_' + col_id).classList.add('active');
	} else {
		var col_id = section;
	}

	// For Leaderboard, on small screens the section is split
	// and the menu should navigate some of the grid items
	var grid_items = document.querySelectorAll('.host_stats.column_' + col_id);
	if (grid_items.length !== 0) {
		Array.from(grid_items).forEach(function (el) {
			// Make each grid item for this column active
			el.classList.add('active');
		});
		// It should also make the "stats" section and menu items active
		// so the menu is active when user resizes window
		// and the section is visible for the grid to be displayed
		document.getElementById('menu_stats').classList.add('active');
		var active_section = document.getElementById('stats');
	}
	active_section.classList.add('active');

	if (!first) {
		location.replace(location.pathname + location.search + '#' + section);
		active_section.scrollIntoView();
	}
}

// STICKY MENU
const nav_content = document.getElementById('nav_content_sticky');
const nav_anchor = document.getElementById('nav_anchor');
var nav_position = nav_anchor.getBoundingClientRect().top;
var statusbar_height = document.getElementById('statusbar').offsetHeight;
const theme_color_original = document.querySelector('meta[name=theme-color]').getAttribute('content');

const add_class_on_scroll = () => nav_content.parentElement.classList.add('sticky');
const remove_class_on_scroll = () => nav_content.parentElement.classList.remove('sticky');

// Toggle stickiness of nav bar
function make_nav_sticky() {
	statusbar_height = document.getElementById('statusbar').offsetHeight;
	nav_position = nav_anchor.getBoundingClientRect().top;

	if (nav_position <= statusbar_height) {
		// Make nav sticky
		add_class_on_scroll();
		document.querySelector('meta[name=theme-color]').setAttribute('content', '#0d87ca');
	} else {
		// Remove stickiness
		remove_class_on_scroll();
		document.querySelector('meta[name=theme-color]').setAttribute('content', theme_color_original);
	}
}

window.addEventListener('scroll', function () {
	make_nav_sticky();
});

window.addEventListener('resize', function () {
	make_nav_sticky();
});
