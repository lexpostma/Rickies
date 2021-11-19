<?php

// Rickies _data_ controller, timeline details

$rickies_events__array[$id]['winner'] = check_key('Rickies 1st', $fields);
$rickies_events__array[$id]['url'] = '/' . $rickies_events__array[$id]['url_name'];
$rickies_events__array[$id]['timeline_start'] = check_key('Days from first Rickies', $fields);
$rickies_events__array[$id]['timeline_duration'] = check_key('Days between scoring next Rickies', $fields);
