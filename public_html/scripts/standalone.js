function refresh_inprogress(el) {
	el.innerText = 'Refreshing…';
}

function promote_standalone() {
	console.log(navigator.userAgent);
	if (navigator.userAgent.indexOf('iPhone') != -1 || navigator.userAgent.indexOf('iPad') != -1) {
		if (window.navigator.standalone == true) {
			// Added to home screen, offer refresh
			document.getElementById('refresh_page').style.display = 'block';
		} else {
			// Not added to home screen, promote web app
			document.getElementById('promote_webapp').style.display = 'block';
			// Can be overwritten by lack of share sheet support of user-agent
			// See /scripts/share_button.js
		}
	} else {
		// Not iOS
	}
}

document.addEventListener('DOMContentLoaded', function (event) {
	promote_standalone();
});
