// Update the interactive picks
function update_pick(pick) {
	// Get the points for this pick
	var points = pick.getElementsByClassName('points')[0];

	// Update the pick's state
	// Unknown > Correct > Wrong > Unknown
	if (points.classList.contains('correct')) {
		points.classList.remove('correct');
		points.classList.add('wrong');
		update_pick_points(points, 'wrong');
		pick.classList.add('manual');
	} else if (points.classList.contains('wrong')) {
		points.classList.remove('wrong');
		update_pick_points(points, 'unknown');
		pick.classList.remove('manual');
	} else {
		points.classList.add('correct');
		update_pick_points(points, 'correct');
		pick.classList.add('manual');
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
			new_points = score + ' point';
		} else {
			new_points = score + ' points';
		}
	}
	new_points = new_points + ' • ' + correct + '/' + count;
	host_picks.getElementsByClassName('host_score')[0].innerText = new_points;
}
