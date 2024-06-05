<?php

if (isset($triple_j)) { ?>
<style>
	:root {
		--document-background-color: #9D3489;
	}
	@media (prefers-color-scheme: dark) {
		:root {
			--document-background-color: var(--relay-blue);
		}
	}
</style>
<?php }

echo back_button(), no_script_banner();
if (isset($error)) {
	echo $error;
}
echo music_button();
if (!isset($error)) {
	echo share_button();
}
?>
<main id="the_document" class="<?php
if (isset($parchment)) {
	echo ' parchment ';
}
if (isset($triple_j)) {
	echo ' charter ';
}
?>">
	<p class="document_date">
		<span id="document_date"><?= $current_selection['date_string'] ?></span>
		<?= copy_url_button('') ?>
	</p>
	<h1 id="document_title"><?= $head_custom['title'] ?></h1>

<?php
foreach ($rules__array as $type => $rules) {
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
			echo '>' . $rule['rule'] . copy_url_button('#rule' . $rule['id']) . '</div>';
		}
	} else {
		$i = 0;
		$len = count($rules);

		$intro_output = $outro_output = '';
		$rules_output = '<ol class="rules">';
		foreach ($rules as $rule) {
			switch ($rule['section']) {
				case 'Rules':
					$temp_rule_output = '<li';
					break;
				case 'Intro':
				case 'Outro':
					$temp_rule_output = '<div';
					break;
			}

			$temp_rule_output .= ' class="rule ';

			// This is the same rule that's also in the JS
			if ($rule['date_start'] <= $current_selection['date'] && $rule['date_end'] >= $current_selection['date']) {
			} else {
				$temp_rule_output .= 'hidden gone';
				$i++;
			}
			$temp_rule_output .=
				'" id="rule' .
				$rule['id'] .
				'"
				data-start-date="' .
				$rule['date_start'] .
				'"
				data-end-date="' .
				$rule['date_end'] .
				'"
				>' .
				$rule['rule'] .
				copy_url_button('#rule' . $rule['id']);

			switch ($rule['section']) {
				case 'Rules':
					$temp_rule_output .= '</li>';
					$rules_output .= $temp_rule_output;
					break;
				case 'Intro':
					$temp_rule_output .= '</div>';
					$intro_output .= $temp_rule_output;
					break;
				case 'Outro':
					$temp_rule_output .= '</div>';
					$outro_output .= $temp_rule_output;
					break;
			}
			unset($temp_rule_output);
		}

		$rules_output .= '</ol>';
		$output_h2 = '<h2 id="' . strtolower(explode(' ', $type)[1]) . '_title" class="rule_type ';
		if ($i == $len) {
			// All rules in <ol> are hidden, so also hide <h2>
			$output_h2 .= 'hidden gone';
		}
		$output_h2 .= '">' . $type . '</h2>';

		echo $output_h2 . $intro_output . $rules_output . $outro_output;
		unset($output, $output_h2);
	}
}
if (!isset($triple_j)) {
	$signatures = [
		[
			'img' => 'stephen',
			'name' => 'Stephen Hackett',
			'title' => 'Stephen’s signature',
			'style' => 'width: 168px; margin-bottom: -5px; margin-left: -6px;',
		],
		[
			'img' => 'federico',
			'name' => 'Federico Viticci',
			'title' => 'Federico’s signature',
			'style' => 'width: 170px; margin-left: -15px; margin-bottom: -14px; transform: rotate(8deg);',
		],
		[
			'img' => 'myke',
			'name' => 'Myke Hurley',
			'title' => 'Myke’s signature',
			'style' => 'width: 130px; margin-bottom: -24px; margin-left: -20px;',
		],
	];
} else {
	$signatures = [
		[
			'img' => 'james',
			'name' => 'James Thomson',
			'title' => 'James’s signature',
			'style' => 'width: 142px; margin-bottom: -15px; margin-left: -18px; transform: rotate(-6deg);',
		],
		[
			'img' => 'john',
			'name' => 'John Voorhees',
			'title' => 'John’s signature',
			'style' => 'width: 160px; margin-bottom: -1px; margin-left: -7px;',
		],
		[
			'img' => 'jason',
			'name' => 'Jason Snell',
			'title' => 'Jason’s signature',
			'style' => 'width: 170px; margin-bottom: -27px; margin-left: -23px;',
		],
	];
}
shuffle($signatures);
?>
	<div class="document_footer">
		<div class="signatures">
<?php foreach ($signatures as $sign) {
	echo '
<div class="signature">
	<img src="/images/signatures/' .
		$sign['img'] .
		'.png" alt="' .
		$sign['title'] .
		'" style="' .
		$sign['style'] .
		'"/>
	<span>' .
		$sign['name'] .
		'</span>
</div>';
} ?>
		</div>
		<div class="seal">
			<img id="ticci_seal"  class="seal" src="/images/viticci-seal-of-quality.png" alt="Viticci Seal of Quality"/>
			<?php if (!isset($triple_j)) { ?>
			<img id="wax_seal" class="seal" src="/images/connected-seal.png" alt="Connected classic wax seal"/>
			<?php } else { ?>
			<img id="wax_seal" class="seal" src="/images/3j-seal.png" alt="Connected classic wax seal"/>
			<?php } ?>
		</div>


	</div>
</main>
<?php
if (!isset($triple_j)) { ?>

<p class="bill_footer">This is a living document. The One True Copy of <span id="disclaimer_title"><?= $head_custom[
	'title'
] ?></span> is in the Connected Notion&nbsp;document.</p>
<p class="bill_footer">Looking for <a href="/charter">The Pickies Charter</a>?</p>

<?php } else { ?>
<p class="bill_footer">Looking for the official <a href="/billof">Bill of Rickies</a>?</p>
<?php }

echo close_button();
?>
<aside class="slider">
	<div id="rule_slider">
		<label id="slider_label_container" for="date_slider">
			<span id="slider_hint">Slide to see the full history</span>
			<span id="slider_label"><?= $current_selection['name'] ?></span>
		</label>
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
<audio id="theme_music" hidden src="/audio/native-land-dream-cave.mp3"></audio>
<script><?php
echo $event_slider_js_vars;
echo 'const rickies_start = ' .
	$rickies_start .
	'; const flexies_start = ' .
	$flexies_start .
	'; const bill_start = ' .
	$bill_start .
	'; const triple_j = ';
if (!isset($triple_j)) {
	echo 'false';
} else {
	echo 'true';
}
echo ';

';
include 'scripts/interactive_rules.js';
echo 'document.addEventListener(\'DOMContentLoaded\', function (event) { update_rules(' .
	$current_selection['index'] .
	');});';
?></script>
