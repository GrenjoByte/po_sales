<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Inventory Management</title>
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
						<div class="card-header d-flex justify-content-center align-items-center" style="height: 120px;">
							<i class="bi bi-box" role="button" style="font-size: 3rem;"></i>
						</div>
						<small class="card-body">
							<div class="card-title fs-6 text-truncate overflow-tooltip" role="button">
								Faber-Castell das dasd asd asd asdasd ballpen
							</div>
							<small class="card-subtitle text-muted d-block text-truncate">
								Item Code: BO-001
							</small>
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