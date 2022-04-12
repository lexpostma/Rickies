# Changelog

_Also check out the [roadmap](Roadmap.md) with features I’d like to add in the future._

## 12 April 2022

-   Tweaked API styling
-   Added Obsidian plugin to API uses list

## 10 April 2022 v2.3

-   [Rickies API](https://rickies.co/api) available to fetch the current chairmen in JSON format

## 29 March 2022 v2.2

-   New [Trophies](https://rickies.co/trophies) page with explanations about the different Rickies trophies, including:
    -   🕋 The official [Tricky in AR](https://rickies.co/trophies#tricky)
    -   🧲 [Interactive MagTricky](https://rickies.co/trophies#magtricky)
    -   🦠 The [Ricky mascot](https://rickies.co/trophies#ricky)
    -   And [other trophies](https://rickies.co/trophies#other)
-   New [Charities](https://rickies.co/charities) page with all charities that were donated to during the Flexies including some stats, ordered by donation amount
-   New [Apple Events](https://rickies.co/apple-events) page with all Apple keynotes that were predicted in chronological order
-   Improved navigation bar is now expandable to make room for the new pages

### 10 March 2022

-   Support for when other hosts match the donation of the Flexy loser, reflected on the [event page](https://rickies.co/keynote-mar-2022) and in the stats
-   Support for the Flexy titles of the Duke, the Prince and the AG

### 13 January 2022

-   The Annual Predictions of 2018 are differently styled on the timeline, because they were not official Rickies.

### 9 January 2022

-   New and improved signatures on [The Bill of Rickies](https://rickies.co/billof) and [The Pickies Charter](https://rickies.co/charter), in random order

### 6 January 2022

-   Add host filters to the stats-links on Host Leaderboard
-   Fix timeline starting position on mobile not being at the end

### 1 January 2022

-   [Link to](https://rickies.co/billof/keynote-oct-2021#rule68) and highlight specific rule on the Bill of Rickies
-   [Picks that caused amendments](https://rickies.co/?search=&amendment=on#results) now have a link to said amendment on the Bill

## 29 December 2021 v2.1

-   Support for The Pickies, the [Triple J 2021 holiday special](https://rickies.co/annual-2022-special). Complete with:
    -   🏆 [Pickies homepage](https://rickies.co/pickies) and trophy
    -   ⚡️ Regular picks and Lightning rounds
    -   📜 [The Pickies Charter](https://rickies.co/charter), including amendments
    -   📊 [Triple J leaderboard](https://rickies.co/3j-leaderboard) with stats and new Memoji
    -   📦 [Pickies archive](https://rickies.co/3j-archive) with custom filters

---

## 25 December 2021 v2.0

-   🏷 New prediction metadata like categories, whether it came true later, buzzkillers and more. Visible in the [archive](https://rickies.co/archive), [search](https://rickies.co/?search=promotion#results) and on [Rickies pages](https://rickies.co/keynote-oct-2020#flexies)
-   🪙 New [host statistics](https://rickies.co/leaderboard#stats) for coin flips, ahead of its time, adjudication, categories and more
-   🔎 Search and archive are now expanded with filters and charts. Narrow down what you’re looking for with [categories](https://rickies.co/?search=&category%5B%5D=hardware#results), [event type](https://rickies.co/?search=&rickies_event=wwdc#results), [eligibility for reuse](https://rickies.co/?search=&reusable=on) and other metadata. You can also choose [what set of metadata](https://rickies.co/?search=&display=age#results) you want shown. The charts will update depending on the search results
-   ⏳ [Chairman timeline](https://rickies.co/leaderboard#timeline) to see who was chairman when and for how long. Scroll, drag, zoom, filter, all interactive. With winner rings

**Other smaller things in v2.0**

-   Improved standalone web app
    -   Add pull-to-refresh
    -   Manifest support with new icons for Android
    -   Share sheet fallback if there’s no native support
-   Memojis no longer wear the default clothes
-   Go to [latest Rickies](https://rickies.co/latest), [latest Keynote Rickies](https://rickies.co/latest-keynote) or [latest Annual Rickies](https://rickies.co/latest-annual)
-   [Rules slider](https://rickies.co/billof) visibility state is now stored
-   Better, more persistent navigation
-   Add sub navigation to [leaderboard](https://rickies.co/leaderboard), which changes on mobile for easier navigation
-   Better alignment of leaderboard statistics sections between hosts
-   Improve SEO with sitemap and better images
-   Added many more [little details](Details.md)

---

### 28 October 2021

-   Updated [About](https://rickies.co/about) page to include the official Rickies Trophy by Matt VanOrmer, and the new MagTricky chairman magnets

### 14 October 2021

-   Replace the back button with a navigation bar in a few places, for easier navigation
-   Add an animation to the Bill of Rickies slider to hint that you can slide it to view the full history of the rules
-   Update the slider globe to look better in light and dark mode, and be more like current artwork
-   Tweak some styling for search

## 13 October 2021 v1.5

-   Add search term highlighting with [mark.js](https://markjs.io)

## 13 October 2021 v1.4

-   [Search](https://rickies.co/?search=refresh+rate)! You can now search for predictions across all Rickies events. Search for predictions, remarks, host, type, category, event, you name it
-   There’s now also an [archive view](https://rickies.co/archive) with all the predictions in one page

### 12 October 2021

-   Improve (unpublished) episode listings during live recordings

### 23 June 2021

-   Support for Safari 15 unified tabbar colours. Safe-areas for mobile Safari were already supported

## 2 June 2021 v1.3

-   Interactive picks are now persistent. Manual states are stored in local storage so next time you visit the Rickies page, your scores are still there

## 29 May 2021 v1.2

-   Support for Mega Chairman, if a host has both titles at once

## 28 May 2021 v1.1

-   Support for Rickies statuses, in preparation for the [WWDC21 Keynote Rickies](https://rickies.co/keynote-jun-2021)
    -   Pending a future predictions episode, to prepare the page details
    -   Live episode, to follow along with the show and the predictions

### 27 May 2021

-   Fix for new emoji on unsupported devices overlapping with text
-   Add `<time>` tags for better SEO

## 26 May 2021 v1.0

-   Initial release, just in time for the WWDC21 Keynote Rickies
-   Finish documentation for GitHub

#### 25 May 2021

-   Finish [About page](https://rickies.co/about)
-   Finish [The Bill of Rickies](https://rickies.co/billof) data entry

#### 24 May 2021

-   Finish [Rickies events](https://rickies.co/) data entry
-   Improve back button behaviour, ‘go home’ vs ‘history - 1’

#### 23 May 2021

-   Add ability to [filter Rickies overview](https://rickies.co/annual)

#### 19 May 2021

-   Add theme song to The Bill of Rickies
-   Add toggle to show/hide The Bill of Rickies rules slider

#### 17 May 2021

-   Add seals and signatures to The Bill of Rickies

#### 16 May 2021

-   Change styling of The Bill of Rickies from paper to parchment on specific event

#### 15 May 2021

-   Add button to open share sheet in standalone web app mode

#### 14 May 2021

-   Finish [Leaderboard page](https://rickies.co/leaderboard)
-   Make ungraded Rickies interactive scorecards
-   Add web app promotion
-   Major SEO improvements

#### 12 May 2021

-   Add many links to About page

#### 12 May 2021

-   Add [The Bill of Rickies](https://rickies.co/billof) rules slider
-   Major safe-area improvements
-   Enable standalone web app

#### 10 May 2021

-   Add GoatCounter analytics

#### 30 April 2021

-   Add charts to leaderboard
-   Add Memoji as host avatars
-   Major styling improvements

#### 27 April 2021

-   Finish initial structure of Rickies detail pages, including:
    -   Sticky menu
    -   Prediction data
    -   Scoring data
    -   More event details

#### 23 April 2021

-   Publish teaser page on Rickies.co
-   Finish initial structure of Rickies.co

#### 16 April 2021

-   Start new fun personal project
