// Play theme music
// Via https://stackoverflow.com/a/44361533
document.getElementById('music_button').addEventListener('click', function () {
	var audio = document.getElementById('theme_music');
	if (this.classList.contains('is-playing')) {
		this.classList.remove('is-playing');
		this.title = 'Play theme music for The Bill of Rickies';
		audio.pause();
	} else {
		this.classList.add('is-playing');
		this.title = 'Pause theme music for The Bill of Rickies';
		audio.play();
	}
});
