<?php

// Host _data_ controller

$hosts_data__array = [];
$memoji_used_index = [
	'neutral' => [],
	'happy' => [],
	'sad' => [],
];

$hosts_data__request = $airtable->getContent('Hosts', $hosts_data__params);
do {
	$hosts_data__response = $hosts_data__request->getResponse();
	if (is_countable($hosts_data__response['records'])) {
		// Response from Airtable is countable, even if 0, so move forward
		foreach ($hosts_data__response['records'] as $array) {
			// $id = json_decode(json_encode($array), true)['id'];
			$fields = json_decode(json_encode($array), true)['fields'];

			$id = check_key('First name', $fields);

			$hosts_data__array[$id] = [
				'last_edited' => check_key('Last edit date', $fields),
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

			if (isset($all_host_details)) {
				$hosts_data__array[$id]['personal']['location'] = check_key('Location', $fields);
				$hosts_data__array[$id]['personal']['website_url'] = check_key('Website URL', $fields);
				$hosts_data__array[$id]['personal']['website_name'] = check_key('Website name', $fields);
				$hosts_data__array[$id]['personal']['twitter'] = check_key('Twitter handle', $fields);
				$hosts_data__array[$id]['personal']['twitter_url'] = check_key('Twitter', $fields);
				$hosts_data__array[$id]['images']['photo'] = airtable_image_url(check_key('Photo', $fields, false, 0));
				$hosts_data__array[$id]['titles'] = goat_referral(check_key('Titles HTML', $fields));
				$hosts_data__array[$id]['titles_other'] = goat_referral(check_key('Other Titles HTML', $fields));

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
				if (!isset($triple_j)) {
					$ricky = 'Ricky ';
					$flexing = 'Flexing';
					$fp = 'FP';
					$search = '';
				} else {
					$ricky = '';
					$flexing = 'Lightning';
					$fp = 'LP';
					$search = '&3j=on';
				}
				$hosts_data__array[$id]['stats'] = [
					'rickies' => [
						'ricky_win_rate' => [
							'value' => round_if_decimal(check_key('Rickies Wins Rate', $fields, 0) * 100),
							'label' => 'Rickies win rate',
							'unit' => '%',
						],
						'days_annual_chairman' => [
							'value' => check_key('Days of Annual Chairman', $fields, 0),
							'label' => 'days he’s been Annual&nbsp;Chairman',
							'label1' => 'day he’s been Annual&nbsp;Chairman',
							// 'unit' => '&nbsp;days',
							// 'unit1' => '&nbsp;day',
							'0hide' => true,
						],
						'days_keynote_chairman' => [
							'value' => check_key('Days of Keynote Chairman', $fields, 0),
							'label' => 'days acting Keynote&nbsp;Chairman',
							'label1' => 'day acting Keynote&nbsp;Chairman',
							// 'unit' => '&nbsp;days',
							// 'unit1' => '&nbsp;day',
							'0hide' => true,
						],
					],
					'flexies' => [
						'flexy_win_rate' => [
							'value' => round_if_decimal(check_key('Flexies Wins Rate', $fields, 0) * 100),
							'label' => 'Flexies win rate',
							'unit' => '%',
						],
						'charity_choice_due_to_coin' => [
							'value' => check_key('Chose Charity Due to Coin Flip', $fields),
							'label' => 'Flexies won by coin flip',
							'0hide' => true,
						],
						'flexy_loss_rate' => [
							'value' => round_if_decimal(check_key('Flexies Lost Rate', $fields, 0) * 100),
							'label' => 'Flexies lose rate',
							'unit' => '%',
						],
						'donations_total' => [
							'value' => check_key('Flexies Donation Amount', $fields),
							'label' => 'donated to charities',
							'unit' => "$",
							'0hide' => true,
						],
						'donations_biggest' => [
							'value' => check_key('Flexies Biggest Single Donation Amount', $fields),
							'label' => 'biggest single donation',
							'unit' => "$",
							'0hide' => true,
						],
						'donation_due_to_coin' => [
							'value' => check_key('Donated Due to Coin Flip', $fields),
							'label' => 'donations due to a coin flip',
							'label1' => 'donation due to a coin flip',
							'0hide' => true,
						],
					],
					'picks_strings' => [
						'scored_points' => [
							'value' => check_key('Points Scored Total', $fields, 0),
							'label' => $ricky . 'points scored overall',
							'label1' => $ricky . 'point scored overall',
						],
						'correct_flexies' => [
							'value' => check_key('Picks Flexy Total Count', $fields, 0),
							'label' => $flexing . ' Points overall',
							'label1' => $flexing . ' Point overall',
							'unit' => '&nbsp;' . $fp,
						],
						'buzzkillers' => [
							'value' => round_if_decimal(check_key('Negative Rate', $fields, 0) * 100),
							'label' =>
								'of picks are <a href="' . filter_url($search . '&buzzkiller=on') . '">buzzkillers</a>',
							'unit' => '%',
						],
						'adjudicated' => [
							'value' => check_key('Picks Adjudicated Count', $fields, 0),
							'label' =>
								'picks had to be <a href="' .
								filter_url($search . '&adjudicated=on') .
								'">adjudicated</a>',
							// 'unit' => '%',
							'0hide' => true,
						],
					],
					'coin_flips' => [
						'coin_flips_string' => [
							'value' => true,
							'string' => check_key('Coin Flip String', $fields),
						],
					],
					'too_soon' => [
						'too_soon_string' => [
							'value' => true,
							'string' => check_key('Ahead of its Time String', $fields),
						],
					],
				];
				if (check_key('Categories', $fields)) {
					$hosts_data__array[$id]['stats']['picks_strings']['fav_categories'] = [
						'value' => frequent_in_array(explode(';', check_key('Categories', $fields)))[0],
						'label' =>
							'is his favourite category, with <b>' .
							frequent_in_array(explode(';', check_key('Categories', $fields)))[1] .
							'</b> in 2nd place',
					];
					$hosts_data__array[$id]['stats']['picks_strings']['success_categories'] = [
						'value' => frequent_in_array(explode(';', check_key('Correct Categories', $fields)), 1)[0],
						'label' => 'is his most successful category',
					];
				}

				include 'picks_count.php';
			}

			foreach ($hosts_data__array[$id]['images']['memoji'] as $mood => $images) {
				// $images must not be false, and need to be array
				if ($images && is_array($images)) {
					// Grab a random memoji from the array
					$image = random($images, $memoji_used_index[$mood]);
					// Define the URL of the selected memoji
					$hosts_data__array[$id]['images']['memoji'][$mood] = airtable_image_url($image[0]);
					// Make sure the same memoji is not also used for other hosts
					$memoji_used_index[$mood][] = $image[1];
					unset($image);
				}
			}

			$hosts_data__array[$id]['personal']['color'] = random($connected_colors);
			if (($key = array_search($hosts_data__array[$id]['personal']['color'], $connected_colors)) !== false) {
				unset($connected_colors[$key]);
			}
		}
	} else {
		// Response from Airtable is not countable, so it's probably an error instead of an empty array
		include $incl_path . 'airtable_error.php';
	}
} while ($hosts_data__request = $hosts_data__response->next());

unset($memoji_used_index);
// echo '<pre>', var_dump($hosts_data__array), '</pre>';
