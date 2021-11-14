<?php
/* Function for searching and filtering predictions/picks  */

// Fixed search button in the top right corner of many pages, opens a modal search field
// Includes a search field that's always fixed, otherwise there's no search button needed on the page
function search_button()
{
	$output = pick_filter_element(false, true);
	$output .= '<button id="search_button" class="top_button clean" type="button" onclick="toggle_search()">';
	$output .= file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-search.svg');
	$output .= file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-close2.svg');
	$output .= '</button>';

	return $output;
}

/* The content of the search element

Parameters are:
	$user_input 		-> the input from the user, e.g. checkboxes checked, search query etc.
	$displayed_as_modal -> whether the search content in modally opened, or inline
	$categories 		-> optionally insert al the possible categories as array
*/
function pick_filter_element($user_input = false, $displayed_as_modal = false, $categories = [], $rickies_events = [])
{
	$output = '';
	if (empty($user_input['search'])) {
		$user_input['search']['string'] = false;
	}

	if ($displayed_as_modal) {
		$output .= '<div id="fixed_search" class="">';
	}

	$output .= '<form method="get" action="/#results" class="filters ';
	if (!$displayed_as_modal) {
		$output .= 'with_sheet';
	}
	$output .= '" id="pick_filter_form">';

	if ($displayed_as_modal) {
		$output .= search_field($user_input['search']['string']);
	} else {
		$output .= search_field($user_input['search']['string'], true);
		$output .= pick_filter_expandable_sheet($categories, $rickies_events, $user_input);
	}

	$output .= '	</form>';

	if ($displayed_as_modal) {
		$output .= '</div>';
	}

	return $output;
}

/* The search input field */
function search_field($search_string = false, $part_of_filters = false)
{
	$output = '
		<div id="search_field_combo" class="input_button_combo ';
	if ($part_of_filters) {
		$output .= 'in_summary';
	}
	$output .= '">
			<input id="search_input" class="clean" type="search" name="search" title="Search for predictions" placeholder="Search for predictions" ';
	if ($search_string) {
		$output .= ' value="' . $search_string . '" ';
	}
	$output .= '/>
			<button class="clean top_button" title="Search" form="pick_filter_form" type="submit">';
	$output .= file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-search.svg');
	$output .= '</button>
		</div>';

	return $output;
}

