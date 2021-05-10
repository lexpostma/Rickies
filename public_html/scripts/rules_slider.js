var paper = document.getElementById('the_document');
var document_date = document.getElementById('document_date');
var slider_label = document.getElementById('slider_label');
var no_rules_string = document.getElementById('no_rules_string');

function update_rules(value) {
	// Update labels
	slider_label.innerHTML = rickies_event_names[value];
	document_date.innerHTML = rickies_event_dates[value];
	no_rules_string.innerHTML = rickies_event_names[value];

	// Check is the list is empty (all <li> rules inside are hidden )
	// If empty, also hide the title (previous sibling of the <ol>)
	Array.from(document.querySelectorAll('ol.rules')).forEach(function (el) {
		if (el.querySelectorAll('li.rule:not(.hidden)').length === 0) {
			hide_rule(el.previousSibling);
		}
	});

	Array.from(document.querySelectorAll('li.rule')).forEach(function (el) {
		if (el.dataset.startDate <= rickies_event_values[value] && el.dataset.endDate >= rickies_event_values[value]) {
			// Show the rules that have started _on_ or _before_ the selected event data
			// AND ended _on_ or _after_ the selected event data
			// Remove class "hidden" from the <li>
			show_rule(el);

			// If a rule is shown, the entire paper and its title should also be shown
			paper.classList.remove('hidden');
			// Title <h2> is sibling before the <li>'s parent <ol>
			show_rule(el.parentNode.previousSibling);
		} else {
			// Add class "hidden" to the <li>
			hide_rule(el);
		}
	});
}

function hide_rule(element) {
	// Delay needs to be as long as
	// transition-duration + transition-delay in the .hidden class
	var delayInMilliseconds = 750;

	element.classList.add('hidden');

	// With each hiding of an element, check is paper still contains rules.
	// Hide entire paper if it doesn't have content/rules
	if (paper.querySelectorAll('li.rule:not(.hidden)').length === 0) {
		paper.classList.add('hidden');
	}

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
