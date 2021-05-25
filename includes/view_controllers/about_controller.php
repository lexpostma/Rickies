<?php

// About controller
$start_animation = rand(0, 30);
$resources = [
	'This Project',
	[
		'label1' => 'Project on GitHub',
		'label2' => 'See the code, create issues. Public but not open source',
		'label3' => '‘Read me’ was last updated ' . date_to_string_label(filemtime('../Readme.md'), true, false),
		'url' => 'https://github.com/lexpostma/Rickies/blob/' . $github . '/Readme.md',
		'img_url' => ['src' => '/images/about/project.png', 'type' => 'background', 'color' => $start_animation + 42],
	],
	[
		'label1' => 'Analytics with GoatCounter',
		'label2' => 'No tracking of personal data',
		'label3' => 'I made them public, there’s really not much there',
		'url' => $head_defaults['site_goatcounter'],
		'img_url' => ['src' => '/images/about/analytics.png', 'type' => 'background', 'color' => $start_animation + 34],
	],
	[
		'label1' => 'Changelog',
		'label2' => 'What’s new',
		'label3' => 'Last updated ' . date_to_string_label(filemtime('../Changelog.md'), true, false),
		'url' => 'https://github.com/lexpostma/Rickies/blob/' . $github . '/Changelog.md',
		'img_url' => ['src' => '/images/about/changelog.png', 'type' => 'background', 'color' => $start_animation + 25],
	],
	[
		'label1' => 'Roadmap',
		'label2' => 'My plans for future improvements',
		'label3' => 'Last updated ' . date_to_string_label(filemtime('../Roadmap.md'), true, false),
		'url' => 'https://github.com/lexpostma/Rickies/blob/' . $github . '/Roadmap.md',
		'img_url' => ['src' => '/images/about/roadmap.png', 'type' => 'background', 'color' => $start_animation + 17],
	],
	[
		'label1' => 'Acknowledgements',
		'label2' => 'Libraries, resources and tools I used',
		'label3' => 'Last updated ' . date_to_string_label(filemtime('../Acknowledgements.md'), true, false),
		'url' => 'https://github.com/lexpostma/Rickies/blob/' . $github . '/Acknowledgements.md',
		'img_url' => [
			'src' => '/images/about/acknowledgements.png',
			'type' => 'background',
			'color' => $start_animation + 9,
		],
	],
	'The Podcast',
	[
		'label1' => 'A Brief History of The Prompt and Connected',
		'label3' => 'By Stephen Hackett<br />Published at MacStories on April 18, 2019',
		'url' => 'https://www.macstories.net/stories/a-brief-history-of-the-prompt-and-connected/',
		'img_url' => '/images/about/the-prompt.png',
	],
	[
		'label1' => 'Listen to Connected',
		'label2' => 'The podcast on Relay FM',
		// 'label3' => '',
		'url' => 'https://relay.fm/connected',
		'img_url' => '/images/connected-artwork.jpg',
	],
	[
		'label1' => 'Get Connected Pro',
		'label2' => 'Preshow, postshow, no ads.',
		// 'label3' => '',
		'url' => 'https://getconnectedpro.co',
		'img_url' => '/images/connected-pro-artwork.jpg',
	],
	'More Fan Efforts',
	[
		'label1' => 'Rickipedia',
		'label2' => 'Comprehensive collection of picks and predictions',
		'label3' => 'By Jason Biatek<br />Shared in Discord on May 3, 2021',
		'url' => 'https://rickies.net',
		'img_url' => '/images/about/rickipedia.jpg',
	],
	[
		'label1' => 'The Rickies Notion Database',
		// 'label2' => 'By Majd Koshakji',
		'label3' => 'By Majd Koshakji<br />Shared in Discord on March 24, 2021',
		'url' => 'https://www.notion.so/Connected-262725156a0041bd9b0248c172862cb0',
		'img_url' => '/images/about/notion.png',
	],
	[
		'label1' => 'The Bill of Rickies',
		'label2' => 'Inspired by the US constitution',
		'label3' => 'By Mathias Bruggemann<br />Shared on Twitter on June 30, 2020',
		'url' => 'https://twitter.com/kingtritium/status/1278081027387392006?s=21',
		'img_url' => '/images/about/bill-of-rickies-mathias.png',
	],
	[
		'label1' => 'The Jeremies Gazette',
		'label2' => 'The Visionary interprets the icons of our world',
		'label3' => 'By Jason Ryan Thompson<br />Shared in Discord on Octobor 7, 2020',
		'url' => 'https://thejeremies.herokuapp.com',
		'img_url' => [
			'src' => '/images/about/jeremies.png',
			'type' => 'background',
			'color' => 'wheat',
		],
	],
	[
		'label1' => 'Upgradies',
		'label2' => 'Annual awards of Upgrade podcast',
		'label3' => 'By Zach Knox',
		'url' => 'https://upgradies.com',
		'img_url' => '/images/about/upgradies.jpg',
	],
	[
		'label1' => 'Upgrade Draft interactive scorecards',
		'label2' => 'Predictions of Upgrade podcast',
		'label3' => 'By Zach Knox',
		'url' => 'https://zachknox.com/bingo/drafts/',
		'img_url' => '/images/about/upgrade-draft.jpg',
	],
];

$introduction = file_get_contents($incl_path . 'about.html');

$head_custom = [
	'title' => 'About Rickies.co',
	'description' =>
		'Rickies.co is a tribute to the Rickies prediction draft episodes of the Connected podcast on Relay FM. Designed and built by Lex Postma.',
];
