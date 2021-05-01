<?= back_button(billofrickies_url(false)), no_script_banner() ?>

<main>
	<!-- TODO: Set starting date -->
	<p id="active_date"><?= $current_selection['date_string'] ?></p>
	<h1>The Bill of Rickies</h1>

<?php foreach ($rules__array as $type => $rules) {
	echo '<h2 class="rule_type">The ' . ucfirst($type) . '</h2><ol class="rules">';

	foreach ($rules as $rule) {
		echo '<li class="rule ';

		// This is the same rule that's also in the JS
		if ($rule['date_start'] <= $current_selection['date'] && $rule['date_end'] >= $current_selection['date']) {
		} else {
			echo 'hidden gone';
		}
		echo '" id="rule' . $rule['id'] . '" ';
		echo ' data-start-date="' . $rule['date_start'] . '" ';
		echo ' data-end-date="' . $rule['date_end'] . '" ';
		echo '>' . $rule['rule'] . '</li>';
	}

	echo '</ol>';
} ?>

</main>
<aside class="slider">
	<div id="rule_slider">
		<label id="date_label" for="date_slider"><?= $current_selection['name'] ?></label>
		<input
			id="date_slider"
			type="range"
			name="date_slider"
			min="0"
			max="<?= $event_slider_steps ?>"
			value="<?= $current_selection['index'] ?>"
			step="1"
			list="date_values"
			oninput="update_rules(this.value)"
			onchange="update_rules(this.value)">
		<datalist id="date_values">
<?php for ($i = 0; $i <= $event_slider_steps; $i++) {
	echo '<option value="' . $i . '"></option>';
} ?>
		</datalist>
	</div>
</aside>

<script><?php
echo $event_slider_js_vars;
include 'scripts/rules_slider.js';
?></script>