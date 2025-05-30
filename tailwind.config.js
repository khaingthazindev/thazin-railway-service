import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
	prefix: 'tw-',
	important: true,
	content: [
		'./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
		'./storage/framework/views/*.php',
		'./resources/views/**/*.blade.php',
		'./app/Http/Controllers/**/*.php',
		'./app/Models/**/*.php',
		'./app/Repositories/**/*.php',
	],

	theme: {
		extend: {
			fontFamily: {
				sans: ['Figtree', ...defaultTheme.fontFamily.sans],
			},
			backgroundImage: {
				theme: 'linear-gradient(90deg,#3CACB6 0%,#8CCEAD 90%)',
			},
			borderColor: {
				theme: '#1CBC9B',
			},
			textColor: {
				theme: '#1CBC9B',
			},
		},
	},

	plugins: [forms],
};
