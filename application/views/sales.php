<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>PO Sales</title>
	<style>
		.img-hover-wrapper .hover-dimmer {
			background-color: rgba(0,0,0,0); /* fully transparent initially */
			backdrop-filter: blur(0px);
			-webkit-backdrop-filter: blur(0px);
			transition: all .2s ease-in-out;
		}

		.img-hover-wrapper:hover .hover-dimmer {
			background-color: rgba(0,0,0,0.35); /* dimmer color */
			backdrop-filter: blur(1px);
			-webkit-backdrop-filter: blur(1px);
		}

		.img-hover-wrapper .hover-btn {
			opacity: 0;
			transform: scale(0.9);
			transition: all .2s ease-in-out;
		}

		.img-hover-wrapper:hover .hover-btn {
			opacity: 1;
			transform: scale(1);
		}
		.btn-sm {
			padding: .25rem .5rem !important;
			font-size: .75rem !important;
		}
	</style>
</head>
<body>
	<header>
		<?php include 'esses/assets.php';?>
		<?php include 'esses/sales_nav.html';?>
		<?php include 'esses/sales_assets.html';?>
	</header>
	<main>
		<div class="container">
			<div class="row mt-3 mb-4 text-center">
				<h4>Sales</h4>
			</div>
		</div>
		<div class="container mt-4">
			<!-- <svg id="barcode"></svg> -->
			<div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-4" id="pos_item_cards_container">
					<!-- <div class="card h-100 p2">
						<div class="position-relative img-hover-wrapper">
							<img src="<?php echo base_url();?>photos/pos_images/c2_apple_1l.jpg"
							class="card-img-top"
							alt="product_image"
							style="aspect-ratio:5/3;object-fit:contain;background-color:#edf1f4;">

							<div class="position-absolute top-0 start-0 w-100 h-100 hover-dimmer d-flex justify-content-center align-items-center">
								<small class="btn btn-secondary btn-sm hover-btn pos_item_update_activator" role="button">
									Modify
								</small>
							</div>
						</div>
						<small class="card-body">
							<div class="card-title fs-6 text-truncate overflow-tooltip" role="button">
								Faber-Castell das dasd asd asd asdasd ballpen
							</div>
							<small class="card-subtitle text-muted d-block text-truncate">
								BO-001
							</small>
							<div class="d-flex fs-6 mt-1 fw-semibold align-items-center gap-2">
								<span>20</span>
								<span>pcs</span>
							</div>
						</small>
						<div class="card-footer">
							<div class="d-flex justify-content-start align-items-center">
								<button class="bi bi-dash mx-1 fs-5 btn p-0 border-0 bg-transparent" role="button"></button>
								<small contenteditable class="px-2">0</small>
								<button class="bi bi-plus ms-1 fs-5 btn p-0 border-0 bg-transparent" role="button"></button>	
								<button class="bi bi-cart-plus ms-auto fs-5 btn p-0 border-0 bg-transparent" role="button"></button>
							</div>
						</div>
					</div> -->
				</div>
			</div>
		</div>
	</main>
	<footer>
	</footer>
<script type="text/javascript">
    // const value = "ABC123456"; // your characters here

    // JsBarcode("#barcode", value, {
    //     format: "CODE128", // supports letters + numbers
    //     width: 2,
    //     height: 80,
    //     displayValue: true
    // });
	$(function() {
		$('.pos_count_minus, .pos_count_plus').on('click', function() {
			let container = $(this).siblings('.pos_count_container');
			let item_count = Number(container.attr('data-text'));
			let max_limit = Number(container.attr('data-max_limit'));
						// let max_limit = pos_item_stock;
			let card = $(this).closest('.card');
			let stock_el = card.find('.pos_item_stock').first();
			let current_stock = Number(stock_el.text());

			let unit_el = card.find('.pos_item_unit').first();
			let current_unit = unit_el.text();
			let add_button = card.find('.add_to_pos_cart');

			if ($(this).hasClass('pos_count_plus')) {
				if (item_count < max_limit && current_stock > 0) {
					item_count++;
					current_stock--;
				}
			} else {
				if (item_count > 0) {
					item_count--;
					current_stock++;
				}
			}

			container.attr('data-text', item_count);
			stock_el.text(current_stock);
			item_count > 0 ? add_button.removeClass('invisible') : add_button.addClass('invisible');

			if (current_unit.endsWith('es')) {
				if (/(sh|ch|x|z|s)es$/.test(current_unit)) {
					current_unit = current_unit.slice(0, -2);
				} else if (!current_unit.endsWith('ses')) {
					current_unit = current_unit.slice(0, -1);
				}
			} else if (current_unit.endsWith('s')) {
				if (!current_unit.endsWith('ss')) {
					current_unit = current_unit.slice(0, -1);
				}
			}

			if (current_stock != 1) {
				unit_last = current_unit[current_unit.length - 1].toLowerCase();
				if (
				    unit_last == 's' ||
				    unit_last == 'h' && current_unit.endsWith('sh') ||
				    unit_last == 'h' && current_unit.endsWith('ch') ||
				    unit_last == 'x' ||
				    unit_last == 'z'
				    ) {
						current_unit = current_unit + 'es';
				} 
				else {
					current_unit = current_unit + 's';
				}
			} 
			else {
				if (current_unit.endsWith('es')) {
					current_unit = current_unit.slice(0, -2);
				} 
				else if (current_unit.endsWith('s')) {
					current_unit = current_unit.slice(0, -1);
				}
			}
			unit_el.text(current_unit);
		});

		$(document).on('click', '.pos_item_update_activator', function (e) {
			e.preventDefault();

			let pos_item_id = $(this)
	        	.closest('.card')
	        	.data('pos_item_id');
			load_pos_item_form(pos_item_id);
		});
		$(document).on('click', '.pos_item_barcodes_activator', function (e) {
			e.preventDefault();

			const item_id = $(this).data('id');
			const modal_el = document.getElementById('pos_item_barcodes_modal');
			const modal_instance = bootstrap.Modal.getOrCreateInstance(modal_el);
			modal_instance.show();
		});
   	});
</script>
</body>
</html>