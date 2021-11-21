const timeline = document.getElementById('timeline');
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
}

document.addEventListener('DOMContentLoaded', function (event) {
	timeline_content.scrollLeft = timeline_content.scrollWidth;
});
