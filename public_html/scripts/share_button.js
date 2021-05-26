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
	if (window.navigator.standalone == true && document.getElementById('share_button') && navigator.canShare) {
		// Web app is on the home screen,
		// show share button since there's no browser UI

		document.getElementById('share_button').style.display = 'block';
	}
});
