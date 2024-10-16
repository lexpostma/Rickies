<div id="statusbar"></div>
<header class="home">
	<a
		target="_blank"
		href="<?= $head['site_relay'] ?>"
		id="header_corner"
		<?= $head['site_relay_goat'] ?>
	>
		<img id="relay_logo" src="/images/logos/relay-logo.svg" alt="<?= $head['company'] ?> logo"/>
	</a>
	<div class="hero_content">
		<img class="trophy trophy--light" src="/images/<?= $trophy_asset ?>-trophy.png" alt="<?= ucfirst(
	$trophy_asset
) ?> trophy" onclick="confetti_go()"/>
		<img class="trophy trophy--dark" src="/images/<?= $trophy_asset ?>-trophy-glow.png" alt="<?= ucfirst(
	$trophy_asset
) ?> trophy" onclick="confetti_go()"/>
		<div class="hero_heading">
			<?= $hero_title, $hero_tag ?>
			<?php if (date('m') == '9') {
   	echo goat_referral(
   		'<p>🎗️ September is Childhood Cancer Awareness Month.<br/><a title="Donate to St. Jude" target="_blank" href="http://relay.fm/stjude">Donate to St. Jude Children’s Research Hospital</a></p>'
   	);
   } ?>
		</div>
	</div>
</header>



<?php
if (!isset($triple_j)) {
	echo navigation_bar();
} else {
	echo navigation_bar(false, true);
}
echo no_script_banner();
?>

<section><?= $introduction ?></section>

<section id="list">
	<h2 class="list_title <?php if (isset($rickies_filter)) {
 	echo 'active';
 } ?>">
		<select class="clean" id="filter_menu">
			<option <?php if (!isset($rickies_filter)) {
   	echo 'selected';
   } ?> value="/#list">All Rickies</option>
			<optgroup label="Filter the Rickies">
				<?php if (isset($rickies_filter) && $rickies_filter == 'Preview') {
    	echo '<option selected value="/preview#list">All Rickies + previews 🚨</option>';
    } ?>
				<option <?php if (isset($rickies_filter) && $rickies_filter == 'Annual') {
    	echo 'selected';
    } ?> value="/annual#list">Annual Rickies</option>
				<option <?php if (isset($rickies_filter) && $rickies_filter == 'Keynote') {
    	echo 'selected';
    } ?> value="/keynote#list">Keynote Rickies</option>
				<option <?php if (isset($rickies_filter) && $rickies_filter == 'WWDC') {
    	echo 'selected';
    } ?> value="/wwdc#list">WWDC Rickies</option>
				<option <?php if (isset($rickies_filter) && $rickies_filter == 'Ungraded') {
    	echo 'selected';
    } ?> value="/ungraded#list">Ungraded Rickies</option>
	</optgroup>
	<optgroup label="Other">
				<option <?php if (isset($rickies_filter) && $rickies_filter == 'EUies') {
    	echo 'selected';
    } ?> value="/euies">The EUies</option>
				<option <?php if (isset($rickies_filter) && $rickies_filter == 'Pickies') {
    	echo 'selected';
    } ?> value="/pickies">The Pickies</option>
			</optgroup>
		</select>
<?php if (!isset($rickies_filter)) {
	echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/buttons/button-filter.svg');
} else {
	echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/buttons/button-filter-active.svg');
} ?>
	</h2>
	<script>
		 var urlmenu = document.getElementById( 'filter_menu' );
		 urlmenu.onchange = function() {
			window.open( this.options[ this.selectedIndex ].value, '_self');
			window.goatcounter.count({
				path: 'Filter by '+this.options[ this.selectedIndex ].text,
				title: 'Filter Rickies',
				referrer: window.location.href,
				event: true,
			});
		 };
	</script>
<?php if (!isset($rickies_filter_empty)) {
	echo '<ul class="list_item_group">';
	foreach ($rickies_events__array as $event) {
		echo list_item($event);
	}
	echo '</ul>';
} else {
	echo '<p>' . $rickies_filter_empty . '</p>';
} ?>
</section>
