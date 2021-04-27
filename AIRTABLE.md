# Complex Airtable formulas

This documentation is to explain the more complex formulas, mostly to myself. Since Airtable does not support syntax highlighting and strips all white-space formatting after submitting, it's very hard to figure out what I did in the past. Or how to replicate/extend it.

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
