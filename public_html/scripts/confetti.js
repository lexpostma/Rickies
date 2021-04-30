var count = 200;
var colors = ['#449934', '#FCC200', '#EF7B00', '#E51F2E', '#9D3489', '#0D87CA'];
var defaults = {
	origin: { y: 0.7 },
};

function fire(particleRatio, opts) {
	confetti(
		Object.assign({}, defaults, opts, {
			colors: colors,
			particleCount: Math.floor(count * particleRatio),
		})
	);
}

function confetti_go() {
	fire(0.25, {
		spread: 26,
		startVelocity: 55,
	});
	fire(0.2, {
		spread: 60,
	});
	fire(0.35, {
		spread: 100,
		decay: 0.91,
		scalar: 0.8,
	});
	fire(0.1, {
		spread: 120,
		startVelocity: 25,
		decay: 0.92,
		scalar: 1.2,
	});
	fire(0.1, {
		spread: 120,
		startVelocity: 45,
	});
}
