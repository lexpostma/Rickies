const button = document.getElementById('reset_button');
const selectTags = document.getElementsByTagName('select');
const inputTags = document.getElementsByTagName('input');

function reset_filter() {
	for (var i = 0; i < inputTags.length; ++i) {
		inputTags[i].checked = false;
	}

	for (var i = 0; i < selectTags.length; i++) {
		selectTags[i].selectedIndex = 0;
		selectTags[i].setAttribute('data-chosen', '');
	}

	button.disabled = true;
}

document.addEventListener('input', (evt) => {
	button.disabled = false;
});

const inline_search = document.getElementById('inline_search');
const filter_details = document.getElementById('filter_details');

// Show/hide the original search button when filters are opened.
// There's an extra button inside the "details"
filter_details.addEventListener('toggle', function () {
	if (filter_details.open) {
		inline_search.classList.add('summary_open');
	} else {
		inline_search.classList.remove('summary_open');
	}
});

var checkbox = document.getElementById('cat_group-services');
checkbox.indeterminate = true;
