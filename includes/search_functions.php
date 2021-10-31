<?php

function search_button()
{
	$output = search_content(false, true);
	$output .= '<button id="search_button" class="top_button clean" type="button" onclick="toggle_search()">';
	$output .= file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-search.svg');
	$output .= file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-close2.svg');
	$output .= '</button>';

	// NOTE: Remember to add the search.js script to the footer separately
	return $output;
}

function search_content($search_string = false, $fixed = false, $filters = [], $categories = [], $cat_selected = false)
{
	$output = '';

	if ($fixed) {
		$output .= '<div id="fixed_search" class="">';
	}

	$output .= '<form method="get" action="/" class="filters" id="search_form">';

	if ($fixed) {
		$output .= search_field($search_string);
	} else {
		$output .= search_field($search_string, true);
		$output .= search_filters($filters, $categories, $cat_selected);
	}

	$output .= '	</form>';

	if ($fixed) {
		$output .= '</div>';
	}

	return $output;
}

function search_field($search_string = false, $filters = false)
{
	$output = '
		<div id="inline_search" class="';
	if ($filters) {
		$output .= 'in_summary';
	}
	$output .= '">
			<input id="search_input" class="clean" type="search" name="search" title="Search for predictions" placeholder="Search for predictions" ';
	if ($search_string) {
		$output .= ' value="' . $search_string . '" ';
	}
	$output .= '/>
			<button class="clean top_button" title="Search" form="search_form" type="submit">';
	$output .= file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-search.svg');
	$output .= '</button>
		</div>';

	return $output;
}

