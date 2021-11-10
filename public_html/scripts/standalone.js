function promote_standalone() {
	if (window.navigator.standalone == true) {
		// Web app is on the home screen, enable pull-to-refresh
		PullToRefresh.init({
			mainElement: '.container',
			onRefresh: function () {
				// alert('refresh');
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

document.addEventListener('DOMContentLoaded', function (event) {
	promote_standalone();
});
