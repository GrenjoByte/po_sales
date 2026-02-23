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
							<i class="bi bi-box" style="font-size: 3rem;"></i>
						</div>
						<div class="card-body">
							<figure class="card-title fs-6 fw-light" role="button">
								<blockquote class="blockquote">
									<p class="text-truncate overflow-tooltip">Faber-Castell das dasd asd asd asdasd ballpen</p>
								</blockquote>
								
								<figcaption class="blockquote-footer">
									BO-001
								</figcaption>
							</figure>
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