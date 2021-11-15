function refresh_inprogress(el) {
	el.innerText = 'Refreshing…';
}

// Check whether webapp is in standalone mode
function is_standalone() {
	// iOS or Android
	if (window.navigator.standalone == true || window.matchMedia('(display-mode: standalone)').matches) {
		return true;
	} else {
		return false;
	}
}

function promote_standalone() {
	if (is_standalone()) {
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

	if (is_standalone() && share_button) {
		// if (share_button) {
		// NOTE: This is a debugging IF
		// Web app is on the home screen and share button is in DOM,
		// show the share button since there's no browser UI

		share_button.style.display = 'block';
	}
});
