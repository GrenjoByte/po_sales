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
				<div class="col">
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
$(function () {

    $('.overflow-tooltip').each(function () {
        var $el = $(this);
        // check if content is actually overflowing
        if (this.scrollWidth > this.clientWidth) {
            var full_text = $el.text().trim();

            $el.attr('title', full_text)
               .attr('data-bs-toggle', 'tooltip')
               .attr('data-bs-placement', 'top');

            new bootstrap.Tooltip(this);
        }
    });

});
</script>
</html>