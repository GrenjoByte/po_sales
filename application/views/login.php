<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="<?php echo base_url();?>darken/shader.js"></script>
	<title>Login</title>
</head>
<?php include 'esses/notifications.php';?>
<body>
	<header>
		<?php include 'esses/nav.php';?>
	</header>
	<main>
		<div class="ui basic segment">
			<form class="ui form" enctype="multipart/form-data" id="login_form">
				<div class="ui column grid centered">
					<div class="column row centered tablet computed large screen only"></div>
					<div class="column row centered">
						<div class="sixteen wide mobile six wide tablet five wide computer six wide large screen column middle">
							
							<div class="ui center aligned very padded basic segment">
								<div class="ui center aligned padded basic segment">
									<h1 class="ui header center aligned">
										<a id="page_label">Sign In</a>
									</h1>
									<div class="field">
										<div class="ui right action input tiny fluid">
											<input type="text" value="" placeholder="Username" name="username" id="username" autocomplete="off">
											<div class="ui animated button basic mini" tabindex="-1">
												<div class="hidden content"><small>Username</small></div>
												<div class="visible content">
													<i class="lock icon teal"></i>
												</div>
											</div>
										</div>
								  	</div>
								  	<div class="field">
										<div class="ui right action input tiny fluid">
											<input type="password" value="" placeholder="Password" name="password" id="password" autocomplete="off">
											<div class="ui animated button basic mini" tabindex="-1">
												<div class="hidden content"><small>Password</small></div>
												<div class="visible content">
													<i class="key icon teal"></i>
												</div>
											</div>
										</div>
								  	</div>
								  	<div class="ui horizontal divider">
									    Or
								  	</div>
									<div class="ui center aligned basic segment">
										<div class="ui header small">
											<a href="<?php echo base_url();?>i.php/sys_control/user_registration">
												Apply for Registration
											</a>	
										</div>
								  	</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</main>
	<footer>
		<?php include 'esses/footer.php';?>
	</footer>
</body>
<script type="text/javascript">
	$(document).ready(function() {
		$('.announcements_activator').addClass('invisible');
		$('.chat_activator').addClass('invisible');
	});
	$('#login_form')
	  	.form({
	  		on: 'change',
	  		inline: true,
	    	transition: 'swing down',
	        onSuccess: function(event) {
	        	event.preventDefault();
				if($('#login_form').form('is valid')) {
					var ajax = $.ajax({
						method: 'POST',
						url   : '<?php echo base_url();?>i.php/sys_control/attempt_login',
						data  : new FormData(this),
						contentType: false,
						cache: false,
		    			processData: false
					});
					var jqxhr = ajax
						.done(function() {
							var response = JSON.parse(jqxhr.responseText);
							$.each(response, function(key, value) {
								var last_name = value.last_name.UCwords();
								var gender = value.gender;

								if (gender == 'failed') {
									icon = 'times red loading';
							  		header = 'Invalid Credentials: Login Failed';
								  	message = `
								  		The <x class="teal-text">Login Credentials</x> you entered are <x class="orange-text">Incorrect</x>.<br><br>Please try again.
								  	`;
								  	duration = 25000;
									load_notification(icon, header, message, duration, '', '', 'basic');
								}
								else if (gender == 'unregistered') {
									icon = 'spinner loading yellow';
							  		header = 'Registration Pending';
								  	message = `
								  		Your <x class="teal-text">Registration</x> is <x class="orange-text">still unapproved</x>.<br><br>Please try again later or contact the HR.
								  	`;
								  	duration = 25000;
									load_notification(icon, header, message, duration, '', '', 'basic');
								}
								else {
									if (gender == 'male') {
										gen_string = 'Mr. '+last_name;
									}
									else {
										gen_string = 'Ms. '+last_name;
									}

									icon = 'check green';
							  		header = 'Credentials Authenticated';
								  	message = `
								  		<h2>
								  			Welcome <x class="teal-text">`+gen_string+`</x>
								  		</h2>
								  		Please wait while we redirect you to your profile page.
								  	`;
								  	duration = 25000;
									load_notification(icon, header, message, duration, '', '', 'basic');
								  	setTimeout(function(){
								  		window.location.replace('<?php echo base_url();?>i.php/sys_control/user_window');
								  	}, 2500);
								}
							});
						})
						.fail(function() {
							alert("error");
						})
						.always(function() {
							
						})
					;
				}
	        },
	    	fields: {
	      		username: {
			        identifier: 'username',
			        rules: [
			          	{
			            	type   : 'empty',
			            	prompt : 'Username is required'
			          	}
			          	// },
			          	// {
			            // 	type   : 'regExp[^[a-zA-Z0-9_@.-]+$]',
			            // 	prompt : 'Should not contain special character/s'
			          	// }
			        ]
	      		},
	      		password: {
			        identifier: 'password',
			        rules: [
			          	{
			            	type   : 'empty',
			            	prompt : 'Password is required'
			          	}
			        ]
	      		}
	      	}
	  	})
	;
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