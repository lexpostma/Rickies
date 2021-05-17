<?php
echo back_button(), no_script_banner();
if (isset($error)) {
	echo $error;
} else {
	echo share_button();
}
?>

<main id="the_document" class="scroll">
	<p id="document_date"><?= $current_selection['date_string'] ?></p>
	<h1 id="document_title">The Bill of Rickies</h1>

<?php foreach ($rules__array as $type => $rules) {
	if ($type == 'Intro' || $type == 'Outro') {
		foreach ($rules as $rule) {
			echo '<div class="rule ';

			// This is the same rule that's also in the JS
			if ($rule['date_start'] <= $current_selection['date'] && $rule['date_end'] >= $current_selection['date']) {
			} else {
				echo 'hidden gone';
			}
			echo '" id="rule' . $rule['id'] . '" ';
			echo ' data-start-date="' . $rule['date_start'] . '" ';
			echo ' data-end-date="' . $rule['date_end'] . '" ';
			echo '>' . $rule['rule'] . '</div>';
		}
	} else {
		echo '<h2 id="' .
			strtolower(explode(' ', $type)[1]) .
			'_title"class="rule_type">' .
			$type .
			'</h2><ol class="rules">';

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
	}
} ?>
	<div class="document_footer">
		<div class="signatures">
			<img src="/images/signature-stephen.png" alt="Stephen Hackett signature"/>
			<img src="/images/signature-federico.png" alt="Federico Viticci signature"/>
			<img src="/images/signature-myke.png" alt="Myke Hurley signature"/>
		</div>
		<div class="seal">
			<img id="ticci_seal"  class="seal" src="/images/viticci-seal-of-quality.png" alt="Viticci Seal of Quality"/>
			<img id="scroll_seal" class="seal" src="/images/connected-seal.png" alt="Connected seal"/>
		</div>


	</div>
</main>
<aside class="slider">
	<div id="rule_slider">
		<label id="slider_label" for="date_slider"><?= $current_selection['name'] ?></label>
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
			onclick="update_rules(this.value)"
			onchange="update_rules(this.value); slide_event()">
		<datalist id="date_values">
<?php for ($i = 0; $i <= $event_slider_steps; $i++) {
	echo '<option value="' . $i . '"></option>';
} ?>
		</datalist>
	</div>
</aside>

<script><?php
echo $event_slider_js_vars;
echo 'var rickies_start = ' .
	$rickies_start .
	'; var flexies_start = ' .
	$flexies_start .
	'; var bill_start = ' .
	$bill_start .
	';';

include 'scripts/rules_slider.js';
echo 'document.addEventListener(\'DOMContentLoaded\', function (event) { update_rules(' .
	$current_selection['index'] .
	');});';
?></script>