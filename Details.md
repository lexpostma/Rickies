# Little Design Details

-   Full support for the system light and dark mode.
-   Fully responsive design with items moving from [columns to rows](https://rickies.co/leaderboard) on wider screens.
-   [Rickies detail pages](https://rickies.co/keynote-apr-2021) have a sticky menu that allow you to easily navigate to different sections. These sections as exclusive on mobile, and together on desktop.
-   Hover states are only present on devices that support hover, so mobile devices respond faster and don’t leave a hover state behind after you tap them. This was done with a relatively new feature `@media (hover: hover)`.
-   Podcast episodes on the Rickies detail pages support [custom artwork](https://rickies.co/keynote-sep-2020#details). This also includes the switch from old white background to the new striped colourful one.
-   The avatars for each host cycle randomly through a few several Memoji. These also have different moods dependent on the host’s ranking, and the background is a random Connected colour.
-   Twitter, YouTube, and GitHub [links](https://rickies.co/about) have a little logo.
-   When you click/tap on the Rickies winner in the leaderboard at the top, confetti is popped.
-   The main menu on the [homepage](https://rickies.co) slowly cycles through the Connected colours. Same for some [list item graphics](https://rickies.co/about).
-   All dates on the website show relative time. So yesterday, today, and tomorrow, or the actual date.
-   There’s a nice pop animation on many interactive items.
-   Standalone web app with support for the safe areas on your (iOS) devices. So you don’t get big black bars at top and bottom when you add it to your home screen.
-   For ungraded Rickies the picks are interactive. When you change the state of a pick, the background changes so you see you edited it.
-   The favicon changes between [The Rickies](https://rickies.co/) pages and [The Bill of Rickies](https://rickies.co/billof).
-   Leaderboard titles are randomised.
