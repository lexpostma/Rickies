function open_share_sheet() {
	if (navigator.share) {
		navigator
			.share({
				title: document.getElementsByTagName('title')[0].innerHTML,
				url: window.location.href,
			})
			.then(() => {
				console.log('Thanks for sharing!');
			})
			.catch(console.error);
	} else {
		// shareDialog.classList.add('is-open');
		console.log('No sharing support...');
	}
}

document.addEventListener('DOMContentLoaded', function (event) {
	// Hide elements to trigger the share sheet, of share sheet is not supported by user-agent
	if (!navigator.share) {
		Array.from(document.getElementsByClassName('offer_sheet')).forEach(function (el) {
			el.style.display = 'none';
		});
	}

	if (window.navigator.standalone == true) {
		// Web app is on the home screen
	} else {
		// Not added to home screen, hide share button since it's in the browser
		document.getElementById('share_button').style.display = 'none';
	}
});
