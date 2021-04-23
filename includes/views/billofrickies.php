<a id="back_button" href="<?= billofrickies_url(
	false
) ?>"><? include("../public_html/images/back-button.svg"); ?></a>

<main>
	<p id="active_date">28 June 2020</p>
	<h1>The Bill of Rickies</h1>

	<h2>The Rickies</h2>
	<ol>
<?php foreach ($rules_array["rickies"] as &$rule) {
	echo "<li id='rule" .
		$rule["id"] .
		"' startdate='" .
		$rule["date_start"] .
		"' enddate='" .
		$rule["date_end"] .
		"' >" .
		$rule["rule"] .
		"</li>";
} ?>
	</ol>
	<h2>The Flexies</h2>
	<ol>
<?php foreach ($rules_array["flexies"] as &$rule) {
	echo "<li id='rule" .
		$rule["id"] .
		"' startdate='" .
		$rule["date_start"] .
		"' enddate='" .
		$rule["date_end"] .
		"' >" .
		$rule["rule"] .
		"</li>";
} ?>
	</ol>
</main>

<!-- <div id="rule_slider">
	<label for="date">Keynote Rickies, March 2020</label>
	<input type="range" id="date" name="date" min="0" max="11">
</div>
 -->
