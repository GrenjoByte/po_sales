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
	</header>
	<main>
		<?php include 'esses/assets.php';?>
		<div class="container-fluid vh-80 d-flex align-items-center justify-content-center">
		    <div class="card shadow-sm p-4" style="width: 100%; max-width: 400px;">
		        <h2 class="text-center mb-3">Login</h2>

		        <form>
		            <div class="mb-3">
		                <label class="form-label">Username</label>
		                <input type="text" class="form-control" placeholder="Enter username">
		            </div>

		            <div class="mb-3">
		                <label class="form-label">Password</label>
		                <input type="password" class="form-control" placeholder="Enter password">
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
	$('#login_button').on('click', function() {
		title = "Login Successful";
		message = "Please wait while we redirect you to your user page";	
		load_notification(title, message);
	});
	$(document).ready(function() {
		$('.announcements_activator').addClass('invisible');
		$('.chat_activator').addClass('invisible');
	});
	// $('#login_form')
	//   	.form({
	//   		on: 'change',
	//   		inline: true,
	//     	transition: 'swing down',
	//         onSuccess: function(event) {
	//         	event.preventDefault();
	// 			if($('#login_form').form('is valid')) {
	// 				var ajax = $.ajax({
	// 					method: 'POST',
	// 					url   : '<?php echo base_url();?>i.php/sys_control/attempt_login',
	// 					data  : new FormData(this),
	// 					contentType: false,
	// 					cache: false,
	// 	    			processData: false
	// 				});
	// 				var jqxhr = ajax
	// 					.done(function() {
	// 						var response = JSON.parse(jqxhr.responseText);
	// 						$.each(response, function(key, value) {
	// 							var last_name = value.last_name.UCwords();
	// 							var gender = value.gender;

	// 							if (gender == 'failed') {
	// 								icon = 'times red loading';
	// 						  		header = 'Invalid Credentials: Login Failed';
	// 							  	message = `
	// 							  		The <x class="teal-text">Login Credentials</x> you entered are <x class="orange-text">Incorrect</x>.<br><br>Please try again.
	// 							  	`;
	// 							  	duration = 25000;
	// 								load_notification(icon, header, message, duration, '', '', 'basic');
	// 							}
	// 							else if (gender == 'unregistered') {
	// 								icon = 'spinner loading yellow';
	// 						  		header = 'Registration Pending';
	// 							  	message = `
	// 							  		Your <x class="teal-text">Registration</x> is <x class="orange-text">still unapproved</x>.<br><br>Please try again later or contact the HR.
	// 							  	`;
	// 							  	duration = 25000;
	// 								load_notification(icon, header, message, duration, '', '', 'basic');
	// 							}
	// 							else {
	// 								if (gender == 'male') {
	// 									gen_string = 'Mr. '+last_name;
	// 								}
	// 								else {
	// 									gen_string = 'Ms. '+last_name;
	// 								}

	// 								icon = 'check green';
	// 						  		header = 'Credentials Authenticated';
	// 							  	message = `
	// 							  		<h2>
	// 							  			Welcome <x class="teal-text">`+gen_string+`</x>
	// 							  		</h2>
	// 							  		Please wait while we redirect you to your profile page.
	// 							  	`;
	// 							  	duration = 25000;
	// 								load_notification(icon, header, message, duration, '', '', 'basic');
	// 							  	setTimeout(function(){
	// 							  		window.location.replace('<?php echo base_url();?>i.php/sys_control/user_window');
	// 							  	}, 2500);
	// 							}
	// 						});
	// 					})
	// 					.fail(function() {
	// 						alert("error");
	// 					})
	// 					.always(function() {
							
	// 					})
	// 				;
	// 			}
	//         },
	//     	fields: {
	//       		username: {
	// 		        identifier: 'username',
	// 		        rules: [
	// 		          	{
	// 		            	type   : 'empty',
	// 		            	prompt : 'Username is required'
	// 		          	}
	// 		          	// },
	// 		          	// {
	// 		            // 	type   : 'regExp[^[a-zA-Z0-9_@.-]+$]',
	// 		            // 	prompt : 'Should not contain special character/s'
	// 		          	// }
	// 		        ]
	//       		},
	//       		password: {
	// 		        identifier: 'password',
	// 		        rules: [
	// 		          	{
	// 		            	type   : 'empty',
	// 		            	prompt : 'Password is required'
	// 		          	}
	// 		        ]
	//       		}
	//       	}
	//   	})
	// ;
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