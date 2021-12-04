const timeline = document.getElementById('timeline');
const zoomin_button = document.getElementById('zoomin_button');
const zoomout_button = document.getElementById('zoomout_button');
const defaultZoom = getComputedStyle(timeline).getPropertyValue('--day-scale');
const timeline_content = document.getElementsByClassName('timeline--content')[0];
const first_month = document.getElementsByClassName('month')[0];

// Should be the same as var.$hover-duration in CSS
var delayInMilliseconds = 300;

function timeline_zoom(direction) {
	var currentWidth = getComputedStyle(timeline).getPropertyValue('--day-scale');
	let zoomFactor = 1.25;

	if (direction == 'in') {
		newWidth = currentWidth * zoomFactor;
	} else if (direction == 'out') {
		newWidth = currentWidth / zoomFactor;
	} else {
		newWidth = defaultZoom;
	}
	timeline.style.setProperty('--day-scale', newWidth);
	// console.log('old: ' + currentWidth + ' • new: ' + newWidth);

	if (newWidth > 5) {
		// Disable zoom in button
		zoomin_button.disabled = true;
		zoomout_button.disabled = false;
	} else if (newWidth < 0.29) {
		// Disable zoom out button
		zoomin_button.disabled = false;
		zoomout_button.disabled = true;
	} else {
		// Enable both zoom buttons
		zoomin_button.disabled = false;
		zoomout_button.disabled = false;
	}

	set_timeline_scale_labels();
	setTimeout(function () {
		set_timeline_avatar_winner();
	}, delayInMilliseconds);
}

function set_timeline_scale_labels() {
	// Timeout is needed because the animation delays the width measurement

	setTimeout(function () {
		// console.log(first_month.offsetWidth);
		if (first_month.offsetWidth < 20) {
			timeline_content.classList.add('month_xx');
			timeline_content.classList.remove('month_sm');
			timeline_content.classList.remove('month_md');
		} else if (first_month.offsetWidth < 32) {
			timeline_content.classList.add('month_sm');
			timeline_content.classList.remove('month_xx');
			timeline_content.classList.remove('month_md');
		} else if (first_month.offsetWidth < 60) {
			timeline_content.classList.add('month_md');
			timeline_content.classList.remove('month_xx');
			timeline_content.classList.remove('month_sm');
		} else {
			timeline_content.classList.remove('month_xx');
			timeline_content.classList.remove('month_sm');
			timeline_content.classList.remove('month_md');
		}
	}, delayInMilliseconds);
}

// Allow drag to scroll on timeline
// Via: https://codepen.io/thenutz/pen/VwYeYEE
let isDown = false;
let startX;
let scrollLeft;

timeline_content.addEventListener('mousedown', (e) => {
	isDown = true;
	// timeline_content.classList.add('active');
	startX = e.pageX - timeline_content.offsetLeft;
	scrollLeft = timeline_content.scrollLeft;
});
timeline_content.addEventListener('mouseleave', () => {
	isDown = false;
	// timeline_content.classList.remove('active');
});
timeline_content.addEventListener('mouseup', () => {
	isDown = false;
	// timeline_content.classList.remove('active');
});
timeline_content.addEventListener('mousemove', (e) => {
	if (!isDown) return;
	e.preventDefault();
	const x = e.pageX - timeline_content.offsetLeft;
	const walk = (x - startX) * 1; //scroll-fast
	timeline_content.scrollLeft = scrollLeft - walk;
	// console.log(walk);
});

function toggle_timeline_track(track) {
	var all_tracks = document.querySelectorAll('.timeline--chairman-track');
	var annual_tracks = document.querySelectorAll('.timeline--chairman-track.annual');
	var keynote_tracks = document.querySelectorAll('.timeline--chairman-track.keynote');
	var action = '';

	// Check if a track is already hidden
	if (
		(track == 'annual' && !annual_tracks[0].classList.contains('hidden')) ||
		(track == 'keynote' && !keynote_tracks[0].classList.contains('hidden'))
	) {
		var action = 'hide';
	}

	// Show all track again
	Array.from(all_tracks).forEach(function (el) {
		el.classList.remove('hidden');
	});
	document.querySelector('.timeline--legend-item.annual').classList.remove('hidden');
	document.querySelector('.timeline--legend-item.keynote').classList.remove('hidden');

	if (track == 'annual' && action == 'hide') {
		// Hide Annual tracks
		Array.from(annual_tracks).forEach(function (el) {
			el.classList.add('hidden');
		});
		document.querySelector('.timeline--legend-item.annual').classList.add('hidden');
	} else if (track == 'keynote' && action == 'hide') {
		// Hide Keynote tracks
		Array.from(keynote_tracks).forEach(function (el) {
			el.classList.add('hidden');
		});
		document.querySelector('.timeline--legend-item.keynote').classList.add('hidden');
	}

	set_timeline_avatar_winner();
}

const chairmanships = document.querySelectorAll('.chairman');
const avatars = document.getElementsByClassName('timeline--host-avatar');
var winners = ['annual', 'keynote'];

function set_timeline_avatar_winner() {
	// Get the left side of the end gradient, which is the avatar's left edge
	var avatar_edge = document.getElementsByClassName('timeline--gradient-end')[0].getBoundingClientRect().left;

	// Cycle through chairman blobs
	Array.from(chairmanships).forEach(function (el) {
		// If chairman blob's left side is left of avatar's edge, and right side is right of avatar's edge
		// That means they touch, and thus that avatar is a winner
		if (el.getBoundingClientRect().left <= avatar_edge && el.getBoundingClientRect().right >= avatar_edge) {
			// Only mark winner if track is visible
			if (!el.parentNode.classList.contains('hidden')) {
				// Set winner avatars to winners array
				if (el.parentNode.classList.contains('annual')) {
					winners[0] = el.parentNode.parentNode.getElementsByClassName('timeline--host-avatar')[0];
				} else if (el.parentNode.classList.contains('keynote')) {
					winners[1] = el.parentNode.parentNode.getElementsByClassName('timeline--host-avatar')[0];
				}
			}
		}
	});

	// Cycle through all avatars on screen
	Array.from(avatars).forEach(function (el) {
		// if this avatar is in the winners array, it's a winner
		if (winners.includes(el)) {
			el.classList.add('winner');
			// If it's in the winners array for both annual and keynote, it's a mega winner
			if (winners[0] == winners[1]) {
				el.classList.add('mega_winner');
			} else {
				el.classList.remove('mega_winner');
			}
		} else {
			// loser
			el.classList.remove('winner');
			el.classList.remove('mega_winner');
		}
	});
	// Clear array again
	winners = ['annual', 'keynote'];
}

// When scrolling through the timeline, update the winners
timeline_content.addEventListener('scroll', function () {
	set_timeline_avatar_winner();
});

// Make sure the end of the timeline is in view on load
// Via: https://stackoverflow.com/a/56747348
// And the labels are correctly visible
document.addEventListener('DOMContentLoaded', function (event) {
	timeline_content.scrollLeft = timeline_content.scrollWidth;
	set_timeline_scale_labels();
	set_timeline_avatar_winner();
});

window.addEventListener('resize', function () {
	set_timeline_scale_labels();
	set_timeline_avatar_winner();
});

// When timeline is hidden on mobile, and than resized, it defines label size at 0
// So when timeline is visible again, it should recalculate the size
document.getElementById('menu_timeline').addEventListener('click', function () {
	set_timeline_scale_labels();
	set_timeline_avatar_winner();
});