/* All the pick filters inside an expandable <details> sheet

Includes filters for
- Host
- Pick status (correct, wrong, unknown)
- Pick type (regular, risky, flexy)
- Event
- Metadata (reusable, buzzkiller, ahead of its time, half correct, adjudication)
- Categories via pick_category_filters() function

Parameters are:
	$categories	-> array of all categories available to be selected, to be forwarded to pick_category_filters() function
	$user_input -> array of selected filters by the user, separated into 'filter_other' and 'filter_categories'
*/
function pick_filter_expandable_sheet($categories, $rickies_events, $user_input = [])
{
	$output = '<details id="pick_filter_sheet" ';
	if (empty($user_input['filter_other'])) {
		$user_input['filter_other'] = [];
	}

	if (
		!empty($user_input['filter_other']) ||
		!empty($user_input['filter_categories']) ||
		!empty($user_input['display'])
	) {
		$output .= ' open';
	}

	$output .= '>
	<summary><div class="filter_sheet_toggle">';
	if (
		!empty($user_input['filter_other']) ||
		!empty($user_input['filter_categories']) ||
		!empty($user_input['display'])
	) {
		$output .=
			'<span class="closed">Show</span><span class="opened">Hide</span> <b>active</b> filters<span class="filter_icon">' .
			file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-filter-active.svg') .
			'</span>';
	} else {
		$output .=
			'<span class="closed">Show</span><span class="opened">Hide</span> filters<span class="filter_icon">' .
			file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-filter.svg') .
			'</span>';
	}
	$output .= '</div></summary>
	<div class="content">';

	// Filter for hosts
	$hosts = ['myke', 'federico', 'stephen'];
	$output .= '<fieldset class="hosts">';
	foreach ($hosts as $host) {
		$output .=
			'<div class="host"><input type="checkbox" name="host[]" value="' .
			$host .
			'" id="host_' .
			$host .
			'" class="" ';
		if (
			key_exists('host', $user_input['filter_other']) &&
			strpos($user_input['filter_other']['host'], ucfirst($host)) !== false
		) {
			$output .= 'checked';
		}
		$output .=
			'/><label for="host_' .
			$host .
			'" title="' .
			ucfirst($host) .
			'"><img src="/images/memoji-' .
			$host .
			'-default.png"><img src="/images/memoji-' .
			$host .
			'-disabled.png"><span>' .
			ucfirst($host) .
			'</span></label></div>';
	}
	$output .= '</fieldset>';

	// Filter for pick types
	$types = [
		'regular' => '🧠',
		'risky' => '⚠️',
		'flexy' => '💪',
	];
	$output .= '<fieldset class="list pick_types"><ul>';
	foreach ($types as $type => $emoji) {
		$output .=
			'<li class="filter_option"><input type="checkbox" name="pick_type[]" value="' .
			$type .
			'" id="pick_type_' .
			$type .
			'" class="clean" ';
		if (
			key_exists('pick_type', $user_input['filter_other']) &&
			strpos($user_input['filter_other']['pick_type'], ucfirst($type)) !== false
		) {
			$output .= 'checked';
		}
		$output .=
			'/><label for="pick_type_' .
			$type .
			'"><span class="emoji">' .
			$emoji .
			'</span>' .
			ucfirst($type) .
			'<span class="need_space--sm"> picks</span></label></li>';
	}
	$output .= '</ul></fieldset>';

	// Filter for pick states
	$output .= '
	<fieldset class="list pick_status">
		<ul>
			<li class="filter_option">
				<input type="checkbox" name="status[]" value="correct" id="status_correct" class="clean" ';
	if (
		key_exists('status', $user_input['filter_other']) &&
		strpos($user_input['filter_other']['status'], 'Correct') !== false
	) {
		$output .= 'checked';
	}
	$output .= '/>
				<label for="status_correct"><span class="emoji">🟢</span>Correct<span class="need_space--sm"> picks</span></label>
			</li>

			<li class="filter_option">
				<input type="checkbox" name="status[]" value="wrong" id="status_wrong" class="clean" ';
	if (
		key_exists('status', $user_input['filter_other']) &&
		strpos($user_input['filter_other']['status'], 'Wrong') !== false
	) {
		$output .= 'checked';
	}
	$output .= '/>
				<label for="status_wrong"><span class="emoji">🔴</span>Wrong<span class="need_space--sm"> picks</span></label>
			</li>

			<li class="filter_option">
				<input type="checkbox" name="status[]" value="unknown" id="status_unknown" class="clean" ';
	if (
		key_exists('status', $user_input['filter_other']) &&
		strpos($user_input['filter_other']['status'], '""') !== false
	) {
		$output .= 'checked';
	}
	$output .= '/>
				<label for="status_unknown"><span class="emoji">🟡</span>Unknown<span class="need_space--sm"> picks</span></label>
			</li>
		</ul>
	</fieldset>';

	// Filter for interesting stats and metadata
	$event_select = [
		'annual' => '📆&emsp14;&emsp14;Annual Rickies',
		'keynote' => '📽&emsp14;&emsp14;Keynote Rickies',
		'WWDC' => '💻&emsp14;&emsp14;WWDC Rickies',
		'ungraded' => '🟠&emsp14;&emsp14;Ungraded Rickies',
	];
	$output .= '
	<fieldset class="list pick_metadata">
		<ul>
			<li class="filter_option select">
				<select class="clean" name="rickies_event" onchange=" this.dataset.chosen = this.value; " ';
	if (key_exists('rickies_event', $user_input['filter_other'])) {
		$output .= 'data-chosen="set"';
	} else {
		$output .= 'data-chosen';
	}
	$output .= '>
					<option value>🏆&emsp14;&emsp14;All Rickies</option>
					<optgroup label="Only show picks from…">';
	foreach ($event_select as $value => $label) {
		$output .= '<option value="' . strtolower($value) . '" ';
		if (
			key_exists('rickies_event', $user_input['filter_other']) &&
			strpos($user_input['filter_other']['rickies_event'], $value) !== false
		) {
			$output .= 'selected';
		}
		$output .= '>' . $label . '</option>';
	}
	$output .= '</optgroup>
					<optgroup label="Or from specific Rickies…">';
	foreach ($rickies_events as $value => $label) {
		$output .= '<option value="' . strtolower($value) . '" ';
		if (
			key_exists('rickies_event', $user_input['filter_other']) &&
			strpos($user_input['filter_other']['rickies_event'], $value) !== false
		) {
			$output .= 'selected';
		}
		$output .= '>' . $label . '</option>';
	}
	$output .= '</optgroup>
				</select>
				<div class="select_icon"></div>
			</li>';

	$metadata = [
		'reusable' => [
			'label' => 'Eligible for reuse',
			'emoji' => '♻️',
		],
		'buzzkiller' => [
			'label' => 'Buzzkiller',
			'emoji' => '🐝',
		],
		'ahead_of_its_time' => [
			'label' => 'Ahead of its time',
			'emoji' => '🔮',
		],
		'adjudicated' => [
			'label' => 'Adjudicated',
			'emoji' => '🧑‍⚖️',
		],
		'half_points' => [
			'label' => 'Half correct',
			'emoji' => '➗',
		],
	];
	foreach ($metadata as $value => $visual) {
		$output .=
			'<li class="filter_option">
				<input type="checkbox" name="' .
			$value .
			'" id="' .
			$value .
			'" class="clean" ';
		if (key_exists($value, $user_input['filter_other'])) {
			$output .= 'checked';
		}
		$output .=
			'/>
				<label for="' .
			$value .
			'"><span class="emoji">' .
			$visual['emoji'] .
			'</span>' .
			$visual['label'] .
			'</label>
			</li>';
	}

	// Filter for changing view
	$pick_display_select = [
		'clean' => '🧹&emsp14;&emsp14;Just the picks',
		'categories' => '🏷&emsp14;&emsp14;Show categories',
		'age' => '🗓&emsp14;&emsp14;Show age of picks',
	];
	$output .= '
			<li class="filter_option select">
				<select class="clean" name="display" onchange=" this.dataset.chosen = this.value; " ';
	if (!empty($user_input['display'])) {
		$output .= 'data-chosen="set"';
	} else {
		$output .= 'data-chosen';
	}
	$output .= '>
					<option value>🗂&emsp14;&emsp14;All metadata</option>
					<optgroup label="Show picks and…">';
	foreach ($pick_display_select as $value => $label) {
		$output .= '<option value="' . $value . '" ';
		if ($user_input['display'] === $value) {
			$output .= 'selected';
		}
		$output .= '>' . $label . '</option>';
	}
	$output .= '</optgroup>
				</select>
				<div class="select_icon"></div>
			</li>';
	$output .= '</ul></fieldset>';

	// Add category filter, and button section, and closing the .content and <details>
	$output .=
		pick_category_filters($categories, $user_input['filter_categories']) .
		'
		<div class="button_section">
			<button id="search_button_plus" class="clean js_link" title="Search and filter" form="pick_filter_form" type="submit">Search picks' .
		file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-search.svg') .
		'</button>
			<button class="clean js_link" id="reset_button" type="button" onclick="reset_filter()">Reset filters</button>
		</div>
	</div>
</details>';

	return $output;
}

