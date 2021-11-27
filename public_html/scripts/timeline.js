const timeline = document.getElementById('timeline');
const zoomin_button = document.getElementById('zoomin_button');
const zoomout_button = document.getElementById('zoomout_button');
const defaultZoom = getComputedStyle(timeline).getPropertyValue('--day-scale');
const timeline_content = document.getElementsByClassName('timeline--content')[0];
const first_month = document.getElementsByClassName('month')[0];

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
}

function set_timeline_scale_labels() {
	// Should be the same as var.$hover-duration in CSS
	// Timeout is needed because the animation delays the width measurement
	var delayInMilliseconds = 300;

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

// Make sure the end of the timeline is in view on load
// Via: https://stackoverflow.com/a/56747348
// And the labels are correctly visible
document.addEventListener('DOMContentLoaded', function (event) {
	timeline_content.scrollLeft = timeline_content.scrollWidth;
	set_timeline_scale_labels();
});

window.addEventListener('resize', function () {
	set_timeline_scale_labels();
});

// When timeline is hidden on mobile, and than resized, it defines label size at 0
// So when timeline is visible again, it should recalculate the size
document.getElementById('menu_timeline').addEventListener('click', function () {
	set_timeline_scale_labels();
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
// hammertime.get('pinch').set({ enable: true });
var mc = new Hammer.Manager(timeline_content);
var pinch = new Hammer.Pinch();
mc.add([pinch]);

mc.on('pinch', function (ev) {
	myElement.textContent += ev.type + ' ';
});
