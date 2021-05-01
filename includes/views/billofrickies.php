<?= back_button(billofrickies_url(false)), no_script_banner() ?>

<main>
	<!-- TODO: Set starting date -->
	<p id="active_date">28 June 2020</p>
	<h1>The Bill of Rickies</h1>

<?php foreach ($rules__array as $type => $rules) {
	echo '<h2>The ' . ucfirst($type) . '</h2><ol>';

	foreach ($rules as $rule) {
		echo '<li class="rule ';

		// Add classes to each event this rule applies to
		foreach ($rule['applies_to'] as $event) {
			echo $event['url'] . ' ';
		}
		echo '" id="rule' . $rule['id'] . '" >' . $rule['rule'] . '</li>';
	}

	echo '</ol>';
} ?>

</main>
<!-- TODO: Style slider -->
<div id="rule_slider">
	<!-- TODO: Set starting event name and add link -->
	<label id="date_label" for="date_slider">Rickies event name</label>
	<input
		id="date_slider"
		type="range"
		name="date_slider"
		min="0"
		max="<?= $event_slider_steps ?>"
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

<script><?php
echo $event_slider_js_data;
include 'scripts/rules_slider.js';
?></script>