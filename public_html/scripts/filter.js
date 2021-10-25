var button = document.getElementById('reset_button');
var selectTags = document.getElementsByTagName('select');
var inputTags = document.getElementsByTagName('input');

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
