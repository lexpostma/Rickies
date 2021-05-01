function update_rules(value) {
	document.getElementById('date_label').textContent = rickies_event_names[value];
	document.getElementById('active_date').textContent = rickies_event_dates[value];

	// Show the rules that do match the selected event
	// Remove class "hidden" from the <li>
	Array.from(document.querySelectorAll('li.rule.' + rickies_event_classes[value])).forEach(function (el) {
		show_rule(el);
	});

	// Hide the rules that do not match the selected event
	// Add class "hidden" to the <li>
	Array.from(document.querySelectorAll('li.rule:not(.' + rickies_event_classes[value] + ')')).forEach(function (el) {
		hide_rule(el);
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
