const magtricky = document.getElementById('interactive_magtricky');
const magtricky_chairmen = magtricky.getElementsByTagName('BUTTON');

function update_magtricky(button) {
	var current_state = parseFloat(button.getAttribute('data-chairman'));

	// Count total number of chairmen
	var total_chairmen = 0;
	Array.from(magtricky_chairmen).forEach(function (el) {
		total_chairmen = total_chairmen + parseFloat(el.getAttribute('data-chairman'));
	});

	if (total_chairmen == 0 || total_chairmen == 1) {
		// None or one chairmen, increase clicked by 1
		button.setAttribute('data-chairman', current_state + 1);
	} else if (total_chairmen == 2 && current_state == 2) {
		// Two chairmen total, both on the clicked host, aka it's consolidated > decrease clicked by 1
		button.setAttribute('data-chairman', 1);
	} else if (total_chairmen == 2 && current_state == 0) {
		// Other hosts have title, clicked does not > check what others have and increase clicked by 1
		Array.from(magtricky_chairmen).forEach(function (el) {
			if (parseFloat(el.getAttribute('data-chairman')) == 2) {
				el.setAttribute('data-chairman', 1);
			} else {
				el.setAttribute('data-chairman', 0);
			}
		});
		button.setAttribute('data-chairman', current_state + 1);
	} else {
		// Different chairmen total, probably 2 total, on different hosts > set all to 0 and increase clicked by 1
		Array.from(magtricky_chairmen).forEach(function (el) {
			el.setAttribute('data-chairman', 0);
		});
		button.setAttribute('data-chairman', current_state + 1);
	}
}

// Via https://alexandermonachino.com/ar-quick-look/
function ar_supported() {
	const isiOS12OrNewer = () => {
		const iOS = /iP(hone|od|ad)/.test(navigator.userAgent) && !window.MSStream;
		const iOSVersion = iOS && parseInt(navigator.appVersion.match(/OS (\d+)_(\d+)_?(\d+)?/)[1], 10);

		if (iOS && iOSVersion >= 12) {
			return true;
		} else {
			return false;
		}
	};

	// if (isiOS12OrNewer()) {
	document.getElementById('ar_button').style.display = 'block';
	// }
}

document.addEventListener('DOMContentLoaded', function (event) {
	ar_supported();
});
