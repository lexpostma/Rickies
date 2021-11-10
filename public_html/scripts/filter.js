const reset_button = document.getElementById('reset_button');
const selectTags = document.getElementsByTagName('select');
const inputTags = document.getElementsByTagName('input');

function reset_filter() {
	for (var i = 0; i < inputTags.length; ++i) {
		if (inputTags[i].type == 'checkbox') {
			inputTags[i].checked = false;
			inputTags[i].indeterminate = false;
		}
	}

	for (var i = 0; i < selectTags.length; i++) {
		selectTags[i].selectedIndex = 0;
		selectTags[i].setAttribute('data-chosen', '');
	}

	reset_button.disabled = true;
}

function check_elements_for_state() {
	// Check if any select is selected
	for (var i = 0; i < selectTags.length; i++) {
		if (selectTags[i].selectedIndex !== 0) {
			return true;
		}
	}

	// Check if any checkbox is checked
	for (var i = 0; i < inputTags.length; ++i) {
		if (inputTags[i].type == 'checkbox' && inputTags[i].checked == true) {
			return true;
		}
	}

	// Nothing is checked or selected
	return false;
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

	//  exit if change event did not come from
	//  our list of allThings
	if (allThings.indexOf(check) === -1) return;

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
