document.addEventListener('DOMContentLoaded', function (event) {
	if (typeof rickies_alt !== 'undefined') {
		if (document.getElementById('menu_rickies')) {
			document.getElementById('menu_rickies').innerText = rickies_alt;
			document.getElementById('rickies').getElementsByClassName('section_title')[0].innerText = rickies_alt;
		}

		Array.from(document.querySelectorAll('.mini_stats .mini_stats--list:first-of-type')).forEach(function (el) {
			el.querySelector('h4').innerText = '🎯 ' + rickies_alt;
		});

		Array.from(document.querySelectorAll('.list_item_labels p.ranking .nowrap')).forEach(function (el) {
			el.innerHTML = el.innerHTML.replace('Rickies winner', 'Winner');
			el.innerHTML = el.innerHTML.replace('Rickies', '');
		});
	}

	if (typeof flexies_alt !== 'undefined') {
		if (document.getElementById('menu_flexies')) {
			document.getElementById('menu_flexies').innerText = flexies_alt;
			document.getElementById('flexies').getElementsByClassName('section_title')[0].innerText = flexies_alt;
		}

		Array.from(document.querySelectorAll('.avatar_leaderboard span.string')).forEach(function (el) {
			el.innerHTML = el.innerHTML.replace('Flexing:', 'Bragging:');
		});

		Array.from(document.querySelectorAll('.list_item_labels p.ranking .nowrap')).forEach(function (el) {
			el.innerHTML = el.innerHTML.replace('Flexies winner', 'Most bragging rights');
			el.innerHTML = el.innerHTML.replace('Flexies loser', 'Least bragging rights');
		});

		Array.from(document.querySelectorAll('.mini_stats .mini_stats--list:last-of-type')).forEach(function (el) {
			el.querySelector('h4').innerText = '💪 ' + flexies_alt;
			el.querySelector('p').innerHTML = el.querySelector('p').innerHTML.replace('flexing', 'bragging');
		});
	}
});
