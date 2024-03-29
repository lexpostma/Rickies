// Script to interact with inline fixed fixed_search
const fixed_search = document.getElementById('fixed_search'),
	search_button = document.getElementById('search_button'),
	search_input = document.getElementById('search_input'),
	custom_share_sheet = document.getElementById('custom_share_sheet'),
	share_button = document.getElementById('share_button'),
	share_input = document.getElementById('share_input');

function toggle_search() {
	if (fixed_search.classList.contains('open')) {
		close_search();
	} else {
		open_search();
	}
}

function open_search() {
	if (custom_share_sheet) {
		close_custom_share();
		share_button.style.zIndex = 19;
	}
	fixed_search.classList.add('open');
	search_button.classList.add('open');
	search_input.focus();
	document.body.style.overflowY = 'hidden';
	document.body.style.height = 'calc(100% + env(safe-area-inset-top)';
	document.getElementsByTagName('html')[0].style.height = 'calc(100% + env(safe-area-inset-top)';
}
function close_search() {
	fixed_search.classList.remove('open');
	search_button.classList.remove('open');
	search_input.blur();
	document.body.style.overflowY = '';
	document.body.style.height = '';
	document.getElementsByTagName('html')[0].style.height = '';
	if (custom_share_sheet) {
		share_button.style.zIndex = 21;
	}
}

function open_custom_share() {
	if (fixed_search) {
		close_search();
		search_button.style.zIndex = 19;
	}
	custom_share_sheet.classList.add('open');
	share_button.classList.add('open');
	document.body.style.overflowY = 'hidden';
	document.body.style.height = 'calc(100% + env(safe-area-inset-top)';
	document.getElementsByTagName('html')[0].style.height = 'calc(100% + env(safe-area-inset-top)';

	copyTextToClipboard();
}
function close_custom_share() {
	custom_share_sheet.classList.remove('open');
	share_button.classList.remove('open');
	document.body.style.overflowY = '';
	document.body.style.height = '';
	document.getElementsByTagName('html')[0].style.height = '';
	if (fixed_search) {
		search_button.style.zIndex = 21;
	}
}

function open_share_sheet() {
	if (navigator.share) {
		// Native share sheet is supported
		navigator
			.share({
				title: document.getElementsByTagName('title')[0].innerHTML,
				url: window.location.href,
			})
			.then(() => {
				// console.log('Thanks for sharing!');
			})
			.catch(console.error);
	} else {
		// Native share sheet is not supported,
		// fall back to custom sheet with URL copy

		// console.log('No sharing support...');
		if (custom_share_sheet.classList.contains('open')) {
			close_custom_share();
		} else {
			open_custom_share();
		}
	}
}

// Functions to copy text to the clipboard

// Share buttons on each rule and bill version, to put a direct link in the clipboard
function copy_direct_url_to_clipboard(text, url = true) {
	if (url) {
		text = window.location.href.substr(0, window.location.href.indexOf('#')) + text;
	}
	navigator.clipboard.writeText(text);
}

// Below is used as fallback for when native share sheet is not supported
// Via https://stackoverflow.com/a/30810322
function fallbackCopyTextToClipboard(text) {
	var textArea = document.createElement('textarea');
	textArea.value = text;

	// Avoid scrolling to bottom
	textArea.style.top = '0';
	textArea.style.left = '0';
	textArea.style.position = 'fixed';

	document.body.appendChild(textArea);
	textArea.focus();
	textArea.select();

	try {
		var successful = document.execCommand('copy');
		var msg = successful ? 'successful' : 'unsuccessful';
		console.log('Fallback: Copying text command was ' + msg);
		if (msg == 'successful') {
			copy_successfull();
		}
	} catch (err) {
		console.error('Fallback: Oops, unable to copy', err);
	}

	document.body.removeChild(textArea);
}

function copyTextToClipboard(text) {
	var text = share_input.value;

	if (!navigator.clipboard) {
		fallbackCopyTextToClipboard(text);
		return;
	}
	navigator.clipboard.writeText(text).then(
		function () {
			// console.log('Async: Copying to clipboard was successful!');
			copy_successfull();
		},
		function (err) {
			console.error('Async: Could not copy text: ', err);
		}
	);
}

function copy_successfull() {
	var delayInMilliseconds = 2000;

	custom_share_sheet.classList.add('success');

	setTimeout(function () {
		custom_share_sheet.classList.remove('success');
	}, delayInMilliseconds);
}

// Click outside the search/share box, but not the search/share box itself, to close the modal
// Via https://stackoverflow.com/a/41178624
if (document.getElementById('share_sheet_form') && custom_share_sheet) {
	custom_share_sheet.onclick = function () {
		close_custom_share();
		// alert('You clicked on parent');
	};
	document.getElementById('share_sheet_form').onclick = function () {
		event.stopPropagation();
		// alert('You clicked on child');
	};
}
if (document.getElementById('pick_filter_form') && fixed_search) {
	fixed_search.onclick = function () {
		close_search();
		// alert('You clicked on parent');
	};

	document.getElementById('pick_filter_form').onclick = function () {
		event.stopPropagation();
		// alert('You clicked on child');
	};
}

// Press ESC to close the search/share box
// Via https://stackoverflow.com/a/3369743
document.onkeydown = function (evt) {
	evt = evt || window.event;
	var isEscape = false;
	if ('key' in evt) {
		isEscape = evt.key === 'Escape' || evt.key === 'Esc';
	} else {
		isEscape = evt.keyCode === 27;
	}
	if (isEscape) {
		close_search();
		close_custom_share();
	}
};

// Enable expandable navigation bar with extra menu items
const extra_items = document.getElementById('nav_content--extra-items');
function toggle_extra_items(el) {
	if (extra_items.classList.contains('hidden')) {
		extra_items.classList.remove('hidden');
		el.classList.add('opened');
	} else {
		extra_items.classList.add('hidden');
		el.classList.remove('opened');
	}
}
