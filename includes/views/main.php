<?php

if (isset($back_to_overview)) {
	echo back_button();
}

include $include_subbody;
include $incl_path . 'footer.php';
?>

<script>
<?php
include 'scripts/confetti.js';
if ($url_view == 'main') {
	echo 'confetti_go()';
}
?>
</script>