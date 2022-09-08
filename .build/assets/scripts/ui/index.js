import './fancybox';

// Load script if svh is not supported natively
if (!CSS.supports || !CSS.supports('height', '1svh')) {
	let script = document.createElement('script');
	script.setAttribute(
		'src',
		`${sht_theme.directory_uri}/assets/scripts/svh.min.js?version=${sht_theme.version}`
	);
	document.head.appendChild(script);
}

if (!!document.querySelector('.c-masthead')) {
	let script = document.createElement('script');
	script.setAttribute(
		'src',
		`${sht_theme.directory_uri}/assets/scripts/masthead.min.js?version=${sht_theme.version}`
	);
	document.head.appendChild(script);
}
