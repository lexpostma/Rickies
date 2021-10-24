<?php

function search_button()
{
	$output = search_field(false, true);
	$output .= '<button id="search_button" class="top_button clean" type="button" onclick="toggle_search()">';
	$output .= file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-search.svg');
	$output .= file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-close2.svg');
	$output .= '</button>';

	// NOTE: Remember to add the search.js script to the footer separately
	return $output;
}

function search_field($search_string = false, $fixed = false)
{
	$output = '';
	if ($fixed) {
		$output .= '<div id="fixed_search" class="">';
	}

	$output .= '
	<form method="get" action="/" class="filters" id="search_form">
		<div id="inline_search">
			<input id="search_input" class="clean" type="search" name="search" title="Search for predictions" placeholder="Search for predictions" ';
	if ($search_string) {
		$output .= ' value="' . $search_string . '" ';
	}
	$output .= '/>
			<button class="clean top_button" title="Search" form="search_form" type="submit">';
	$output .= file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-search.svg');
	$output .= '</button>
		</div>';
	if (!$fixed) {
		$output .= search_filters();
	}
	$output .= '	</form>';

	if ($fixed) {
		$output .= '</div>';
	}

	return $output;
}

function search_filters()
{
	$output = '<details open>
	<summary>FILTERS</summary>';

	$output .= '
	<fieldset>
		<legend>Hosts</legend>
		<input type="checkbox" name="host[]" value="myke" id="host_myke" />
		<label for="host_myke">Myke</label>

		<input type="checkbox" name="host[]" value="stephen" id="host_stephen" />
		<label for="host_stephen">Stephen</label>

		<input type="checkbox" name="host[]" value="federico" id="host_federico" />
		<label for="host_federico">Federico</label>
	</fieldset>';

	$output .= '
<fieldset>
	<legend>Pick Types</legend>
	<input type="checkbox" name="type[]" value="regular" id="type_regular" />
	<label for="type_regular">🧠 Regular</label>

	<input type="checkbox" name="type[]" value="risky" id="type_risky" />
	<label for="type_risky">⚠️ Risky</label>

	<input type="checkbox" name="type[]" value="flexy" id="type_flexy" />
	<label for="type_flexy">💪 Flexy</label>
</fieldset>';

	$output .= '
	<fieldset>
		<legend>Options</legend>
		<input type="checkbox" name="reuse" id="reuse" />
		<label for="reuse">♻️ Eligible to reuse</label>
		<br />
		<input type="checkbox" name="buzzkill" id="buzzkill" />
		<label for="buzzkill">🐝 Buzzkill</label>
		<br />
		<input type="checkbox" name="eventually" id="eventually" />
		<label for="eventually">🔮 Ahead of his Time</label>
	</fieldset>';

	$output .= '</details>';

	return $output;
}
