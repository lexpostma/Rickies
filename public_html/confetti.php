<html>
	<head>
		<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.4.0/dist/confetti.browser.min.js"></script>
	</head>
	<body>
		<div onclick="confetti_go()" style="width: 100vw; height: 100vh"></div>
		<script>
			<? include("scripts/confetti.js")?>
			document.addEventListener('DOMContentLoaded', function (event) {
				confetti_go()
			});
		</script>
	</body>
</html>

