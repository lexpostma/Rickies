<?= back_button(billofrickies_url(false)), no_script_banner() ?>

<main>
	<p id="active_date">28 June 2020</p>
	<h1>The Bill of Rickies</h1>

<?php foreach ($rules_array as $type => $rules) {
	echo '<h2>The ' . ucfirst($type) . '</h2><ol>';

	foreach ($rules as $rule) {
		echo '<li class="rule" id="rule' .
			$rule['id'] .
			'" startdate="' .
			$rule['date_start'] .
			'" enddate="' .
			$rule['date_end'] .
			'" >' .
			$rule['rule'] .
			'</li>';
	}

	echo '</ol>';
} ?>

</main>

<div id="rule_slider">
	<!-- TODO: Define slider -->
	<label for="date">Keynote Rickies, March 2020</label>
	<input type="range" id="date" name="date" min="0" max="11">
</div>

