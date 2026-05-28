<?php
if (!defined('ABSPATH')) {
	exit;
}
?>
<style>
	/* Scoped styles: do not affect existing widgets/popups */
	/*
	Sticky behavior note:
	Bootstrap modals typically scroll the modal body. To match the Elementor widget behavior
	(left nav stays visible while right side scrolls), we disable scrolling on the modal body
	for this popup only and move scrolling to the right grid column.
	*/
	#brandsPopup .modal-body { overflow: hidden; }

	#brandsPopup .brands-tech-tab-container { display: flex; gap: 80px; max-width: 100%; width: 100%;align-items: self-start; }
	#brandsPopup .brands-tech-tabs-nav { flex: 0 0 350px; align-self: flex-start; position: sticky; top: 0; background: #fff; border-radius: 8px; padding: 4px; height: fit-content; box-shadow: 0 0 15px 0 rgba(138, 149, 158, 0.40); max-height: 60vh; overflow: auto; }
	.js-dark #brandsPopup .brands-tech-tabs-nav { background: #262A30; border-color: rgba(193, 196, 198, 0.1); }
	#brandsPopup .brands-tech-tabs-nav ul { list-style: none; margin: 0; padding: 0; }
	#brandsPopup .brands-tech-tabs-nav li { margin: 0; padding: 0; }
	#brandsPopup .brands-tech-tab-btn { width: 100%; text-align: left; padding: 10px 35px; background: transparent; border: none; cursor: pointer; font-size: 16px; color: #5F6F94; border-radius: 4px; transition: all 0.3s ease; font-family: inherit; position: relative; font-weight: 500; line-height: 24px; }
	.js-dark #brandsPopup .brands-tech-tab-btn { color: #aeb6c9; }
	#brandsPopup .brands-tech-tab-btn:hover { background: rgba(255, 255, 255, 0.5); }
	#brandsPopup .brands-tech-tab-btn.active { background: #E6E6E6; color: #06283D; }
	.js-dark #brandsPopup .brands-tech-tab-btn:hover,
	.js-dark #brandsPopup .brands-tech-tab-btn.active { background: rgba(255, 255, 255, 0.15); color: #fff; }
	#brandsPopup .brands-tech-tab-btn .checkmark-svg { display: inline-block; width: 24px; height: 24px; margin-right: 6px; vertical-align: middle; fill: #06283D; }
	#brandsPopup .brands-tech-tab-btn svg { position: absolute; left: 8px; top: 10px; opacity: 0.5; }

	#brandsPopup .brands-tech-tabs-dropdown { display: none; width: 100%; padding: 12px 16px; font-size: 16px; color: #5F6F94; background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; cursor: pointer; font-family: inherit; font-weight: 500; line-height: 24px; appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%235F6F94' d='M6 9L1 4h10z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 16px center; padding-right: 40px; }
	.js-dark #brandsPopup .brands-tech-tabs-dropdown { border: 1px solid rgba(193, 196, 198, 0.1) !important; background: #262a30; color: #ccc; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23fff'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; background-size: 16px; }
	#brandsPopup .brands-tech-tabs-dropdown:focus { outline: none; border-color: #06283D; }

	#brandsPopup .brands-tech-images-grid { flex: 1; display: grid; grid-template-columns: repeat(4, 1fr); gap: 4px; background: transparent; border: none; max-height: 60vh; overflow: auto; padding-right: 2px; }
	#brandsPopup .brands-tech-image-item { background: #fff; padding: 20px; display: flex; align-items: center; justify-content: center; height: 120px; transition: opacity 0.3s ease, transform 0.3s ease; border-radius: 8px; }
	.js-dark #brandsPopup .brands-tech-image-item { background: #262A30; }

	#brandsPopup .brands-tech-image-light { display: flex; }
	.js-dark #brandsPopup .brands-tech-image-light { display: none; }
	.js-dark #brandsPopup .brands-tech-image-light.brands-tech-image-fallback { display: flex; }
	#brandsPopup .brands-tech-image-dark { display: none; }
	.js-dark #brandsPopup .brands-tech-image-dark { display: flex; }
	#brandsPopup .brands-tech-image-item.hidden { display: none !important; }
	#brandsPopup .brands-tech-image-item img { max-width: 100%; max-height: 80px; width: auto; height: auto; object-fit: contain; }

	@media (max-width: 1200px) { #brandsPopup .brands-tech-images-grid { grid-template-columns: repeat(3, 1fr); } }
	@media (max-width: 768px) {
		#brandsPopup .brands-tech-tab-container { flex-direction: column; gap: 20px; }
		#brandsPopup .brands-tech-tabs-nav { display: none; }
		#brandsPopup .brands-tech-tabs-dropdown { display: block; }
		#brandsPopup .brands-tech-images-grid { grid-template-columns: repeat(2, 1fr);  }
	}
	@media (min-width: 769px) { #brandsPopup .brands-tech-tabs-dropdown { display: none; } }
</style>

