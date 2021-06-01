# Little Design Details

Below are several little details I’m proud of for this project. I just wanted to mention them somewhere for those that are interested.

## General

-   Avatars for each host cycle through a several Memoji randomly. They also have _different moods_ depending on the host’s ranking, and the background is a random Connected colour.
-   There’s a nice pop animation on many interactive items.
-   All dates on the website show relative time. So yesterday, today, and tomorrow, or the actual date.
-   Standalone web app with support for the safe areas on your (iOS) devices. So you don’t get big black bars at top and bottom when you add it to your home screen.
-   Full support for the system light and dark mode.

## Rickies overview

-   The Rickies trophy is custom designed, showing 3 hosts holding the coloured Connected globe.
-   When you first loaded the page, confetti is popped. After that, it waits for a while before popping again so you don’t get annoyed. Click/tap the trophy to manually pop the confetti.
-   The main menu on the [homepage](https://rickies.co) slowly cycles through the Connected colours. Same for some [list item graphics](https://rickies.co/about).
-   You can filter Rickies with a simple dropdown. The icon design is inspired by iOS Mail.
-   Rickies can have different statuses. [_Pre-Rickies_](https://rickies.co/annual-2018), [_Ungraded_](https://rickies.co/ungraded), _Awaiting show_ and even _Live_, they all have a little tags on the overview and a banner on the detail page.

## Rickies details

-   [Rickies detail pages](https://rickies.co/keynote-apr-2021) have a sticky menu that allow you to easily navigate to different sections. These sections are exclusive on mobile, and together on desktop.
-   For [ungraded Rickies](https://rickies.co/ungraded) the picks are **interactive**. When you change the state of a pick, the background changes so you see you edited it.
-   When you click/tap on the Rickies winner in the leaderboard at the top, confetti is popped.
-   Podcast episodes on the Rickies detail pages support [custom artwork](https://rickies.co/keynote-sep-2020#details). This also includes the switch from old white background to the new colourful one.
-   Rickies episode titles have a predefined format since [episode 259](https://www.relay.fm/connected/archive), but thanks to Connected Pro we got insight into what the title would have been in an alternative timeline. If it was mentioned in the post-show the alternative title is on the [Rickies detail page](https://rickies.co/keynote-jun-2021).
-   Terms like “Rickies”, “Flexies”, and “The Bill of Rickies” are different for earlier Rickies from before the terms were coined, e.g. “Bragging rights”.

## The Bill of Rickies

-   The rules changed over time, and so does the document. New rules get added, old ones removed. Sometimes text even changes within a rule.
-   [The Bill of Rickies](https://rickies.co/billof/annual-2017) document, including titles, styling, and [links to it](https://rickies.co/annual-2017#details), changes dependent on the date of the Rickies. To reflect when terms like Rickies, Flexies and The Bill of Rickies were coined.
-   There’s a button to play The Bill of Rickies theme music. It changes the icon between play and pause, but it also gets a fixed position while playing so you can always easily pause again.
-   The favicon changes between [The Rickies](https://rickies.co/) pages and [The Bill of Rickies](https://rickies.co/billof).
-   I can’t stop playing with the button to open and close the slider, especially on mobile.

## Host Leaderboard

-   Aside from Chairman titles, most titles on the leaderboard are randomised. Refresh a few times to see the inside japes.
-   Nice donut charts to show the ratio of correct, wrong and unknown predictions, with hover state per section.
-   Click/tap the Chairman title holders to pop some confetti again.

## About Rickies.co

-   The icons for the GitHub links cycled through the Connected colours with a random starting point, with across the list they’re always in rainbow order.
-   I had to get the artwork for The Prompt in this website somewhere. Haha, goal achieved.
-   Other incredible fan efforts are all mentioned too.

## Nerdy stuff

-   Hover states are only present on devices that support hover, so mobile devices respond faster and don’t leave a hover state behind after you tap them. This was done with a relatively new feature `@media (hover: hover)`.
-   Twitter, YouTube, and GitHub [links](https://rickies.co/about) have a little logo.
-   Fully responsive design with items moving from [columns to rows](https://rickies.co/leaderboard) on wider screens.
