<?php

// About controller

// TODO: Replace images and add more
$resources = [
	'This Project',
	[
		'label1' => 'Project on GitHub',
		// 'label2' => 'By Jason Biatek',
		'label3' => 'Read me last updated on ' . strftime(date_string_format(), filemtime('../Readme.md')),
		'url' => 'https://github.com/lexpostma/Rickies/blob/main/Acknowledgements.md',
		'img_url' => ['src' => '/images/about/project.svg', 'type' => 'background', 'color' => 'random'],
	],
	[
		'label1' => 'Changelog',
		'label2' => 'What’s new',
		'label3' => 'Last updated on ' . strftime(date_string_format(), filemtime('../Changelog.md')),
		'url' => 'https://github.com/lexpostma/Rickies/blob/main/Changelog.md',
		'img_url' => ['src' => '/images/about/changelog.svg', 'type' => 'background', 'color' => 'random'],
	],
	[
		'label1' => 'Roadmap',
		'label2' => 'My plans for future improvements',
		'label3' => 'Last updated on ' . strftime(date_string_format(), filemtime('../Roadmap.md')),
		'url' => 'https://github.com/lexpostma/Rickies/blob/main/Roadmap.md',
		'img_url' => ['src' => '/images/about/roadmap.svg', 'type' => 'background', 'color' => 'random'],
	],
	[
		'label1' => 'Acknowledgements',
		'label2' => 'Libraries, resources and tools I used',
		'label3' => 'Last updated on ' . strftime(date_string_format(), filemtime('../Acknowledgements.md')),
		'url' => 'https://github.com/lexpostma/Rickies/blob/main/Acknowledgements.md',
		'img_url' => ['src' => '/images/about/acknowledgements.svg', 'type' => 'background', 'color' => 'random'],
	],
	'The Podcast',
	[
		'label1' => 'Listen to Connected',
		'label2' => 'The podcast on Relay FM',
		// 'label3' => 'At MacStories on 18 April 2019',
		'url' => 'https://relay.fm/connected',
		'img_url' => '/images/connected-artwork.jpg',
	],
	[
		'label1' => 'A Brief History of The Prompt and Connected',
		'label2' => 'By Stephen Hackett',
		'label3' => 'At MacStories on 18 April 2019',
		'url' => 'https://www.macstories.net/stories/a-brief-history-of-the-prompt-and-connected/',
		'img_url' => '/images/about/the-prompt.png',
	],
	[
		'label1' => 'Get Connected Pro',
		'label2' => 'Preshow, postshow, no ads.',
		// 'label3' => 'GitHub',
		'url' => 'https://getconnectedpro.co',
		'img_url' => '/images/connected-pro-artwork.jpg',
	],
	'Other Fan Resources',
	[
		'label1' => 'Rickipedia',
		'label2' => 'By Jason Biatek',
		'label3' => 'Shared in Discord on 3 May 2021',
		'url' => 'https://rickies.net',
		'img_url' => '/images/about/rickipedia.svg',
	],
	[
		'label1' => 'The Rickies Notion Database',
		'label2' => 'By Majd Koshakji',
		'label3' => 'Shared in Discord on 24 March 2021',
		'url' => 'https://www.notion.so/Connected-262725156a0041bd9b0248c172862cb0',
		'img_url' => '/images/about/notion.png',
	],
	[
		'label1' => 'The Bill of Rickies',
		'label2' => 'By Mathias Bruggemann',
		'label3' => 'Shared on Twitter on 30 June 2020',
		'url' => 'https://twitter.com/kingtritium/status/1278081027387392006?s=21',
		'img_url' => '/images/about/bill-of-rickies-mathias.png',
	],
];

$head_custom = [
	'title' => 'About this site • The Rickies',
	// TODO: Write SEO description
	'description' => '',
];
