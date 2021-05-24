<div id="statusbar"></div>
<header class="home">
	<a
		target="_blank"
		href="<?= $head['site_relay'] ?>"
		id="header_corner"
		<?= $head['site_relay_goat'] ?>
	>
		<img id="relay_logo" src="/images/relay-logo.png" alt="<?= $head['company'] ?> logo"/>
	</a>
	<div class="hero_content">
		<img class="trophy trophy--light" src="/images/rickies-trophy.png" alt="Rickies trophy" onclick="confetti_go()"/>
		<img class="trophy trophy--dark" src="/images/rickies-trophy-dark.png" alt="Rickies trophy" onclick="confetti_go()"/>
		<div class="hero_heading">
			<h1>The Rickies</h1>
			<?= $hero_tag ?>
		</div>
	</div>
</header>

<nav id="nav_content" class="home" style="animation-delay: <?= rand(-50, 0) ?>s;">
	<div class="nav_content--items">
		<a class="active" href="#list"><span class="need_space--sm">The </span>Rickies</a>
		<a href="/billof"><span class="need_space--xs">The </span>Bill of Rickies</a>
		<a href="/leaderboard"><span class="need_space--sm">Host </span>Leaderboard</a>
		<a href="/about">About</a>
	</div>
</nav>

<?= no_script_banner() ?>

<section><?= $introduction ?></section>

<section id="list">
	<h2 class="list_title <?if(isset($filter)){echo "active"; }?>">
		<select class="clean" id="filter_menu">
			<option <?if(!isset($filter)){echo "selected"; }?> value="/">All Rickies</option>
			<optgroup label="Filter the Rickies">
				<option <?if(isset($filter) && $filter == 'Annual'){echo "selected"; }?> value="/annual#list">Annual Rickies</option>
				<option <?if(isset($filter) && $filter == 'Keynote'){echo "selected"; }?> value="/keynote#list">Keynote Rickies</option>
				<option <?if(isset($filter) && $filter == 'WWDC'){echo "selected"; }?> value="/wwdc#list">WWDC Rickies</option>
				<option <?if(isset($filter) && $filter == 'Ungraded'){echo "selected"; }?> value="/ungraded#list">Ungraded Rickies</option>
			</optgroup>
		</select>
<?php if (!isset($filter)) {
	echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-filter.svg');
} else {
	echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-filter-active.svg');
} ?>
	</h2>
	<script type="text/javascript">
		 var urlmenu = document.getElementById( 'filter_menu' );
		 urlmenu.onchange = function() {
			window.goatcounter.count({
				path: 'Filter by '+this.options[ this.selectedIndex ].text,
				title: 'Filter Rickies',
				referrer: window.location.href,
				event: true,
			});
			window.open( this.options[ this.selectedIndex ].value, '_self');
		 };
	</script>
<?php if (!isset($filter_error)) {
	echo '<ul class="list_item_group">';
	foreach ($rickies_events__array as $event) {
		echo list_item($event);
	}
	echo '</ul>';
} else {
	echo '<p>' . $filter_error . '</p>';
} ?>
</section>