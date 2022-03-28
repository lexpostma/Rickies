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
	} else {
		// Different chairmen total, probably 2 total, on different hosts > set all to 0 and increase clicked by 1
		Array.from(magtricky_chairmen).forEach(function (el) {
			el.setAttribute('data-chairman', 0);
		});
		button.setAttribute('data-chairman', current_state + 1);
	}
}
