const document_date = document.getElementById('document_date');
const paper = document.getElementById('the_document');
const slider_label = document.getElementById('slider_label');
const slider = document.querySelector('aside.slider');
const document_title = document.getElementById('document_title');
const disclaimer_title = document.getElementById('disclaimer_title');
const browser_title = document.getElementsByTagName('title')[0];
const rickies_title = document.getElementById('rickies_title');
const flexies_title = document.getElementById('flexies_title');

function slide_event() {
	window.goatcounter.count({
		path: 'Show history',
		title: 'Slide through The Bill of Rickies',
		referrer: window.location.href,
		event: true,
	});
}

function update_rules(value) {
	// Update labels
	slider_label.innerHTML = rickies_event_names[value];
	document_date.innerHTML = rickies_event_dates[value];

	if (!triple_j) {
		if (rickies_event_values[value] < rickies_start && rickies_event_values[value] < bill_start) {
			document_title.innerHTML = 'Drafting Rules';
			disclaimer_title.innerHTML = 'the Drafting Rules';
			browser_title.innerText = browser_title.innerText.replace('The Bill of Rickies', 'Drafting Rules');
			browser_title.innerText = browser_title.innerText.replace('Rickies Rules', 'Drafting Rules');
			paper.classList.remove('parchment');
		} else if (rickies_event_values[value] < bill_start) {
			document_title.innerHTML = 'Rickies Rules';
			disclaimer_title.innerHTML = 'the Rickies Rules';
			browser_title.innerText = browser_title.innerText.replace('The Bill of Rickies', 'Rickies Rules');
			browser_title.innerText = browser_title.innerText.replace('Drafting Rules', 'Rickies Rules');
			paper.classList.remove('parchment');
		} else {
			disclaimer_title.innerHTML = document_title.innerHTML = 'The Bill of Rickies';
			browser_title.innerText = browser_title.innerText.replace('Drafting Rules', 'The Bill of Rickies');
			browser_title.innerText = browser_title.innerText.replace('Rickies Rules', 'The Bill of Rickies');
			paper.classList.add('parchment');
		}

		if (rickies_event_values[value] < rickies_start) {
			rickies_title.innerHTML = 'Predictions';
		} else {
			rickies_title.innerHTML = 'The Rickies';
		}

		if (rickies_event_values[value] < flexies_start) {
			flexies_title.innerHTML = 'Non-graded extra picks';
		} else {
			flexies_title.innerHTML = 'The Flexies';
		}
	}

	// Check is the list is empty (all <li> rules inside are hidden )
	// If empty, also hide the title (previous sibling of the <ol>)
	Array.from(document.querySelectorAll('ol.rules')).forEach(function (el) {
		if (el.querySelectorAll('li.rule:not(.hidden)').length === 0) {
			hide_rule(el.previousSibling);
		}
	});

	Array.from(document.getElementsByClassName('rule')).forEach(function (el) {
		if (el.dataset.startDate <= rickies_event_values[value] && el.dataset.endDate >= rickies_event_values[value]) {
			// Show the rules that have started _on_ or _before_ the selected event data
			// AND ended _on_ or _after_ the selected event data
			// Remove class "hidden" from the <li>
			show_rule(el);

			// Title <h2> is sibling before the <li>'s parent <ol>
			if (el.parentNode.tagName == 'OL' && el.parentNode.previousSibling == 'H2') {
				show_rule(el.parentNode.previousSibling);
			} else if (el.previousSibling == 'H2') {
				show_rule(el.previousSibling);
			}
		} else {
			// Add class "hidden" to the rule
			hide_rule(el);
		}
	});
}

function hide_rule(element) {
	// Delay needs to be as long as
	// transition-duration + transition-delay in the .hidden class
	var delayInMilliseconds = 750;

	element.classList.add('hidden');

	setTimeout(function () {
		element.classList.add('gone');
	}, delayInMilliseconds);
}

function show_rule(element) {
	// Tiny delay between removing classes is to prevent the element from
	// suddenly appearing when "display: none" is removed
	var delayInMilliseconds = 1;

	element.classList.remove('gone');
	setTimeout(function () {
		element.classList.remove('hidden');
	}, delayInMilliseconds);
}

// Toggle rules slider open/closed
document.getElementById('close_button').addEventListener('click', function () {
	if (this.classList.contains('show')) {
		// Button is set to open, slider is not visible yet
		open_slider(this);
	} else {
		// Button is set to close, slider is visible
		close_slider(this);
	}
});

function close_slider(element) {
	// Hide slider
	slider.classList.add('hide');

	// Change button attributes
	element.classList.add('show');
	element.title = 'Hide the history slider';
	element.setAttribute('data-goatcounter-click', 'Hide history slider');

	// Store slider state in cookie
	Cookies.set('slider_closed', 'true', { expires: 7, path: '/billof' });
}
function open_slider(element) {
	// Show slider
	slider.classList.remove('hide');

	// Change button attributes
	element.classList.remove('show');
	element.title = 'Open the history slider';
	element.setAttribute('data-goatcounter-click', 'Open history slider');

	// Store slider state in cookie
	Cookies.set('slider_closed', 'false', { expires: 0, path: '/billof' });
}

// If cookie is set for slider state, close the slider
document.addEventListener('DOMContentLoaded', function (event) {
	if (Cookies.get('slider_closed')) {
		close_slider(document.getElementById('close_button'));
	}
});

// Play theme music
// Via https://stackoverflow.com/a/44361533
document.getElementById('music_button').addEventListener('click', function () {
	var audio = document.getElementById('theme_music');
	if (this.classList.contains('is-playing')) {
		this.classList.remove('is-playing');
		this.title = 'Play theme music for The Bill of Rickies';
		audio.pause();
	} else {
		this.classList.add('is-playing');
		this.title = 'Pause theme music for The Bill of Rickies';
		audio.play();
	}
});
