// If it's a webapp, open links inside webapp instead of Safari
// Via https://stackoverflow.com/a/8173161

(function (element, userAgent, userAgentVar) {
	if (userAgentVar in userAgent && userAgent[userAgentVar]) {
		var d,
			elementLocation = element.location,
			f = /^(a|html)$/i;

		element.addEventListener(
			'click',
			function (element) {
				elementTarget = element.target;
				while (!f.test(elementTarget.nodeName)) elementTarget = elementTarget.parentNode;

				// links with target="_blank" should still open in Safari
				var newTabLink = elementTarget.attributes.getNamedItem('target');
				if (newTabLink && newTabLink.value == '_blank') return;

				// links that start with # in href should have default behaviour
				var anchorLink = elementTarget.attributes.getNamedItem('href');
				if (anchorLink && anchorLink.value.startsWith('#')) return;

				'href' in elementTarget &&
					(elementTarget.href.indexOf('http') || ~elementTarget.href.indexOf(elementLocation.host)) &&
					(element.preventDefault(), (elementLocation.href = elementTarget.href));
			},
			!1
		);
	}
})(document, window.navigator, 'standalone');
