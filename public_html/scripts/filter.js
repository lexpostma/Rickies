const reset_button = document.getElementById('reset_button');
const selectTags = document.getElementsByTagName('select');
const inputTags = document.getElementsByTagName('input');

function reset_filter() {
	for (var i = 0; i < inputTags.length; ++i) {
		if (inputTags[i].type == 'checkbox') {
			inputTags[i].checked = false;
			inputTags[i].indeterminate = false;
		} else if (inputTags[i].type == 'number') {
			inputTags[i].value = '';
		}
	}

	for (var i = 0; i < selectTags.length; i++) {
		reset_select(selectTags[i]);
	}

	host_flip_3j(document.getElementsByClassName('triple_j_filter')[0]);
	reset_button.disabled = true;
}

function reset_select(el) {
	el.selectedIndex = 0;
	el.setAttribute('data-chosen', '');
}
function number_input_state() {
	var active_number_inputs = [];

	for (var i = 0; i < inputTags.length; ++i) {
		if (inputTags[i].type == 'number') {
			if (inputTags[i].value) {
				active_number_inputs.push(inputTags[i]);
			} else {
				inputTags[i].parentNode.classList.remove('active');
			}
		}
	}
	if (active_number_inputs.length != 0) {
		for (var i = 0; i < active_number_inputs.length; ++i) {
			active_number_inputs[i].parentNode.classList.add('active');
		}
	}
}

function check_elements_for_state() {
	number_input_state();

	for (var i = 0; i < inputTags.length; ++i) {
		if (inputTags[i].type == 'number' && inputTags[i].value) {
			// Check if any number input has a value
			return true;
		} else if (inputTags[i].type == 'checkbox' && inputTags[i].checked == true) {
			// Check if any checkbox is checked
			return true;
		}
	}

	// Check if any select is selected
	for (var i = 0; i < selectTags.length; i++) {
		if (selectTags[i].selectedIndex !== 0) {
			return true;
		}
	}

	// Nothing is checked, selected, or entered
	return false;
}

function host_flip_3j(element) {
	// Switch some checkbox around when in 3J mode
	let host_checks = document.querySelectorAll('fieldset.hosts .host');
	let other_checks = document.querySelectorAll('[data-3j]');

	if (element.checked == true) {
		// console.log('Triple J enabled');
		var host_replacements = {
			stephen: 'james',
			myke: 'jason',
			federico: 'john',
			Stephen: 'James',
			Myke: 'Jason',
			Federico: 'John',
		};

		Array.from(other_checks).forEach(function (el) {
			if (el.getAttribute('data-3j') == 'true') {
				el.parentNode.classList.remove('hidden');
			} else if (el.getAttribute('data-3j') == 'false') {
				el.parentNode.classList.add('hidden');
				if (el.type == 'checkbox') {
					el.checked = false;
				} else if (el.tagName == 'SELECT') {
					reset_select(el);
				}
			}
		});
	} else {
		// console.log('Triple J disabled');
		var host_replacements = {
			james: 'stephen',
			jason: 'myke',
			john: 'federico',
			James: 'Stephen',
			Jason: 'Myke',
			John: 'Federico',
		};
		Array.from(other_checks).forEach(function (el) {
			if (el.getAttribute('data-3j') == 'false') {
				el.parentNode.classList.remove('hidden');
			} else if (el.getAttribute('data-3j') == 'true') {
				el.parentNode.classList.add('hidden');
				el.checked = false;
			}
		});
	}
	Array.from(host_checks).forEach(function (el) {
		el.innerHTML = replaceAll(el.innerHTML, host_replacements);
	});
}

// Find and replace multiple strings
// Via https://stackoverflow.com/a/15604206
function replaceAll(str, mapObj) {
	// Replaced 'gi' with 'g', it's now case sensitive
	var re = new RegExp(Object.keys(mapObj).join('|'), 'g');

	return str.replace(re, function (matched) {
		// Remove the lowercase matching
		return mapObj[matched];
	});
}

const search_field_combo = document.getElementById('search_field_combo');
const pick_filter_sheet = document.getElementById('pick_filter_sheet');

// Show/hide the original search button when filters are opened.
// There's an extra button inside the "details"
pick_filter_sheet.addEventListener('toggle', function () {
	if (pick_filter_sheet.open) {
		search_field_combo.classList.add('summary_open');
	} else {
		search_field_combo.classList.remove('summary_open');
	}
});

/*
 * Function to toggle parent and child input as a group
 * Including the 'indeterminate' state of the parent
 * Via https://css-tricks.com/indeterminate-checkboxes/
 */

//  helper function to create nodeArrays (not collections)
const nodeArray = (selector, parent = document) => [].slice.call(parent.querySelectorAll(selector));

//  checkboxes of interest
const allThings = nodeArray('input.category');

//  global listener
addEventListener('change', (e) => {
	// On any change, check if reset button should be enabled of not
	if (check_elements_for_state()) {
		reset_button.disabled = false;
	} else {
		reset_button.disabled = true;
	}

	// define the element that triggered the event
	let check = e.target;

	// Check is element was the Triple JS checkbox
	if (check.parentNode.classList.contains('triple_j_filter')) {
		host_flip_3j(check);
	}

	if (allThings.indexOf(check) === -1)
		//  exit if change event did not come from
		//  our list of allThings
		return;

	//  check/uncheck children (includes check itself)
	const children = nodeArray('input', check.parentNode);
	children.forEach((child) => (child.checked = check.checked));

	//  traverse up from target check
	while (check) {
		//  find parent and sibling checkboxes (quick'n'dirty)
		const parent = check.closest(['ul']).parentNode.querySelector('input');
		const siblings = nodeArray('input', parent.closest('li').querySelector(['ul']));

		//  get checked state of siblings
		//  are every or some siblings checked (using Boolean as test function)
		const checkStatus = siblings.map((check) => check.checked);
		const every = checkStatus.every(Boolean);
		const some = checkStatus.some(Boolean);

		//  check parent if all siblings are checked
		//  set indeterminate if not all and not none are checked
		parent.checked = every;
		parent.indeterminate = !every && every !== some;

		//  prepare for next loop
		check = check != parent ? parent : 0;
	}
});

document.addEventListener('DOMContentLoaded', function (event) {
	// On Load, get all checked category checkboxes
	// and mark (grand)parent as indeterminate if those are not checked
	var cats_checked = document.querySelectorAll('input.category:checked');

	if (cats_checked.length !== 0) {
		for (const element of cats_checked) {
			var parent = element.closest(['ul']).parentNode.querySelector('input');
			var grandparent = parent.closest(['ul']).parentNode.querySelector('input');
			if (!parent.checked) {
				parent.indeterminate = true;
			}
			if (!grandparent.checked) {
				grandparent.indeterminate = true;
			}
		}
	}

	// Check if sheet is open, to know if filters are active on load
	if (pick_filter_sheet.open) {
		// If open, hide the original search button
		search_field_combo.classList.add('summary_open');
		// And make reset button enabled
		reset_button.disabled = false;
	} else {
		// And make reset button disabled
		reset_button.disabled = true;
	}
});
