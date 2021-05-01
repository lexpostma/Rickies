function update_rules(value) {
	document.getElementById('date_label').innerHTML = rickies_event_names[value];
	document.getElementById('active_date').innerHTML = rickies_event_dates[value];

	Array.from(document.querySelectorAll('li.rule')).forEach(function (el) {
		if (el.dataset.startDate <= rickies_event_values[value] && el.dataset.endDate >= rickies_event_values[value]) {
			// Show the rules that have started _on_ or _before_ the selected event data
			// AND ended _on_ or _after_ the selected event data
			// Remove class "hidden" from the <li>
			show_rule(el);
		} else {
			// Add class "hidden" to the <li>
			hide_rule(el);
		}
	});

	// Check is the list is empty (all <li> rules inside are hidden )
	// If empty, also hide the title (previous sibling of the <ol>)
	Array.from(document.querySelectorAll('ol.rules')).forEach(function (el) {
		if (el.querySelectorAll('li.rule:not(.hidden)').length === 0) {
			hide_rule(el.previousSibling);
		} else {
			show_rule(el.previousSibling);
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