function search_filters($filters = [], $categories, $cat_selected = false)
{
	if ($filters == '') {
		$filters = [];
	}

	$output = '<details id="filter_details" ';

	if (!empty($filters) || $cat_selected) {
		$output .= ' open';
	}

	$output .=
		'>
	<summary><span class="closed">Show filters<span class="filter_icon">' .
		file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-filter.svg') .
		'</span></span><span class="opened">Hide filters<span class="filter_icon">' .
		file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-filter-active.svg') .
		'</span></span></summary>
	<div class="filter_content content">';

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
	<fieldset class="list pick_types">
		<ul>
			<li class="filter_option">
				<input type="checkbox" name="type[]" value="regular" id="type_regular" class="clean" ';
	if (key_exists('type', $filters) && strpos($filters['type'], 'Regular') !== false) {
		$output .= 'checked';
	}
	$output .= '/>
				<label for="type_regular"><span class="emoji">🧠</span>Regular<span class="need_space--sm"> picks</span></label>
			</li>

			<li class="filter_option">
				<input type="checkbox" name="type[]" value="risky" id="type_risky" class="clean" ';
	if (key_exists('type', $filters) && strpos($filters['type'], 'Risky') !== false) {
		$output .= 'checked';
	}
	$output .= '/>
				<label for="type_risky"><span class="emoji">⚠️</span>Risky<span class="need_space--sm"> picks</span></label>
			</li>

			<li class="filter_option">
				<input type="checkbox" name="type[]" value="flexy" id="type_flexy" class="clean" ';
	if (key_exists('type', $filters) && strpos($filters['type'], 'Flexy') !== false) {
		$output .= 'checked';
	}
	$output .= '/>
				<label for="type_flexy"><span class="emoji">💪</span>Flexy<span class="need_space--sm"> picks</span></label>
			</li>
		</ul>
	</fieldset>';

	// Filter for pick states
	$output .= '
	<fieldset class="list pick_status">
		<ul>
			<li class="filter_option">
				<input type="checkbox" name="status[]" value="correct" id="status_correct" class="clean" ';
	if (key_exists('status', $filters) && strpos($filters['status'], 'Correct') !== false) {
		$output .= 'checked';
	}
	$output .= '/>
				<label for="status_correct"><span class="emoji">🟢</span>Correct<span class="need_space--sm"> picks</span></label>
			</li>

			<li class="filter_option">
				<input type="checkbox" name="status[]" value="wrong" id="status_wrong" class="clean" ';
	if (key_exists('status', $filters) && strpos($filters['status'], 'Wrong') !== false) {
		$output .= 'checked';
	}
	$output .= '/>
				<label for="status_wrong"><span class="emoji">🔴</span>Wrong<span class="need_space--sm"> picks</span></label>
			</li>

			<li class="filter_option">
				<input type="checkbox" name="status[]" value="unknown" id="status_unknown" class="clean" ';
	if (key_exists('status', $filters) && strpos($filters['status'], '""') !== false) {
		$output .= 'checked';
	}
	$output .= '/>
				<label for="status_unknown"><span class="emoji">🟡</span>Unknown<span class="need_space--sm"> picks</span></label>
			</li>


		</ul>
	</fieldset>';

	// TODO: Enable changing view filters
	// Filter for changing view
	// 	$output .= '
	// 	<fieldset class="list">
	// 		<ul>
	//
	// 			<li class="filter_option"><b>Change view</b></li>
	//
	// 			<li class="filter_option">
	// 				<input type="checkbox" name="view[]" value="categories" id="view_cat" class="clean" ';
	// 	if (key_exists('view', $filters) && strpos($filters['view'], 'categories') !== false) {
	// 		$output .= 'checked';
	// 	}
	// 	$output .= '/>
	// 				<label for="view_cat"><span class="emoji">🏷</span>Show categories</label>
	// 			</li>
	//
	// 			<li class="filter_option">
	// 				<input type="checkbox" name="view[]" value="age" id="view_age" class="clean" ';
	// 	if (key_exists('view', $filters) && strpos($filters['view'], 'age') !== false) {
	// 		$output .= 'checked';
	// 	}
	// 	$output .= '/>
	// 				<label for="view_age"><span class="emoji">🗓</span>Show pick age</label>
	// 			</li>
	// 		</ul>
	// 	</fieldset>';

	// Filter for interesting stats
	$output .= '
	<fieldset class="list pick_metadata">
		<ul>


			<li class="filter_option select">
				<select class="clean" name="event" onchange=" this.dataset.chosen = this.value; " ';
	if (key_exists('event', $filters)) {
		$output .= 'data-chosen="set"';
	} else {
		$output .= 'data-chosen';
	}
	$output .= '>
					<option value>🏆 All Rickies</option>
					<optgroup label="Only show picks from…">
						<option value="annual" ';
	if (key_exists('event', $filters) && strpos($filters['event'], 'annual') !== false) {
		$output .= 'selected';
	}
	$output .= '>📆 Annual Rickies</option>
						<option value="keynote" ';
	if (key_exists('event', $filters) && strpos($filters['event'], 'keynote') !== false) {
		$output .= 'selected';
	}
	$output .= '>📽 Keynote Rickies</option>
						<option value="wwdc" ';
	if (key_exists('event', $filters) && strpos($filters['event'], 'WWDC') !== false) {
		$output .= 'selected';
	}
	$output .= '>💻 WWDC Rickies</option>
						<option value="ungraded" ';
	if (key_exists('event', $filters) && strpos($filters['event'], 'Ungraded') !== false) {
		$output .= 'selected';
	}
	$output .= '>🟠 Ungraded Rickies</option>
					</optgroup>
				</select>
				<div class="select_icon"></div>
			</li>

			<li class="filter_option">
				<input type="checkbox" name="reuse" id="reuse" class="clean" ';
	if (key_exists('reuse', $filters)) {
		$output .= 'checked';
	}
	$output .= '/>
				<label for="reuse"><span class="emoji">♻️</span>Eligible for reuse</label>
			</li>

			<li class="filter_option">
				<input type="checkbox" name="buzzkill" id="buzzkill" class="clean" ';
	if (key_exists('buzzkill', $filters)) {
		$output .= 'checked';
	}
	$output .= '/>
				<label for="buzzkill"><span class="emoji">🐝</span>Buzzkill</label>
			</li>

			<li class="filter_option">
				<input type="checkbox" name="eventually" id="eventually" class="clean" ';
	if (key_exists('eventually', $filters)) {
		$output .= 'checked';
	}
	$output .= '/>
				<label for="eventually"><span class="emoji">🔮</span>Ahead of its time</label>
			</li>

			<li class="filter_option">
				<input type="checkbox" name="adjudicated" id="adjudicated" class="clean" ';
	if (key_exists('adjudicated', $filters)) {
		$output .= 'checked';
	}
	$output .= '/>
				<label for="adjudicated"><span class="emoji">🧑‍⚖️</span>Adjudicated</label>
			</li>

			<li class="filter_option">
				<input type="checkbox" name="half_points" id="half_points" class="clean" ';
	if (key_exists('half_points', $filters)) {
		$output .= 'checked';
	}
	$output .= '/>
				<label for="half_points"><span class="emoji">➗</span>Half correct</label>
			</li>
		</ul>
	</fieldset>';

	$output .=
		category_filters($categories, $cat_selected) .
		'
	<div class="button_section">
		<button id="search_button_plus" class="clean js_link" title="Search and filter" form="search_form" type="submit">Search picks' .
		file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-search.svg') .
		'</button>
		<button class="clean js_link" id="reset_button" type="button" onclick="reset_filter()" ';
	if (empty($filters)) {
		$output .= 'disabled';
	}
	$output .= '>Reset filters</button>';

	$output .= '</div></div></details>';

	$output .= '<script>' . file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts/filter.js') . '</script>';

	return $output;
}

function category_filters($categories, $selected = false)
{
	$output = '<fieldset class="categories">';

	foreach ($categories as $group => $group_content) {
		$output .=
			'
	<fieldset class="list">
		<ul>
			<li class="filter_option">
				<input type="checkbox" class="clean category" id="cat_group-' .
			$group_content['value'] .
			'" ';
		if ($selected && in_array($group_content['value'], $selected)) {
			$output .= ' checked ';
		}
		$output .=
			'/>
				<label for="cat_group-' .
			$group_content['value'] .
			'"><span class="emoji">' .
			$group_content['emoji'] .
			'</span>' .
			$group .
			'</label>

				<ul>';

		foreach ($group_content['categories'] as $category => $value) {
			$output .=
				'
					<li class="filter_option">
						<input type="checkbox" name="category[]" class="clean category" id="cat-' .
				$value .
				'"" value="' .
				$value .
				'" ';
			if ($selected && in_array($value, $selected)) {
				$output .= ' checked ';
			}
			$output .=
				'/>
						<label for="cat-' .
				$value .
				'">' .
				$category .
				'</label>

					</li>';
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
