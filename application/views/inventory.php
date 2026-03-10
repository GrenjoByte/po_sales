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
		.btn-sm {
			padding: .25rem .5rem !important;
			font-size: .75rem !important;
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
		
		const pos_items = {};

		let current_page = 1;
		const items_per_page = 15;

		function load_items(page = 1) {
			$.ajax({
				url: '<?php echo base_url();?>i.php/sys_control/load_pos_inventory',
				method: 'POST',
				data: { page: page, limit: items_per_page },
				dataType: 'json',
				success: function(response) {
					const $container = $('#pos_item_cards_container');
					$container.empty();

					if (response.items && response.items.length) {
						response.items.forEach(item => {
							pos_items[item.pos_item_id] = item;

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
								<div class="col" id="item_cards">
			                        <div class="card h-100" data-pos_item_id="${[pos_item_id]}"> 
			                            <div class="position-relative img-hover-wrapper">
			                                <img src="<?php echo base_url();?>photos/pos_images/${item.pos_item_image}" 
			                                     class="card-img-top" 
			                                     alt="${item.pos_item_name}" 
			                                     style="aspect-ratio:5/3;object-fit:contain;background-color:white;">

			                                <div class="position-absolute top-0 start-0 w-100 h-100 hover-dimmer d-flex justify-content-center align-items-center">
												<div class="btn-group-vertical" role="group" aria-label="Vertical button group">
				                                    <button type=button class="btn btn-success btn-sm hover-btn pos_item_update_activator" role="button">
				                                        Modify
				                                    </button type=button>
													<button type=button class="btn btn-primary btn-sm hover-btn pos_item_barcodes_activator" role="button">
				                                        Barcodes
				                                    </button type=button>
												</div>
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
			                                    <button class="pos_count_minus bi bi-dash mx-1 fs-5 btn p-0 border-0 bg-transparent" role="button"></button>
			                                    <small contenteditable class="px-2">0</small>
			                                    <button class="pos_count_plus bi bi-plus ms-1 fs-5 btn p-0 border-0 bg-transparent" role="button"></button>    
			                                    <button class="bi bi-cart-plus ms-auto fs-5 btn p-0 border-0 bg-transparent" role="button"></button>
			                                </div>
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

		function ret_pos_item(pos_item_id, update = false) {
			const item = pos_items[pos_item_id];
			if (!item) return console.warn(`Item ${pos_item_id} not found.`), null;

			if (update) {
				const $card = $(`#pos_item_cards_container .card[data-pos_item_id='${pos_item_id}']`);
				if ($card.length) {
					const $spans = $card.find('.card-body span');

					$spans.eq(0).text(item.pos_item_stock);

					let unit = item.pos_item_unit;
					if (item.pos_item_stock > 1) {
						const last = unit.slice(-1).toLowerCase();
						if (['s','x','z'].includes(last) || unit.endsWith('sh') || unit.endsWith('ch')) {
							unit += 'es';
						} else {
							unit += 's';
						}
					}
					$spans.eq(1).text(unit);

					$card.find('small[contenteditable]').text(item.pos_item_qty || 0);

					if (item.pos_item_stock <= item.pos_item_low) {
						$card.addClass('border-danger');
					} else {
						$card.removeClass('border-danger');
					}

					if (item.pos_item_status != 1) {
						$card.addClass('opacity-50').find('button, [contenteditable]').prop('disabled', true);
					} else {
						$card.removeClass('opacity-50').find('button, [contenteditable]').prop('disabled', false);
					}
				}
			}
			return item;
		}

		function load_pos_item_form(pos_item_id) {
			const item = pos_items[pos_item_id];
			if (!item) return console.warn(`Item ${pos_item_id} not found.`);

			$('#update_pos_item_name').val(item.pos_item_name);
			$('#update_pos_item_code').val(item.pos_item_code);
			// $('#update_pos_item_image').val(item.pos_item_image);
			$('#update_pos_item_price').val(item.pos_item_price);
			$('#update_pos_item_stock').val(item.pos_item_stock);
			$('#update_pos_item_unit').val(item.pos_item_unit);
			$('#update_pos_item_low').val(item.pos_item_low);

			if (item.pos_item_image !== "") {
				image_url = "<?php echo base_url();?>photos/pos_images/"+item.pos_item_image;
				$("#update_pos_item_image_preview").attr("src", image_url);
				$('#update_pos_item_image_preview').removeClass('d-none');
			}
			else {
				$("#update_pos_item_image_preview").attr("src", "");
				$('#update_pos_item_image_preview').removeClass('d-none');
			}

			$('#update_pos_item_modal').modal('show');
		}

		$('#update_pos_item_image').on('change', function () {
			const file = this.files[0];
			const preview = $('#update_pos_item_image_preview');

			if (file) {
				const reader = new FileReader();
				reader.onload = function (e) {
					preview.attr('src', e.target.result).removeClass('d-none');
				};
				reader.readAsDataURL(file);
			}
			else {
				preview.attr('src','').addClass('d-none');
			}
		});

		let camera_stream = null;

		// File selection
		$('#update_pos_item_image').on('change', function() {
		    const file = this.files[0];
		    const preview = $('#update_pos_item_image_preview');
		    const video = $('#camera_stream');
		    const placeholder = $('#update_pos_item_image_placeholder');

		    if (file) {
		        const reader = new FileReader();
		        reader.onload = function(e) {
		            preview.attr('src', e.target.result).removeClass('d-none');
		            video.addClass('d-none');
		            $('#take_photo_btn').addClass('d-none');
		            placeholder.hide();
		            stop_camera();
		        };
		        reader.readAsDataURL(file);
		    } else {
		        preview.attr('src', '').addClass('d-none');
		        placeholder.show();
		    }
		});

		// Open camera
		$('#capture_image_btn').on('click', async function() {
		    try {
		        stop_camera();

		        camera_stream = await navigator.mediaDevices.getUserMedia({
		            video: { facingMode: "user" },
		            audio: false
		        });

		        const video = $('#camera_stream').get(0);
		        video.srcObject = camera_stream;
		        video.play();

		        $('#camera_stream').removeClass('d-none');
		        $('#take_photo_btn').removeClass('d-none');
		        $('#update_pos_item_image_preview').addClass('d-none');
		        $('#update_pos_item_image_placeholder').hide();

		    } catch (err) {
		        console.error(err);
		        alert("Camera not available or permission denied.");
		    }
		});

		// Take photo
		$('#take_photo_btn').on('click', function() {
		    const video = $('#camera_stream').get(0);
		    const canvas = document.createElement('canvas'); // temporary canvas
		    const preview = $('#update_pos_item_image_preview');

		    canvas.width = video.videoWidth;
		    canvas.height = video.videoHeight;

		    const ctx = canvas.getContext('2d');
		    ctx.drawImage(video, 0, 0);

		    const data = canvas.toDataURL('image/png');

		    preview.attr('src', data).removeClass('d-none');

		    $('#camera_stream').addClass('d-none');
		    $('#take_photo_btn').addClass('d-none');

		    stop_camera();
		});

		// Stop camera helper
		function stop_camera() {
		    if (camera_stream) {
		        camera_stream.getTracks().forEach(track => track.stop());
		        camera_stream = null;
		    }
		}
	});

</script>
</body>
</html>