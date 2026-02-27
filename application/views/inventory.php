<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Inventory Management</title>
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
	</style>
</head>
<body>
	<header>
		<?php include 'esses/assets.php';?>
		<?php include 'esses/inventory_nav.html';?>
		<?php include 'esses/inventory_assets.html';?>
	</header>
	<main>
		<div class="container">
			<div class="row mt-3 mb-4 text-center">
				<h4>Inventory Manager</h4>
			</div>
		</div>
		<div class="container mt-4">
			<div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-4" id="pos_item_cards_container">
				<div class="col" id="item_cards">
					<div class="card h-100">
						<div class="position-relative img-hover-wrapper">
							<img src="<?php echo base_url();?>photos/pos_images/c2_apple_1l.jpg"
							class="card-img-top"
							alt="product_image"
							style="aspect-ratio:5/3;object-fit:contain;background-color:#edf1f4;">

							<!-- Dimmer overlay -->
							<div class="position-absolute top-0 start-0 w-100 h-100 hover-dimmer d-flex justify-content-center align-items-center">
								<small class="btn btn-secondary btn-sm hover-btn" role="button">
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
					</div>
				</div>
			</div>
		</div>
	</main>
	<footer>
	</footer>
</body>
<script type="text/javascript">
	$(function() {
		let current_page = 1;
		const items_per_page = 15;

		function load_items(page = 1) {
			$.ajax({
				url: '<?php echo base_url();?>i.php/sys_control/load_pos_inventory',
				method: 'POST',
				data: { page: page, limit: items_per_page },
				dataType: 'json',
				success: function(response) {
					const $container = $('#item_cards');
					$container.empty();

					if (response.items && response.items.length) {
						response.items.forEach(item => {
							pos_item_id = item.pos_item_id;
							pos_item_name = item.pos_item_name;
							pos_item_price = item.pos_item_price;
							pos_item_stock = item.pos_item_stock;
							pos_item_unit = item.pos_item_unit;


							if (pos_item_stock > 1) {
								unit_last = pos_item_unit[pos_item_unit.length - 1].toLowerCase();

								if (
									unit_last == 's' ||
									unit_last == 'h' && pos_item_unit.endsWith('sh') ||
									unit_last == 'h' && pos_item_unit.endsWith('ch') ||
									unit_last == 'x' ||
									unit_last == 'z'
									) {
									pos_item_unit = pos_item_unit + 'es';
								} else {
									pos_item_unit = pos_item_unit + 's';
								}
							}
							const card_html = `
		                        <div class="card h-100">
		                            <div class="position-relative img-hover-wrapper">
		                                <img src="<?php echo base_url();?>photos/pos_images/${item.pos_item_image}" 
		                                     class="card-img-top" 
		                                     alt="${item.pos_item_name}" 
		                                     style="aspect-ratio:5/3;object-fit:contain;background-color:#edf1f4;">

		                                <!-- Dimmer overlay -->
		                                <div class="position-absolute top-0 start-0 w-100 h-100 hover-dimmer d-flex justify-content-center align-items-center">
		                                    <small class="btn btn-secondary btn-sm hover-btn" role="button">
		                                        Modify
		                                    </small>
		                                </div>
		                            </div>
		                            <small class="card-body">
		                                <div class="card-title fs-6 text-truncate overflow-tooltip" role="button">
		                                    ${item.pos_item_name}
		                                </div>
										<small class="card-subtitle text-muted d-block text-truncate">
		                                    ${item.pos_item_code}
		                                </small>
		                                <div class="d-flex fs-6 mt-1 fw-semibold align-items-center gap-1">
		                                    <span>${item.pos_item_stock}</span>
		                                    <span>${item.pos_item_unit}</span>
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
								</div>`
							;
							$container.append(card_html);
						});
					} else {
						$container.html('<p class="text-center">No items found.</p>');
					}

            // Update page info
					const total_pages = Math.ceil(response.total / items_per_page);
					$('#page_info').text(`Page ${page} of ${total_pages}`);

            // Disable buttons if needed
					$('#prev_page').prop('disabled', page <= 1);
					$('#next_page').prop('disabled', page >= total_pages);
				},
				error: function() {
					$('#item_cards').html('<p class="text-center text-danger">Failed to load items.</p>');
				}
			});
		}

		load_items(current_page);

		$('#prev_page').click(function() {
			if (current_page > 1) {
				current_page--;
				load_items(current_page);
			}
		});

		$('#next_page').click(function() {
			current_page++;
			load_items(current_page);
		});
	});
</script>
</html>