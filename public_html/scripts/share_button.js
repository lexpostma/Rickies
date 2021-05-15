function share_button() {
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
	if (!navigator.share) {
		Array.from(document.getElementsByClassName('offer_sheet')).forEach(function (el) {
			el.style.display = 'none';
		});
	}
});
