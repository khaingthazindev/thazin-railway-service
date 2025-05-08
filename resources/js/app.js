import './bootstrap';

import Alpine from 'alpinejs';
import Swal from 'sweetalert2/dist/sweetalert2.js';

window.Alpine = Alpine;
window.Swal = Swal;

window.deleteDialog = Swal.mixin({
	title: 'Are you sure, you want to delete?',
	text: '',
	icon: 'error',
	customClass: {
		confirmButton: 'btn btn-danger',
		cancelButton: 'btn btn-secondary mr-2',
	},
	buttonsStyling: false,
	showCancelButton: true,
	confirmButtonText: 'Confirm',
	cancelButtonText: 'Cancel',
	reverseButtons: true,
});

Alpine.start();
