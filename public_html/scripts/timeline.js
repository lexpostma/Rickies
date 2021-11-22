const timeline = document.getElementById('timeline');
const zoomin_button = document.getElementById('zoomin_button');
const zoomout_button = document.getElementById('zoomout_button');
const defaultZoom = getComputedStyle(timeline).getPropertyValue('--day-scale');
const timeline_content = document.getElementsByClassName('timeline--content')[0];

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
	console.log('old: ' + currentWidth + ' • new: ' + newWidth);

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
}

// Make sure the end of the timeline is in view on load
// Via: https://stackoverflow.com/a/56747348
document.addEventListener('DOMContentLoaded', function (event) {
	timeline_content.scrollLeft = timeline_content.scrollWidth;
});

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

// TODO: Allow pinch to zoom in and out
// Via: https://stackoverflow.com/a/11183333
