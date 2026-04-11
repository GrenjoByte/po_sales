<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="<?php echo base_url();?>darken/shader.js"></script>
	<title>Login</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
		.vh-80 {
		  	height: 80vh !important;
		}
	</style>
</head>
<body>
	<header>
		<?php include 'esses/assets.php';?>
	</header>
	<main>
		<div class="container-fluid vh-80 d-flex align-items-center justify-content-center">
		    <div class="card shadow-sm p-4" style="width: 100%; max-width: 400px;">
				<h2 class="text-center mb-3">SAKI MART</h2>
		        <h2 class="text-center mb-3">Login</h2>
		        <form class="needs-validation" novalidate id="login_form">
		            <div class="mb-3">
		                <label class="form-label">Username</label>
		                <input id="username" name="username" type="text" class="form-control" placeholder="Enter username">
		            </div>
		            <div class="mb-3">
		                <label class="form-label">Password</label>
		                <input id="password" name="password" type="password" class="form-control" placeholder="Enter password">
		            </div>

		            <button type="button" class="btn btn-primary w-100" id="login_button">
		                Sign In
		            </button>
		        </form>
		    </div>
		</div>
	</main>
	<footer>
	</footer>
</body>
<script type="text/javascript">
	// $('#login_button').on('click', function() {
	// 	title = "Login Successful";
	// 	message = "Please wait while we redirect you to your user page";	
	// 	status = "success";
	// 	load_notification(title, message, status);
	// });
	$('#login_button').on('click', function() {
		attempt_login();
	})
	function attempt_login() {
		var ajax = $.ajax({
			method: 'POST',
			url   : '<?php echo base_url();?>i.php/sys_control/attempt_login',
			data  : new FormData($('#login_form')[0]),
			contentType: false,
			cache: false,
			processData: false
		});
		var jqxhr = ajax
			.done(function() {
				var response = JSON.parse(jqxhr.responseText);
		
				var status = response.status;
				var user_type = response.user_type;
				var last_name = response.last_name.UCwords();
				var gender = response.gender;

				if (status == 'success') {
					if (user_type == 1) {
						page = 'inventory';
					}
					else if (user_type == 2) {
						page = 'sales';
					}
					else if (user_type == 3) {
						alert("Unknown error. Please call the developer and refrain from using the system.")
					}
					if (gender == 'male') {
						address_text = 'Mr. '+last_name;
					}
					else if (gender == 'female') {
						address_text = 'Ms. '+last_name;
					}	
					var address_element = `
					    <span class="text-success fw-semibold">
					        ${address_text}
					    </span>
					`;

					title = "Login Successful";
					message = `Welcome ${address_element}! Please wait while we redirect you to your page.`;	
					status = "success";
					load_notification(title, message, status);
					setTimeout(function(){
				  		window.location.replace('<?php echo base_url();?>i.php/sys_control/'+page);
				  	}, 2500);
				}
				else if (status == 'error') {
					title = "Login Failed";
					message = `The login credentials you provided were invalid.`;	
					status = "error";
					load_notification(title, message, status);
				}
			})
			.fail(function() {
				alert("error");
			})
			.always(function() {
				
			})
		;
	}


















	$(document).ready(function() {
		$('.announcements_activator').addClass('invisible');
		$('.chat_activator').addClass('invisible');
	});
	$('#post_image_name')
		.on('click', function() {
		  	$('#post_image_input').trigger('click');
		  	$('#post_image_name').trigger('blur');
		})
		.on('focus', function() {
		  	$('#post_image_input').trigger('click');
		  	$('#post_image_name').trigger('blur');
		})
	;
	$('#post_image_input')
	  	.on('change', function() {
	  		var file = $('#post_image_input')[0].files[0]; 
	  		// IF IMAGE INPUT IS NOT EMPTY
	  		if (file) {
	  			$('#post_image_name').val(file.name);
	  			$('#post_image_inner')
			  		.attr('src', URL.createObjectURL(file))
				;
				$('#post_image_outer')
			  		.attr('src', URL.createObjectURL(file))
				;
	  		}
	  		else {
	  			$('#post_image_name').val(null);
		  		$('#post_image_inner')
  					.attr('src', '<?php echo base_url();?>photos/post_images/placeholder_landscape.png')
				;
				$('#post_image_outer')
  					.attr('src', '<?php echo base_url();?>photos/post_images/placeholder_landscape.png')
				;
	  		}
			$('#post_creation_form').form('validate field', 'post_image_name');
	  	})
	;
</script>
</html>