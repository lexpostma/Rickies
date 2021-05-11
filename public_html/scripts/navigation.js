// Get #anchor from the URL to trigger the navigation function
function get_anchor_from_url() {
	var anchor = window.location.hash.substr(1);

	if (anchor == '') {
		var menu_items = document.getElementsByClassName('menu_item');
		var first_item = menu_items[0].id.replace('menu_', '');
		navigate_section(first_item);
	} else {
		navigate_section(anchor);
	}
}
get_anchor_from_url();

// Show the active menu, hide the others
function navigate_section(section) {
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
}

// STICKY MENU
const nav_content = document.querySelector('.nav_content');
const nav_anchor = document.querySelector('.nav_anchor');
let nav_position = nav_anchor.getBoundingClientRect().top;
// let nav_height = document.querySelector(".nav_content").offsetHeight;
// let statusbar_height = document.querySelector(".statusbar").offsetHeight;

const add_class_on_scroll = () => nav_content.parentElement.classList.add('sticky');
const remove_class_on_scroll = () => nav_content.parentElement.classList.remove('sticky');

// Toggle stickiness of nav bar
function make_nav_sticky() {
	// statusbar_height = document.querySelector(".statusbar").offsetHeight;
	nav_position = nav_anchor.getBoundingClientRect().top;
	// console.log(nav_position);
	// if (nav_position <= statusbar_height) {
	if (nav_position <= 0) {
		add_class_on_scroll();
	} else {
		remove_class_on_scroll();
	}
}

// Define the height of the nav bar and it's anchor/sticky-fillup
function set_nav_height() {
	var nav_height = document.querySelector('.nav_content').offsetHeight;
	// console.log('resizing, height=' + nav_height);
	Array.from(document.querySelectorAll('.navigate_with_mobile_menu')).forEach(function (el) {
		el.style.paddingTop = nav_height + 'px';
	});

	if (window.innerWidth > 768) {
		Array.from(document.querySelectorAll('.navigate_with_mobile_menu'))
			.slice(0, -1)
			.forEach(function (el) {
				// el.style.paddingTop = nav_height + 'px';
				el.style.marginBottom = '-' + nav_height + 'px';
			});
	}
}
set_nav_height();

window.addEventListener('scroll', function () {
	// set_nav_height();
	make_nav_sticky();
});

window.addEventListener('resize', function () {
	set_nav_height();
	make_nav_sticky();
});
