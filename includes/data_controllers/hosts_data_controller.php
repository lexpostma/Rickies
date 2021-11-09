<?php

// Host _data_ controller

$hosts_data__array = [];
$hosts_data__request = $airtable->getContent('Hosts', $hosts_data__params);
do {
	$hosts_data__response = $hosts_data__request->getResponse();
	foreach ($hosts_data__response['records'] as $array) {
		// $id = json_decode(json_encode($array), true)['id'];
		$fields = json_decode(json_encode($array), true)['fields'];

		$id = check_key('First name', $fields);

		$hosts_data__array[$id] = [
			'personal' => [
				'first_name' => $id,
				'full_name' => check_key('Full name', $fields),
			],
			'images' => [
				'memoji' => [
					'neutral' => check_key('Memoji neutral', $fields),
					'happy' => check_key('Memoji happy', $fields),
					'sad' => check_key('Memoji sad', $fields),
				],
			],
		];

		if ($all_host_details) {
			$hosts_data__array[$id]['personal']['location'] = check_key('Location', $fields);
			$hosts_data__array[$id]['personal']['website_url'] = check_key('Website URL', $fields);
			$hosts_data__array[$id]['personal']['website_name'] = check_key('Website name', $fields);
			$hosts_data__array[$id]['personal']['twitter'] = check_key('Twitter handle', $fields);
			$hosts_data__array[$id]['personal']['twitter_url'] = check_key('Twitter', $fields);
			$hosts_data__array[$id]['images']['photo'] = airtable_image_url(check_key('Photo', $fields, false, 0));
			$hosts_data__array[$id]['titles'] = goat_referral(check_key('Titles HTML', $fields));

			$hosts_data__array[$id]['achievements'] = [
				'annual_rickies_wins' => [
					'value' => check_key('Rickies Wins Annual Count', $fields),
					'label' => 'time Annual Chairman',
					'0hide' => true,
				],
				'keynote_rickies_wins' => [
					'value' => check_key('Rickies Wins Keynote Count', $fields),
					'label' => 'time Keynote Chairman',
					'0hide' => true,
				],
				// 'rickies_wins' => [
				// 	'value' => check_key('Rickies Wins Total Count', $fields),
				// 	'label' => 'time Rickies winner',
				// 	'0hide' => true,
				// ],
				'flexies_wins' => [
					'value' => check_key('Flexies Wins Total Count', $fields),
					'label' => 'time Flexies winner',
					'0hide' => true,
				],
				'flexies_lost' => [
					'value' => check_key('Flexies Donation Count', $fields),
					'label' => 'time charity donor',
					'0hide' => true,
				],
			];
			$hosts_data__array[$id]['stats'] = [
				'events' => [
					'ricky_win_rate' => [
						'value' => round_if_decimal(check_key('Rickies Wins Rate', $fields, 0) * 100),
						'label' => 'Rickies win rate',
						'unit' => '%',
					],
					'flexy_win_rate' => [
						'value' => round_if_decimal(check_key('Flexies Wins Rate', $fields, 0) * 100),
						'label' => 'Flexies win rate',
						'unit' => '%',
					],
					'flexy_loss_rate' => [
						'value' => round_if_decimal(check_key('Flexies Lost Rate', $fields, 0) * 100),
						'label' => 'Flexies lose rate',
						'unit' => '%',
					],
					'donations' => [
						'value' => check_key('Flexies Donation Amount', $fields),
						'label' => 'donated to charities',
						'unit' => "$",
						'0hide' => true,
					],
				],
				'picks' => [
					'Regular' => [
						'Correct' => check_key('Picks Regular Correct Count', $fields, 0),
						'Wrong' =>
							check_key('Picks Regular Wrong Count', $fields, 0) -
							check_key('Picks Regular Eventually Count', $fields, 0),
						'Eventually' => check_key('Picks Regular Eventually Count', $fields, 0),
						'Unknown' => check_key('Picks Regular Unknown Count', $fields, 0),
						'Total' => check_key('Picks Regular Total Count', $fields, 0),
					],
					'Risky' => [
						'Correct' => check_key('Picks Risky Correct Count', $fields, 0),
						'Wrong' =>
							check_key('Picks Risky Wrong Count', $fields, 0) -
							check_key('Picks Risky Eventually Count', $fields, 0),
						'Eventually' => check_key('Picks Risky Eventually Count', $fields, 0),
						'Unknown' => check_key('Picks Risky Unknown Count', $fields, 0),
						'Total' => check_key('Picks Risky Total Count', $fields, 0),
					],
					'Flexy' => [
						'Correct' => check_key('Picks Flexy Correct Count', $fields, 0),
						'Wrong' =>
							check_key('Picks Flexy Wrong Count', $fields, 0) -
							check_key('Picks Flexy Eventually Count', $fields, 0),
						'Eventually' => check_key('Picks Flexy Eventually Count', $fields, 0),
						'Unknown' => check_key('Picks Flexy Unknown Count', $fields, 0),
						'Total' => check_key('Picks Flexy Total Count', $fields, 0),
					],
				],
				'picks_strings' => [
					'scored_points' => [
						'value' => check_key('Points Scored Total', $fields, 0),
						'label' => 'Ricky points scored overall',
						'label1' => 'Ricky point scored overall',
					],
					'correct_flexies' => [
						'value' => check_key('Picks Flexy Total Count', $fields, 0),
						'label' => 'Flexing Points overall',
						'label1' => 'Flexing Point overall',
						'unit' => '&nbsp;FP',
					],
					'buzzkillers' => [
						'value' => round_if_decimal(check_key('Negative Rate', $fields, 0) * 100),
						'label' => 'of picks are <a href="' . filter_url('&buzzkill=on') . '">buzzkillers</a>',
						'unit' => '%',
					],
					'adjudicated' => [
						'value' => check_key('Picks Adjudicated Count', $fields, 0),
						'label' => 'picks had to be <a href="' . filter_url('&adjudicated=on') . '">adjudicated</a>',
						// 'unit' => '%',
						'0hide' => true,
					],
				],
				'coin_flips' => [
					'coin_flips_won' => [
						'value' => check_key('Coin Flip Wins Total', $fields),
						'string' =>
							$id .
							' has won <b>' .
							check_key('Coin Flip Wins Total', $fields) .
							' of ' .
							check_key('Coin Flip Participation Count', $fields) .
							'</b> coin flips, that’s a <b>' .
							round_if_decimal(check_key('Coin Flip Win Rate', $fields, 0) * 100) .
							'%</b> win rate.',
					],
					'rickies_1_by_coin_flip' => [
						'value' => check_key('Rickies 1st by Coin Flip', $fields),
						'string' =>
							'<b>' .
							check_key('Rickies 1st by Coin Flip', $fields) .
							'</b> of these granted him a chairman title.',
						'0hide' => true,
					],
					'preferred_coin_side' => [
						'value' => check_key('Preferred Coin Side', $fields),
						'string' =>
							'He has a preference for <b>' .
							strtolower(check_key('Preferred Coin Side', $fields)) .
							'</b> which he chose <b>' .
							check_key(
								'Count ' . check_key('Preferred Coin Side', $fields) . ' at Coin Flips',
								$fields
							) .
							'</b> times.',
					],
				],
				'too_soon' => [
					'too_soon_rate' => [
						'value' => round_if_decimal(check_key('Too Soon Rate', $fields, 0) * 100),
						'string' =>
							'<b>' .
							round_if_decimal(check_key('Too Soon Rate', $fields, 0) * 100) .
							'%</b> of ' .
							$id .
							'’s <a href="' .
							filter_url('&eventually=on') .
							'">wrong picks came true later</a>.',
						'0hide' => true,
					],
					'too_soon_avg' => [
						'value' => round_if_decimal(check_key('Avg Time Picked Too Soon', $fields) / 365),
						'string' =>
							'On average he is <b>' .
							round_if_decimal(check_key('Avg Time Picked Too Soon', $fields) / 365) .
							' years</b> ahead of his time.',
						'0hide' => true,
					],

					'too_soon_min' => [
						'value' => round_if_decimal(check_key('Least Time Picked Too Soon', $fields)),
						'string' =>
							'His wrong predictions are between <b>' .
							round_if_decimal(check_key('Least Time Picked Too Soon', $fields)) .
							' days</b> and <b>' .
							round_if_decimal(check_key('Most Time Picked Too Soon', $fields) / 365) .
							' years</b> to soon.',
						// '0hide' => true,
					],
					'would_have_correct' => [
						'value' => check_key('Picks Correct By Now', $fields),
						'string' =>
							'As of today, he would have had <b>' .
							check_key('Picks Correct By Now', $fields) .
							'</b> picks correct instead of ' .
							check_key('Picks Total Correct Count', $fields) .
							'.',
					],
				],
			];

			// Calculate the scored/graded picks
			$hosts_data__array[$id]['stats']['picks']['Scored'] = [
				'Correct' =>
					$hosts_data__array[$id]['stats']['picks']['Regular']['Correct'] +
					$hosts_data__array[$id]['stats']['picks']['Risky']['Correct'],
				'Wrong' =>
					$hosts_data__array[$id]['stats']['picks']['Regular']['Wrong'] +
					$hosts_data__array[$id]['stats']['picks']['Risky']['Wrong'],

				'Unknown' =>
					$hosts_data__array[$id]['stats']['picks']['Regular']['Unknown'] +
					$hosts_data__array[$id]['stats']['picks']['Risky']['Unknown'],

				'Total' =>
					$hosts_data__array[$id]['stats']['picks']['Regular']['Total'] +
					$hosts_data__array[$id]['stats']['picks']['Risky']['Total'],
			];

			// Calculate the overall pick counts
			$hosts_data__array[$id]['stats']['picks']['Overall'] = [
				'Correct' =>
					$hosts_data__array[$id]['stats']['picks']['Scored']['Correct'] +
					$hosts_data__array[$id]['stats']['picks']['Flexy']['Correct'],
				'Wrong' =>
					$hosts_data__array[$id]['stats']['picks']['Scored']['Wrong'] +
					$hosts_data__array[$id]['stats']['picks']['Flexy']['Wrong'],

				'Unknown' =>
					$hosts_data__array[$id]['stats']['picks']['Scored']['Unknown'] +
					$hosts_data__array[$id]['stats']['picks']['Flexy']['Unknown'],

				'Total' =>
					$hosts_data__array[$id]['stats']['picks']['Scored']['Total'] +
					$hosts_data__array[$id]['stats']['picks']['Flexy']['Total'],
			];

			// Calculate the rate of correctness per pick type
			foreach ($hosts_data__array[$id]['stats']['picks'] as $pick_type => $pick_values) {
				// echo $pick_type;
				$hosts_data__array[$id]['stats']['picks'][$pick_type]['Rate'] = round_if_decimal(
					($pick_values['Correct'] / ($pick_values['Total'] - $pick_values['Unknown'])) * 100
				);
			}
		}

		foreach ($hosts_data__array[$id]['images']['memoji'] as $mood => $images) {
			$hosts_data__array[$id]['images']['memoji'][$mood] = airtable_image_url(random($images));
		}

		$hosts_data__array[$id]['personal']['color'] = random($connected_colors);
		if (($key = array_search($hosts_data__array[$id]['personal']['color'], $connected_colors)) !== false) {
			unset($connected_colors[$key]);
		}
	}
} while ($hosts_data__request = $hosts_data__response->next());

// echo '<pre>', var_dump($hosts_data__array), '</pre>';
