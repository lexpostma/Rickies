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

// Allow drag to scroll on timeline
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
	const walk = (x - startX) * 3; //scroll-fast
	timeline_content.scrollLeft = scrollLeft - walk;
	console.log(walk);
});
