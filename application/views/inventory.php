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
			<div class="row mt-3 mb-2 text-center">
				<h4>Inventory</h4>
			</div>
		</div>
		<div class="container mt-4">
		    <div class="d-flex justify-content-center align-items-center gap-3 mt-3 mb-4">
		        <button id="prev_page" class="btn btn-outline-secondary btn-sm">
		            <i class="bi bi-chevron-left"></i>
		        </button>
		        <span id="page_info" class="text-muted small fw-medium"></span>
		        <button id="next_page" class="btn btn-outline-primary btn-sm">
		            <i class="bi bi-chevron-right"></i>
		        </button>
		    </div>
		    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-4" id="pos_item_cards_container"></div>
		</div>
		<div class="mt-5"></div>
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
	
</script>
</body>
</html>