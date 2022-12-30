<?php

// Rickies _data_ controller, timeline details
$rickies_events__array[$id]['name_short'] = check_key('Name (short)', $fields);
$rickies_events__array[$id]['rickies_winner'] = check_key('Rickies 1st', $fields);
$rickies_events__array[$id]['flexies_winner'] = check_key('Flexies 1st', $fields);
$rickies_events__array[$id]['url'] = '/' . $rickies_events__array[$id]['url_name'];
$rickies_events__array[$id]['timeline_start'] = check_key('Days from first Rickies', $fields);
$rickies_events__array[$id]['timeline_duration'] = check_key('Days between scoring next Rickies', $fields);
$rickies_events__array[$id]['timeline_end'] = check_key('Date of next Rickies', $fields);
