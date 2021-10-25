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

function search_field($search_string = false, $fixed = false, $filters = '')
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
		$output .= search_filters($filters);
	}
	$output .= '	</form>';

	if ($fixed) {
		$output .= '</div>';
	}

	return $output;
}

function search_filters($filters = [])
{
	if ($filters == '') {
		$filters = [];
	}

	$output = '<details class="filter_sheet" ';

	if (!empty($filters)) {
		$output .= ' open';
	}

	$output .=
		'>
	<summary><span class="closed">Show filters<span class="filter_icon">' .
		file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-filter.svg') .
		'</span></span><span class="opened">Hide filters<span class="filter_icon">' .
		file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-filter-active.svg') .
		'</span></span></summary>';

	// Filter for hosts
	$output .= '
	<fieldset class="hosts">
		<div class="host">
			<input type="checkbox" name="host[]" value="myke" id="host_myke" class="" ';
	if (key_exists('host', $filters) && strpos($filters['host'], 'Myke') !== false) {
		$output .= 'checked';
	}
	$output .= '/>
			<label for="host_myke" title="Myke">
				<img src="/images/memoji-myke-default.png">
				<img src="/images/memoji-myke-disabled.png">
				<span>Myke</span>
			</label>
		</div>

		<div class="host">
			<input type="checkbox" name="host[]" value="federico" id="host_federico" class="" ';
	if (key_exists('host', $filters) && strpos($filters['host'], 'Federico') !== false) {
		$output .= 'checked';
	}
	$output .= '/>
			<label for="host_federico" title="Federico">
				<img src="/images/memoji-federico-default.png">
				<img src="/images/memoji-federico-disabled.png">
				<span>Federico</span>
			</label>
		</div>

		<div class="host">
			<input type="checkbox" name="host[]" value="stephen" id="host_stephen" class="" ';
	if (key_exists('host', $filters) && strpos($filters['host'], 'Stephen') !== false) {
		$output .= 'checked';
	}
	$output .= '/>
			<label for="host_stephen" title="Stephen">
				<img src="/images/memoji-stephen-default.png">
				<img src="/images/memoji-stephen-disabled.png">
				<span>Stephen</span>
			</label>
		</div>
	</fieldset>';

	// Filter for pick types
	$output .= '
	<div class="columns">
		<fieldset>
			<div class="filter_option select">
				<select class="clean" name="event" onchange=" this.dataset.chosen = this.value; " ';
	if (key_exists('event', $filters)) {
		$output .= 'data-chosen="set"';
	} else {
		$output .= 'data-chosen';
	}
	$output .= '>
					<option value>🏆 From all Rickies</option>
					<optgroup label="Filter by Rickies event type">
						<option value="annual" ';
	if (key_exists('event', $filters) && strpos($filters['event'], 'annual') !== false) {
		$output .= 'selected';
	}
	$output .= '>📆 From Annual Rickies</option>
						<option value="keynote" ';
	if (key_exists('event', $filters) && strpos($filters['event'], 'keynote') !== false) {
		$output .= 'selected';
	}
	$output .= '>📽 From Keynote Rickies</option>
						<option value="wwdc" ';
	if (key_exists('event', $filters) && strpos($filters['event'], 'WWDC') !== false) {
		$output .= 'selected';
	}
	$output .= '>💻 From WWDC Rickies</option>
						<option value="ungraded" ';
	if (key_exists('event', $filters) && strpos($filters['event'], 'Ungraded') !== false) {
		$output .= 'selected';
	}
	$output .= '>🟠 From ungraded Rickies</option>
					</optgroup>
				</select>
				<div class="select_icon"></div>
			</div>


			<div class="filter_option">
				<input type="checkbox" name="type[]" value="regular" id="type_regular" class="clean" ';
	if (key_exists('type', $filters) && strpos($filters['type'], 'Regular') !== false) {
		$output .= 'checked';
	}
	$output .= '/>
				<label for="type_regular"><span class="emoji">🧠</span>Regular picks</label>
			</div>

			<div class="filter_option">
				<input type="checkbox" name="type[]" value="risky" id="type_risky" class="clean" ';
	if (key_exists('type', $filters) && strpos($filters['type'], 'Risky') !== false) {
		$output .= 'checked';
	}
	$output .= '/>
				<label for="type_risky"><span class="emoji">⚠️</span>Risky picks</label>
			</div>

			<div class="filter_option">
				<input type="checkbox" name="type[]" value="flexy" id="type_flexy" class="clean" ';
	if (key_exists('type', $filters) && strpos($filters['type'], 'Flexy') !== false) {
		$output .= 'checked';
	}
	$output .= '/>
				<label for="type_flexy"><span class="emoji">💪</span>Flexy picks</label>
			</div>
		</fieldset>';

	// Filter for interesting stats
	$output .= '
		<fieldset>

			<div class="filter_option">
				<input type="checkbox" name="reuse" id="reuse" class="clean" ';
	if (key_exists('reuse', $filters)) {
		$output .= 'checked';
	}
	$output .= '/>
				<label for="reuse"><span class="emoji">♻️</span>Eligible to reuse</label>
			</div>

			<div class="filter_option">
				<input type="checkbox" name="buzzkill" id="buzzkill" class="clean" ';
	if (key_exists('buzzkill', $filters)) {
		$output .= 'checked';
	}
	$output .= '/>
				<label for="buzzkill"><span class="emoji">🐝</span>Buzzkill</label>
			</div>

			<div class="filter_option">
				<input type="checkbox" name="eventually" id="eventually" class="clean" ';
	if (key_exists('eventually', $filters)) {
		$output .= 'checked';
	}
	$output .= '/>
				<label for="eventually"><span class="emoji">🔮</span>Ahead of his Time</label>
			</div>

			<div class="filter_option">
				<input type="checkbox" name="adjudicated" id="adjudicated" class="clean" ';
	if (key_exists('adjudicated', $filters)) {
		$output .= 'checked';
	}
	$output .= '/>
				<label for="adjudicated"><span class="emoji">🧑‍⚖️</span>Adjudicated</label>
			</div>';

	$output .= '
		</fieldset>
	</div>';

	$output .=
		'
		<button id="search_button_plus" class="clean js_link" title="Search and filter" form="search_form" type="submit">Search picks' .
		file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-back.svg') .
		'</button>
		<button class="clean js_link" id="reset_button" type="button" onclick="reset_filter()" ';
	if (empty($filters)) {
		$output .= 'disabled';
	}
	$output .= '>Reset filters</button>';

	$output .= '</details>';

	$output .= '<script>' . file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts/filter.js') . '</script>';

	return $output;
}
