function promote_standalone() {
	if (is_standalone()) {
		// Web app is on the home screen, enable pull-to-refresh

		// Get the size of the notch area
		var safeTop = getComputedStyle(document.documentElement).getPropertyValue('--safe-top').replace('px', '');
		if (!safeTop) {
			// If is fails, set to 0
			var safeTop = 0;
		}

		// Define the pull-to-refresh distances based on notch size
		var distThreshold = parseInt(safeTop) + 52,
			distMax = parseInt(safeTop) + 80,
			distReload = parseInt(safeTop) + 44;

		// Initiate pull-to-refresh with parameters and refresh action
		PullToRefresh.init({
			mainElement: '.container',
			distThreshold: distThreshold,
			distMax: distMax,
			distReload: distReload,
			onRefresh: function () {
				window.location.reload();
			},
		});
	} else if (navigator.userAgent.indexOf('iPhone') != -1 || navigator.userAgent.indexOf('iPad') != -1) {
		// Web app is not added to home screen, promote web app for iOS
		if (document.getElementById('promote_webapp')) {
			document.getElementById('promote_webapp').style.display = 'block';
		}
		// Can be overwritten by lack of share sheet support of user-agent
		// See /scripts/share_button.js
	} else {
		// Not iOS
	}
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
