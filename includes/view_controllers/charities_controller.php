<?php

// Charities controller
include '../includes/data_controllers/charities_data_controller.php';

$introduction =
	'<p>During the Keynote Rickies of June 2020, <a href="/billof/keynote-jun-2020#rule83">the Bill of Rickies</a> was amended to include a donation to a charity of choice. The loser of the Flexies must donate $25 per wrong Flexy to a charity of the Flexy winner’s choice. Since then, the hosts have donated a total of <b>$' .
	$total_donated .
	'</b> across ' .
	count($charities__array) .
	' different charities. Below are all the charities throughout the years, sorted by donation amount.</p>';

$stjude = goat_referral(
	'<p>Charities has been a recurring theme for Connected and Relay FM. Every September, the Relay FM community of podcasters and listeners rallies together to support the lifesaving mission of <a href="https://stjude.org/relay" target="_blank">St. Jude Children’s Research Hospital</a> during Childhood Cancer Awareness Month. Throughout the month, Relay FM introduces ways to support St. Jude through entertaining donation challenges and other mini-fundraising events that culminate in the annual Relay for St. Jude Podcastathon.</p>'
);

$head_custom = [
	'title' => 'Charities • The Rickies',
	'description' => strip_tags($introduction),
	'image' => domain_url() . '/images/seo/hero-charities.jpg',
	'keywords' => ['charity', 'fundraising', 'donations'],
	'theme-color' => '#E51F2E',
];

$introduction = $introduction . $stjude;
