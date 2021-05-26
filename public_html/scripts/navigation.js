// Get #anchor from the URL to trigger the navigation function
function get_anchor_from_url() {
	var anchor = window.location.hash.substr(1);

	if (anchor == '' || anchor == 'top') {
		var menu_items = document.getElementsByClassName('menu_item');
		var first_item = menu_items[0].id.replace('menu_', '');
		navigate_section(first_item, true);
	} else {
		navigate_section(anchor);
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

	// Add the "active" class to the chosen section and menu item
	var active_menu = document.getElementById('menu_' + section);
	var active_section = document.getElementById(section);
	active_menu.classList.add('active');
	active_section.classList.add('active');

	if (!first) {
		location.replace('#' + section);
		active_section.scrollIntoView();
	}
}

// STICKY MENU
const nav_content = document.getElementById('nav_content');
const nav_anchor = document.getElementById('nav_anchor');
var nav_position = nav_anchor.getBoundingClientRect().top;
var statusbar_height = document.getElementById('statusbar').offsetHeight;

const add_class_on_scroll = () => nav_content.parentElement.classList.add('sticky');
const remove_class_on_scroll = () => nav_content.parentElement.classList.remove('sticky');

// Toggle stickiness of nav bar
function make_nav_sticky() {
	statusbar_height = document.getElementById('statusbar').offsetHeight;
	nav_position = nav_anchor.getBoundingClientRect().top;

	if (nav_position <= statusbar_height) {
		add_class_on_scroll();
	} else {
		remove_class_on_scroll();
	}
}

window.addEventListener('scroll', function () {
	make_nav_sticky();
});

window.addEventListener('resize', function () {
	make_nav_sticky();
});
