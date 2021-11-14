function refresh_inprogress(el) {
	el.innerText = 'Refreshing…';
}

function promote_standalone() {
	if (window.navigator.standalone == true) {
		// Is on the home screen, offer refresh
		document.getElementById('refresh_page').style.display = 'block';
	} else if (navigator.userAgent.indexOf('iPhone') != -1 || navigator.userAgent.indexOf('iPad') != -1) {
		// Not added to home screen, promote web app for iOS
		if (document.getElementById('promote_webapp')) {
			document.getElementById('promote_webapp').style.display = 'block';
		}
		// Can be overwritten by lack of share sheet support of user-agent
		// See /scripts/share_button.js
	} else {
		// Not iOS
	}
}

document.addEventListener('DOMContentLoaded', function (event) {
	promote_standalone();

	if (window.navigator.standalone == true && document.getElementById('share_button') && share_button) {
		// if (share_button) {
		// NOTE: This is a debugging IF
		// Web app is on the home screen,
		// show share button since there's no browser UI

		share_button.style.display = 'block';
	}
});
