// Update the interactive picks
function update_pick(pick, state = null) {
	// Get the points for this pick
	var points = pick.getElementsByClassName('points')[0];

	// Update the pick's state
	// Unknown > Correct > Wrong > Unknown
	if (points.classList.contains('correct') || state == 'wrong') {
		points.classList.remove('correct');
		points.classList.add('wrong');
		update_pick_points(points, 'wrong');
		pick.classList.add('manual');
		localStorage.setItem(pick.id, 'wrong');
	} else if (points.classList.contains('wrong') || state == 'unknown') {
		points.classList.remove('wrong');
		update_pick_points(points, 'unknown');
		pick.classList.remove('manual');
		localStorage.removeItem(pick.id);
	} else if (state == 'correct') {
		points.classList.add('correct');
		update_pick_points(points, 'correct');
		pick.classList.add('manual');
		localStorage.setItem(pick.id, 'correct');
	} else {
		points.classList.add('correct');
		update_pick_points(points, 'correct');
		pick.classList.add('manual');
		localStorage.setItem(pick.id, 'correct');
	}

	// Update the host's total score
	update_host_score(pick.parentNode.parentNode);
}

// Update the visible point's per pick
function update_pick_points(points, state) {
	if (points.classList.contains('risky') && state == 'correct') {
		points.innerText = '+2';
	} else if (points.classList.contains('risky') && state == 'wrong') {
		points.innerText = '-1';
	} else if (points.classList.contains('regular') && state == 'correct') {
		points.innerText = '+1';
	} else if (points.classList.contains('regular') && state == 'wrong') {
		points.innerText = '0';
	} else if (points.classList.contains('flexy') && state == 'correct') {
		points.innerText = '💪';
	} else if (points.classList.contains('flexy') && state == 'wrong') {
		points.innerText = '👎';
	} else if (state == 'unknown') {
		points.innerText = '?';
	}
}

// Update the overall host's score
function update_host_score(host_picks) {
	var type = host_picks.id.split('_')[0];
	var count = host_picks.getElementsByClassName('points').length;
	var correct = host_picks.getElementsByClassName('points correct').length;

	// Calculate the score
	var score = 0;
	Array.from(host_picks.getElementsByClassName('points')).forEach(function (points) {
		if (points.classList.contains('risky') && points.classList.contains('correct')) {
			score = score + 2;
		} else if (points.classList.contains('risky') && points.classList.contains('wrong')) {
			score = score - 1;
		} else if (points.classList.contains('correct')) {
			score = score + 1;
		}
	});

	// Define what the points look like
	var new_points;
	if (type == 'flexies') {
		percentage = (correct / count) * 100;
		// Round to 1 decimal
		rounded = percentage.toFixed(1);

		// If decimal is 0, remove decimals
		if (rounded.split('.')[1] == 0) {
			// Explode string by . and only take first part
			rounded = rounded.split('.')[0];
		}
		new_points = rounded + '%';
	} else {
		if (score == 1 || score == -1) {
			new_points = score + '&nbsp;point';
		} else {
			new_points = score + '&nbsp;points';
		}
	}
	new_points = new_points + ' • ' + correct + '/' + count;
	host_picks.getElementsByClassName('host_score')[0].innerHTML = new_points;
}

function clear_manual_score() {
	// Get the id's from all picks on the page
	Array.from(document.getElementsByClassName('pick_item')).forEach(function (el) {
		// And remove each key this said id from localStorage
		localStorage.removeItem(el.id);
	});
	// Then reload to the cleared localStorage, to reset the pick's visual states
	location.reload();
}

if (window.localStorage.length !== 0) {
	// Get all items from localStorage
	for (var i = 0; i < localStorage.length; i++) {
		// For each key in localStorage, check is there's an element that has same id
		if (document.getElementById(localStorage.key(i))) {
			// Update element state with value from localStorage
			update_pick(document.getElementById(localStorage.key(i)), localStorage.getItem(localStorage.key(i)));
		}
	}
}
