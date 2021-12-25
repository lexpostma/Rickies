# Complex Airtable formulas

Explanation for the more complex formulas. Since Airtable does not support syntax highlighting and strips all white-space formatting after submitting, it's very hard to figure out what I did in the past. Or how to replicate/extend it.

## Calculate winner of the Rickies

Calculate the winner of the Rickies I first used a `SWITCH()` statement, which is [somewhat new to Airtable](https://support.airtable.com/hc/en-us/articles/360042104374-An-alternative-to-IF-statements-using-SWITCH-). Here the `expression` that needs to be compared is an `IF()` statement that compares the score for each host with the `MAX()` score of all hosts.

Following that `expression` are the `[pattern, result]` combos, one for each host. If the combined `expression` matches just a single name, that means that host won.

If it does not match any of the `patterns`, that means the `expression` is a combination of 2+ names. Multiple hosts had the same score as the `MAX()` score.

That brings us to the `default`. Here, the `default` is an `IF()` statement to check if the coin flip is entered. If it is entered, that means the tie was won, which defines the winner of the Rickies. If the coin flip is still empty, the tie is still unresolved. In that case, the goal is to show the tie and between which hosts. Note that the "between which hosts" part is the same as the `expression` of the `SWITCH()` statement.

```
SWITCH(
	(
		  IF(MAX({Federico’s score},{Myke’s score},{Stephen’s score})={Federico’s score},"Federico")
		& IF(MAX({Federico’s score},{Myke’s score},{Stephen’s score})={Myke’s score},"Myke")
		& IF(MAX({Federico’s score},{Myke’s score},{Stephen’s score})={Stephen’s score},"Stephen")
	),
	"Federico","Federico",
	"Stephen","Stephen",
	"Myke","Myke",
	IF(
		{Ricky coin flip won by},
		{Ricky coin flip won by},
		"Tie:"
			& IF(MAX({Federico’s score},{Myke’s score},{Stephen’s score})={Federico’s score}," Federico")
			& IF(MAX({Federico’s score},{Myke’s score},{Stephen’s score})={Myke’s score}," Myke")
			& IF(MAX({Federico’s score},{Myke’s score},{Stephen’s score})={Stephen’s score}," Stephen")
	)
)
```

To get the loser of the Rickies, the formula needs to change slightly. We need to compare the lowest scores, and we need to reverse the coin flip winner. You'll get a formula like this:

```
SWITCH(
	(
		  IF(MIN({Federico’s score},{Myke’s score},{Stephen’s score})={Federico’s score},"Federico")
		& IF(MIN({Federico’s score},{Myke’s score},{Stephen’s score})={Myke’s score},"Myke")
		& IF(MIN({Federico’s score},{Myke’s score},{Stephen’s score})={Stephen’s score},"Stephen")
	),
	"Federico","Federico",
	"Stephen","Stephen",
	"Myke","Myke",
	IF(
		{Ricky coin flip won by},
		SUBSTITUTE(
			SUBSTITUTE(
				"FedericoMykeStephen",
				{Ricky winner},
				""
			),
			{Ricky coin flip won by},
			""
		),
		"Tie:"
			& IF(MIN({Federico’s score},{Myke’s score},{Stephen’s score})={Federico’s score}," Federico")
			& IF(MIN({Federico’s score},{Myke’s score},{Stephen’s score})={Myke’s score}," Myke")
			& IF(MIN({Federico’s score},{Myke’s score},{Stephen’s score})={Stephen’s score}," Stephen")
	)
)
```

The `MAX()` is replaced with `MIN()` to get the lowest score instead of the highest. And in case of a tie between 2nd and 3nd place the coin flip winner is 2nd, while 3rd is the Rickies loser we are looking for. That means the name we want to display is the only name we don't have yet. So we need to take all names together and remove the winners of the Rickies and the coin flip to get the real loser. To remove these, I used a `SUBSTITUTE()` formula with the combined names as `old_text` and an empty `new_text`. Each winner is substituted with nothing, leaving the name of the host in 3rd place as a value.

This same kind of formula, but slightly altered, can be used to find:

-   **Flexies winner:** replace `{score}` fields with `{Flexy percentage}` fields, and the coin flip fields should be `{Flexy coin flip won by}`
-   **Flexies loser:** a combination of Rickies loser and Flexies winner 😉

## Get the ranking order of Rickies/Flexies

For the Flexies:

```
IF(
	AND(
		{Flexy winner (manual)},
		LEN(
			(
				{Flexy winner}
				& ", "
				& SUBSTITUTE(
					SUBSTITUTE(
						"FedericoMykeStephen",
						{Flexy winner},
						""
					),
					{Flexy loser},
					""
				)
				& ", "
				& {Flexy loser}
			)
		) = 23
	),
	(
		{Flexy winner}
		& ", "
		& SUBSTITUTE(
			SUBSTITUTE(
				"FedericoMykeStephen",
				{Flexy winner},
				""
			),
			{Flexy loser},
			""
		)
		& ", "
		& {Flexy loser}
	)
)
```

Only return a value `IF()` there's a manual winner defined `AND()` the total length `LEN()` of the string is 23. The names don't change, only the order, so it's always 23 characters.

If that's all true, we return the Winner and Loser. In between those there's a `SUBSTITUTE()` to find the 2nd place name, similar to the reverse coin flip method mentioned above.

## Format time value with different units

Some picks are predicted too early, and become true after scoring is finished. To calculate the time between the scoring of the pick and it becoming true anyway:

```
IF(
	{Came true date},
	DATETIME_DIFF(
		{Came true date},
		{Scoring date},
		'days'
	)
)
```

This gives a value in days. Now I want to have a nicely formatted string to increases in unit if there are more days. This formula is the result:

```
IF(
	{Picked too early [in days]},
	IF(
		{Picked too early [in days]}<14,
		{Picked too early [in days]}&IF({Picked too early [in days]}=1," day"," days"),
		IF(
			{Picked too early [in days]}<56,
			ROUND({Picked too early [in days]}/7,0)&IF(ROUND({Picked too early [in days]}/7,0)=1," week"," weeks"),
			IF(
				{Picked too early [in days]}<350,
				ROUND({Picked too early [in days]}/30,0) & IF(ROUND({Picked too early [in days]}/30,0)=1 ," month"," months"),
				ROUND({Picked too early [in days]}/365,1)& IF(ROUND({Picked too early [in days]}/365,1)=1," year" ," years" )
			)
		)
	)
)

```

So here, it goes from 13 days to 1 week, 8 weeks to 2 months, and 12 months to 1 year etc.

## Paragraph with statistics

Stats about how hosts are ahead of its time

```
'<b>'
& ROUND({Too Soon Rate}*100,1)
& '%</b> of '
& {First name}
& '’s <a href="/?search=&ahead_of_its_time=on">wrong picks came true later</a>.'

& ' On average he is <b>'
& ROUND({Avg Time Picked Too Soon}/365,1)
& ' years</b> ahead of his time.'

& ' His wrong predictions are between <b>'
& {Least Time Picked Too Soon}
& ' days</b> and <b>'
& ROUND({Most Time Picked Too Soon}/365,1)
& ' years</b> to soon.'

& ' As of today, he would have had <b>'
& {Picks Correct By Now}
& '</b> picks correct instead of '
& {Picks Total Correct Count}
& '.'
```

Stats about the host’s coin flips

```
{First name}
& ' has won <b>'
& {Coin Flip Wins Total}
& ' of '
& {Coin Flip Participation Count}
& '</b> coin flips, that’s a <b>'
& ROUND({Coin Flip Win Rate}*100,1)
& '%</b> win rate.'

& IF(
	{Rickies 1st by Coin Flip},
	' <b>'
	& {Rickies 1st by Coin Flip}
	& '</b> of these granted him a chairman title.'
)
& IF(
	{Preferred Coin Side},
	' He has a preference for <b>'
	& LOWER({Preferred Coin Side})
	& '</b> which he chose <b>'
	& IF(
		{Preferred Coin Side} = "Heads",
		{Count Heads at Coin Flips},
		{Count Tails at Coin Flips}
	)
	& '</b> times, and won <b>'
	& IF(
		{Preferred Coin Side} = "Heads",
		{Count Wins with Heads at Coin Flips},
		{Count Wins with Tails at Coin Flips}
	)
	& '</b> times with.'
)
```

## Define the last modification date based on linked records and their modification dates

First create rollup fields for each linked field that influences the overall modification date, with formula `MAX(values)`. For each, use `DATETIME_FORMAT()` with `X` as format to make the data a UNIX timestamp. Next, make them an integer with `INT()`, and use `MAX()` to get to highest value. Note that the integer is needed because `MAX()` does not seem to work with date values in the formula field (it does work for rollup fields). The last step is to parse the integer output of `MAX()` with `DATETIME_PARSE()` to create a date format again. Here’s the formula:

```
DATETIME_PARSE(
	MAX(
		IF(
			{Rickies last edited},
			INT(DATETIME_FORMAT({Rickies last edited},'X'))
		),
		IF(
			{Picks last edited},
			INT(DATETIME_FORMAT({Picks last edited},'X'))
		),
		IF(
			{Charity last edited},
			INT(DATETIME_FORMAT({Charity last edited},'X'))
		),
		IF(
			{Apple Event last edited},
			INT(DATETIME_FORMAT({Apple Event last edited},'X'))
		),
		IF(
			{Predictions episode last edited},
			INT(DATETIME_FORMAT({Predictions episode last edited},'X'))
		),
		IF(
			{Results episode last edited},
			INT(DATETIME_FORMAT({Results episode last edited},'X'))
		)
	),
	'X'
)
```

## Title string

```
IF(
	URL,
	'<a target="_blank" href="'
	& URL
	& '" data-goatcounter-click="'
	& URL
	& '" data-goatcounter-title="'
	& Name
	& ' ',
	'<span '
)
& 'class="'
& IF(
	Priority,
	'priority '
)
& IF(
	{Special emoji class} = "rotate_coin",
	'rotate_coin '
)
& '">'

& IF(
	Emoji,
	'<span class="emoji '
	& IF(
		AND(
			{Special emoji class},
			{Special emoji class} != "rotate_coin"
		),
		{Special emoji class}
	)
	& '">'
	& Emoji
	& '</span>'
)
& Name
& IF(
	URL,
	'</a>',
	'</span>'
)
```
