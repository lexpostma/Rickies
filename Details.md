# Little Design Details

Below are several little details I’m proud of for this project. I just wanted to mention them somewhere for those that are interested.

## General

-   Avatars for each host cycle through a several Memoji randomly. They also have different moods dependent on the host’s ranking, and the background is a random Connected colour.
-   There’s a nice pop animation on many interactive items.
-   All dates on the website show relative time. So yesterday, today, and tomorrow, or the actual date.
-   Standalone web app with support for the safe areas on your (iOS) devices. So you don’t get big black bars at top and bottom when you add it to your home screen.
-   Full support for the system light and dark mode.

## Rickies overview

-   The Rickies trophy is custom designed, showing 3 hosts holding the coloured Connected globe.
-   The main menu on the [homepage](https://rickies.co) slowly cycles through the Connected colours. Same for some [list item graphics](https://rickies.co/about).
-   You can filter Rickies with a simple dropdown. The icon design is inspired by iOS Mail.

## Rickies details

-   [Rickies detail pages](https://rickies.co/keynote-apr-2021) have a sticky menu that allow you to easily navigate to different sections. These sections are exclusive on mobile, and together on desktop.
-   For [ungraded Rickies](https://rickies.co/ungraded) the picks are **interactive**. When you change the state of a pick, the background changes so you see you edited it.
-   When you click/tap on the Rickies winner in the leaderboard at the top, confetti is popped.
-   Podcast episodes on the Rickies detail pages support [custom artwork](https://rickies.co/keynote-sep-2020#details). This also includes the switch from old white background to the new colourful one.
-   Terms like “Rickies”, “Flexies”, and “The Bill of Rickies” are different for earlier Rickies from before the terms were coined, e.g. “Bragging rights”.

## The Bill of Rickies

-   The rules changed over time, and so does the document. New rules get added, old ones removed. Sometimes text even changes within a rule.
-   [The Bill of Rickies](https://rickies.co/billof/annual-2017) document, including titles, styling, and [links to it](https://rickies.co/annual-2017#details), changes dependent on the date of the Rickies. To reflect when terms like Rickies, Flexies and The Bill of Rickies were coined.
-   There’s a button to play The Bill of Rickies theme music. It changes the icon between play and pause, but it also gets a fixed position while playing so you can always easily pause again.
-   The favicon changes between [The Rickies](https://rickies.co/) pages and [The Bill of Rickies](https://rickies.co/billof).

## Host Leaderboard

-   Aside from Chairman titles, most titles on the leaderboard are randomised.
-   Nice donut charts to show the ratio of correct, wrong and unknown predictions, with hover state per section.

## Nerdy stuff

-   Hover states are only present on devices that support hover, so mobile devices respond faster and don’t leave a hover state behind after you tap them. This was done with a relatively new feature `@media (hover: hover)`.
-   Twitter, YouTube, and GitHub [links](https://rickies.co/about) have a little logo.
-   Fully responsive design with items moving from [columns to rows](https://rickies.co/leaderboard) on wider screens.