/* All the category checkboxes
Parameters are:
	$categories	-> array of all categories available to be selected
	$user_input -> array of categories selected by the user
*/

function pick_category_filters($categories, $user_input = false)
{
	$output = '<fieldset class="categories">';

	foreach ($categories as $groupL1 => $groupL1_data) {
		$output .=
			'
	<fieldset class="list">
		<ul>
			<li class="filter_option">
				<input type="checkbox" name="category[]" class="clean category" id="catL1-' .
			$groupL1_data['value'] .
			'"" value="' .
			$groupL1_data['value'] .
			'" ';
		if ($user_input && in_array($groupL1_data['value'], $user_input)) {
			$output .= ' checked ';
		}
		$output .=
			'/>
				<label for="catL1-' .
			$groupL1_data['value'] .
			'"><span class="emoji">' .
			$groupL1_data['emoji'] .
			'</span>' .
			$groupL1 .
			'</label>

				<ul>';

		foreach ($groupL1_data['categories'] as $groupL2 => $groupL2_data) {
			$output .=
				'
					<li class="filter_option">
						<input type="checkbox" name="category[]" class="clean category" id="catL2-' .
				$groupL2_data['value'] .
				'"" value="' .
				$groupL2_data['value'] .
				'" ';
			if ($user_input && in_array($groupL2_data['value'], $user_input)) {
				$output .= ' checked ';
			}
			$output .=
				'/>
						<label for="catL2-' .
				$groupL2_data['value'] .
				'">' .
				$groupL2 .
				'</label>';

			// IF:
			// A category is selected,
			// AND this category has another level of categories that it could be in,
			// BUT the group itself is not selected
			// -> Start collecting the possible checkboxes
			if (
				$user_input &&
				key_exists('categories', $groupL2_data) &&
				!in_array($groupL2_data['value'], $user_input)
			) {
				$groupL3_group_selected = false;

				$groupL3_boxes = '<ul>';
				foreach ($groupL2_data['categories'] as $groupL3 => $groupL3_data) {
					$groupL3_boxes .=
						'
							<li class="filter_option">
								<input type="checkbox" name="category[]" class="clean category" id="catL3-' .
						$groupL3_data['value'] .
						'"" value="' .
						$groupL3_data['value'] .
						'" ';
					if (in_array($groupL3_data['value'], $user_input)) {
						$groupL3_boxes .= ' checked ';
						$groupL3_group_selected = true;
					}
					$groupL3_boxes .=
						'/>
								<label for="catL3-' .
						$groupL3_data['value'] .
						'">' .
						$groupL3 .
						'</label>
							</li>';
				}
				$groupL3_boxes .= '</ul>';

				// If something in the group is selected, add the checkbox list to the output to be displayed
				if ($groupL3_group_selected) {
					$output .= $groupL3_boxes;
				}
			}
			$output .= '</li>';
		}

		$output .= '
				</ul>
			</li>
		</ul>
	</fieldset>';
	}

	$output .= '</fieldset>';
	return $output;
}
