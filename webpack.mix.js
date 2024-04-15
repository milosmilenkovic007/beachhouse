const mix = require('laravel-mix');
require('laravel-mix-polyfill');

mix.options({
	processCssUrls: false,
});
mix
	.js('src/js/*.js', 'assets/js/main.js')
	.sass('src/sass/styles.scss', 'assets/css/')

	.options({
		postCss: [
			require('autoprefixer')({
				overrideBrowserslist: [
					'Chrome >= 60',
					'Safari >= 10.1',
					'iOS >= 10.3',
					'Firefox >= 54',
					'Edge >= 15',
					'Android >= 4',
				],
				grid: true,
			}),
		],
	})
	.sourceMaps(true, 'source-map')

	.minify(`assets/js/main.js`)
	.polyfill({
		enabled: true,
		useBuiltIns: 'usage',
		corejs: 2,
		targets: 'firefox 54',
	});
