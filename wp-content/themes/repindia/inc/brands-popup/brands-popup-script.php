<?php
if (!defined('ABSPATH')) {
	exit;
}
?>
<script>
	(function () {
		function initBrandsPopupTabs(modalEl) {
			if (!modalEl || modalEl.dataset.brandsPopupTabsBound === '1') return;
			modalEl.dataset.brandsPopupTabsBound = '1';

			var container = modalEl.querySelector('[data-brands-popup-tabs]');
			if (!container) return;

			var tabButtons = container.querySelectorAll('.brands-tech-tab-btn');
			var imageItems = container.querySelectorAll('.brands-tech-image-item');
			var dropdown = container.querySelector('.brands-tech-tabs-dropdown');

			function setActiveTab(activeTab) {
				tabButtons.forEach(function (btn) {
					var btnText = btn.getAttribute('data-text') || btn.textContent || '';
					var isActive = btn.getAttribute('data-brand-tab') === activeTab;

					btn.classList.remove('active');
					var existingCheck = btn.querySelector('.checkmark-svg');
					if (existingCheck) existingCheck.remove();
					btn.textContent = btnText;

					if (isActive) {
						btn.classList.add('active');
						var checkmarkSVG = createCheckmarkSVG();
						btn.insertBefore(checkmarkSVG, btn.firstChild);
					}
				});

				if (dropdown) {
					dropdown.value = activeTab;
				}

				imageItems.forEach(function (item) {
					var itemTab = item.getAttribute('data-brand-tab');
					if (activeTab === 'all' || itemTab === activeTab) {
						item.classList.remove('hidden');
					} else {
						item.classList.add('hidden');
					}
				});
			}

			function createCheckmarkSVG() {
				var svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
				svg.setAttribute('class', 'checkmark-svg');
				svg.setAttribute('viewBox', '0 0 20 20');
				svg.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
				var path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
				path.setAttribute('d', 'M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z');
				path.setAttribute('fill', 'currentColor');
				svg.appendChild(path);
				return svg;
			}

			var defaultTab = 'all';
			if (defaultTab) {
				setActiveTab(defaultTab);
			}

			// Restore default tab when the popup is reset on close (global.js).
			modalEl.addEventListener('repindia:popup-reset', function () {
				setActiveTab(defaultTab);
			});

			tabButtons.forEach(function (btn) {
				btn.addEventListener('click', function () {
					var tab = this.getAttribute('data-brand-tab');
					if (tab) setActiveTab(tab);
				});
			});

			if (dropdown) {
				dropdown.addEventListener('change', function () {
					var tab = this.value;
					if (tab) setActiveTab(tab);
				});
			}
		}

		document.addEventListener('DOMContentLoaded', function () {
			var modalEl = document.getElementById('brandsPopup');
			if (!modalEl) return;

			if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
				modalEl.addEventListener('shown.bs.modal', function () {
					initBrandsPopupTabs(modalEl);
				});
			} else {
				initBrandsPopupTabs(modalEl);
			}
		});
	})();
</script>

