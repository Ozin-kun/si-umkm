import './bootstrap';

import Alpine from 'alpinejs';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import DataTable from 'datatables.net-dt';
import 'datatables.net-dt/css/dataTables.dataTables.css';
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import markerIcon2x from 'leaflet/dist/images/marker-icon-2x.png';
import markerIcon from 'leaflet/dist/images/marker-icon.png';
import markerShadow from 'leaflet/dist/images/marker-shadow.png';

delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
	iconRetinaUrl: markerIcon2x,
	iconUrl: markerIcon,
	shadowUrl: markerShadow,
});

window.Alpine = Alpine;
window.Swal = Swal;
window.productCatalogPage = function () {
	return {
		open: false,
		formAction: '',
		form: {
			name: '',
			price: '',
			description: '',
		},
		openModal(payload) {
			this.formAction = payload.action;
			this.form = {
				name: payload.product.name ?? '',
				price: payload.product.price ?? '',
				description: payload.product.description ?? '',
			};
			this.open = true;
			this.$nextTick(() => this.$refs.nameInput && this.$refs.nameInput.focus());
		},
		closeModal() {
			this.open = false;
		},
	};
};

window.adminCategoryPage = function () {
	return {
		open: false,
		formAction: '',
		form: {
			name: '',
			description: '',
		},
		openEditModal(payload) {
			this.formAction = payload.action;
			this.form = {
				name: payload.category.name ?? '',
				description: payload.category.description ?? '',
			};
			this.open = true;
			this.$nextTick(() => this.$refs.nameInput && this.$refs.nameInput.focus());
		},
		closeEditModal() {
			this.open = false;
		},
	};
};

window.confirmDangerousAction = async function (form, options = {}) {
	const result = await Swal.fire({
		title: options.title ?? 'Apakah Anda yakin?',
		text: options.text ?? 'Tindakan ini tidak dapat dibatalkan.',
		icon: 'warning',
		showCancelButton: true,
		confirmButtonText: options.confirmButtonText ?? 'Ya, lanjutkan',
		cancelButtonText: 'Batal',
		confirmButtonColor: options.confirmButtonColor ?? '#e11d48',
		cancelButtonColor: '#e2e8f0',
		background: '#ffffff',
		color: '#0f172a',
	});

	if (result.isConfirmed && form) {
		form.submit();
	}
};

window.confirmDeleteProduct = function (form, productName) {
	return window.confirmDangerousAction(form, {
		title: 'Hapus produk ini?',
		text: `Produk "${productName}" akan dihapus secara permanen.`,
		confirmButtonText: 'Ya, hapus',
	});
};

window.confirmDeleteCategory = function (form, categoryName) {
	return window.confirmDangerousAction(form, {
		title: 'Hapus kategori ini?',
		text: `Kategori "${categoryName}" akan dihapus secara permanen.`,
		confirmButtonText: 'Ya, hapus',
	});
};

window.initDataTables = function (root = document) {
	const tables = root.querySelectorAll('[data-datatable]');

	tables.forEach((table) => {
		if (table.dataset.initialized === 'true') {
			return;
		}

		new DataTable(table, {
			pageLength: Number(table.dataset.pageLength || 10),
			lengthChange: true,
			searching: true,
			ordering: true,
			info: true,
			language: {
				search: 'Cari:',
				lengthMenu: 'Tampilkan _MENU_ data',
				info: 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
				infoEmpty: 'Tidak ada data',
				zeroRecords: 'Data tidak ditemukan',
				paginate: {
					first: 'Awal',
					last: 'Akhir',
					next: 'Berikut',
					previous: 'Sebelumnya',
				},
			},
		});

		table.dataset.initialized = 'true';
	});
};

window.initAutoCarousels = function (root = document) {
	const carousels = root.querySelectorAll('[data-auto-carousel]');

	carousels.forEach((carousel) => {
		const track = carousel.querySelector('[data-carousel-track]');
		if (!track) {
			return;
		}

		const slides = track.children;
		if (!slides || slides.length <= 1) {
			return;
		}

		const interval = Number(carousel.getAttribute('data-interval') || 3500);
		let currentIndex = 0;

		setInterval(() => {
			currentIndex = (currentIndex + 1) % slides.length;
			track.style.transform = `translateX(-${currentIndex * 100}%)`;
		}, interval);
	});
};

window.initUmkmLocationMaps = function (root = document) {
	const mapElements = root.querySelectorAll('[data-umkm-location-map]');

	mapElements.forEach((element) => {
		if (element.dataset.initialized === 'true') {
			return;
		}

		const latInput = element.closest('form')?.querySelector('[data-coordinate-lat]');
		const lngInput = element.closest('form')?.querySelector('[data-coordinate-lng]');
		const latDisplay = element.closest('form')?.querySelector('[data-coordinate-lat-display]');
		const lngDisplay = element.closest('form')?.querySelector('[data-coordinate-lng-display]');
		const fallbackLat = Number(element.dataset.lat || -6.2000000);
		const fallbackLng = Number(element.dataset.lng || 106.8166660);
		const initialLat = Number(latInput?.value || fallbackLat);
		const initialLng = Number(lngInput?.value || fallbackLng);
		const map = L.map(element, {
			zoomControl: true,
			scrollWheelZoom: true,
		}).setView([initialLat, initialLng], 15);

		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			attribution: '&copy; OpenStreetMap contributors',
			maxZoom: 19,
		}).addTo(map);

		const marker = L.marker([initialLat, initialLng], {
			draggable: true,
		}).addTo(map);

		const syncCoordinates = (lat, lng) => {
			const fixedLat = Number(lat).toFixed(7);
			const fixedLng = Number(lng).toFixed(7);

			if (latInput) latInput.value = fixedLat;
			if (lngInput) lngInput.value = fixedLng;
			if (latDisplay) latDisplay.textContent = fixedLat;
			if (lngDisplay) lngDisplay.textContent = fixedLng;
		};

		marker.on('dragend', (event) => {
			const position = event.target.getLatLng();
			syncCoordinates(position.lat, position.lng);
		});

		map.on('click', (event) => {
			marker.setLatLng(event.latlng);
			syncCoordinates(event.latlng.lat, event.latlng.lng);
		});

		syncCoordinates(initialLat, initialLng);
		element.dataset.initialized = 'true';
	});
};

document.addEventListener('DOMContentLoaded', () => {
	window.initAutoCarousels();
	window.initUmkmLocationMaps();
	window.initDataTables();
});

Alpine.start();
