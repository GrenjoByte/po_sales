<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-zoom=1">
	<title>HR Registration</title>
</head>
<?php include 'esses/notifications.php';?>
<body>
	<header>
		<?php include 'esses/nav.php';?>
	</header>
	<main>
		<br>
		<form class="ui form" enctype="multipart/form-data" id="registration_form">
			<div class="ui padded grid centered">
				<div class="fourteen wide mobile ten wide tablet six wide computer column">
					<h2 class="ui header center aligned pointered" id="page_label">
						<a>User Registration</a>
					</h2>
					<div class="ui segments">
						<div class="ui padded segment">
							<h3 class="ui header" align="center">Personal Information</h3>
							<div class="two fields">
								<div class="field">
									<div class="ui left action input mini fluid">
										<div class="ui animated button basic mini" tabindex="-1">
											<div class="hidden content"><small>First Name</small></div>
											<div class="visible content">
												&emsp;<i class="right icon large"><small><b>FN</b></small></i>&emsp;
											</div>
										</div>
										<input type="text" value="" placeholder="First Name" name="first_name" id="first_name">
									</div>
							  	</div>
							  	<div class="field">
									<div class="ui left action input mini fluid">
										<div class="ui animated button basic mini" tabindex="-1">
											<div class="hidden content"><small>Middle Name</small></div>
											<div class="visible content">
												&emsp;<i class="right icon large"><small><b>MN</b></small></i>&emsp;
											</div>
										</div>
										<input type="text" value="" placeholder="Middle Name" name="middle_name" id="middle_name">
									</div>
							  	</div>
							</div>
							<div class="two fields">
							  	<div class="field">
									<div class="ui left action input mini fluid">
										<div class="ui animated button basic mini" tabindex="-1">
											<div class="hidden content"><small>Last Name</small></div>
											<div class="visible content">
												&emsp;<i class="right icon large"><small><b>LN</b></small></i>&emsp;
											</div>
										</div>
										<input type="text" value="" placeholder="Last Name" name="last_name" id="last_name">
									</div>
							  	</div>
							  	<div class="field">
									<div class="ui left action input mini fluid">
										<div class="ui animated button basic mini" tabindex="-1">
											<div class="hidden content"><small>Suffix</small></div>
											<div class="visible content">
												&emsp;<i class="right icon large"><small><b>Sfx</b></small></i>&emsp;
											</div>
										</div>
										<input type="text" value="" placeholder="Suffix" name="suffix" id="suffix">
									</div>
							  	</div>
							</div>
							<div class="two fields">
								<div class="field">
							      	<div class="ui icon selection dropdown button basic small" id="gender_drop">
							          	&emsp;<i class="venus mars icon"></i>&emsp;
							          	<input type="hidden" name="gender" id="gender">
							          	<div class="default text">Gender</div>
							          	<div class="menu">
							              	<div class="item" data-value="male">
							              		Male
							              		<i class="mars icon"></i>
							              	</div>
							              	<div class="item" data-value="female">
							              		Female
							              		<i class="venus icon"></i>
							              	</div>
							          	</div>
							      	</div>
							  	</div>
							  	<div class="field">
									<div class="ui left action input mini fluid">
										<div class="ui animated button basic mini" tabindex="-1">
											<div class="hidden content"><small>Birthdate</small></div>
											<div class="visible content">
												&emsp;<i class="calendar check outline right icon large"></i>&emsp;
											</div>
										</div>
									  	<input type="date" value="" name="birthdate" id="birthdate">
									</div>
							  	</div>
							</div>
							<br>
							<div class="two fields">
								<div class="field">
									<div class="ui left action input mini fluid">
										<div class="ui animated button basic mini" tabindex="-1">
											<div class="hidden content"><small>Position</small></div>
											<div class="visible content">
												&emsp;<i class="right address card icon large"></i>&emsp;
											</div>
										</div>
										<input type="text" value="" placeholder="Position" name="position" id="position">
									</div>
							  	</div>
							  	<div class="field">
									<div class="ui left action input mini fluid">
										<div class="ui animated button basic mini" tabindex="-1">
											<div class="hidden content"><small>Phone Number</small></div>
											<div class="visible content">
												&emsp;<i class="right mobile alternate icon large"></i></i>&emsp;
											</div>   
										</div>
										<input type="tel" value="" placeholder="Phone Number" name="phone_number" id="phone_number" maxlength="11">
									</div>
							  	</div>
							</div>
							<div class="two fields">
								<div class="field">
									<div class="ui left action input mini fluid">
										<div class="ui animated button basic mini" tabindex="-1">
											<div class="hidden content"><small>TIN Number</small></div>
											<div class="visible content">
												&emsp;<i class="right icon large"><small><b>TIN</b></small></i>&emsp;
											</div>
										</div>
										<input type="tel" value="" placeholder="TIN Number" name="tin_number" id="tin_number" maxlength="17">
									</div>
							  	</div>
							  	<div class="field">
									<div class="ui left action input mini fluid">
										<div class="ui animated button basic mini" tabindex="-1">
											<div class="hidden content"><small>LBP Account</small></div>
											<div class="visible content">
												&emsp;<i class="right icon large"><small><b>LBP</b></small></i></i>&emsp;
											</div>
										</div>
										<input type="tel" value="" placeholder="LBP Account Number" name="lbp_account" id="lbp_account" maxlength="12">
									</div>
							  	</div>
							</div>
							<h5 align="center">Complete Address</h5>
							<div class="two fields">
								<div class="field">
									<div class="ui left action input mini fluid">
										<div class="ui animated button basic mini" tabindex="-1">
											<div class="hidden content"><small>Purok/Street</small></div>
											<div class="visible content">
												&emsp;<i class="right road icon large"></i>&emsp;
											</div>
										</div>
										<input type="text" value="" placeholder="Purok/Street" name="purok_street" id="purok_street">
									</div>
							  	</div>
							  	<div class="field">
							  		<div class="ui left action input mini fluid">
										<div class="ui animated button basic mini" tabindex="-1">
											<div class="hidden content"><small>Barangay</small></div>
											<div class="visible content">
												&emsp;<i class="right map signs icon large"></i>&emsp;
											</div>
										</div>
										<input type="text" value="" placeholder="Barangay" name="barangay" id="barangay">
									</div>
							  	</div>
							</div>
							<div class="two fields">
								<div class="field">
									<div class="ui left action input mini fluid">
										<div class="ui animated button basic mini" tabindex="-1">
											<div class="hidden content"><small>Complete Address</small></div>
											<div class="visible content">
												&emsp;<i class="right university icon large"></i>&emsp;
											</div>
										</div>
										<input type="text" value="" placeholder="City/Municipality" name="city_municipality" id="city_municipality">
									</div>
							  	</div>
							  	<div class="field">
									<div class="ui left action input mini fluid">
										<div class="ui animated button basic mini" tabindex="-1">
											<div class="hidden content"><small>Province</small></div>
											<div class="visible content">
												&emsp;<i class="right map outline icon large"></i>&emsp;
											</div>
										</div>
										<input type="text" value="" placeholder="Province" name="province" id="province">
									</div>
							  	</div>
							</div>
							<div class="two fields centered">
								<div class="eight field center aligned">
									<div class="ui left action input mini fluid">
										<div class="ui animated button basic mini" tabindex="-1">
											<div class="hidden content"><small>ZIP Code</small></div>
											<div class="visible content">
												&emsp;<i class="right icon large"><small><b>ZIP</b></small></i>&emsp;
											</div>
										</div>
										<input type="text" value="" placeholder="ZIP Code" name="zip_code" id="zip_code">
									</div>
							  	</div>	
							</div>
						</div>
						<div class="ui padded segment">
							<h3 align="center">Emergency Contact Information</h3>
							<div class="field">
								<div class="ui left action input mini fluid">
									<div class="ui animated button basic mini" tabindex="-1">
										<div class="hidden content"><small>Contact Name</small></div>
										<div class="visible content">
											&emsp;<i class="right user circle outline icon large"></i>&emsp;
										</div>
									</div>
									<input type="text" value="" placeholder="Contact Name" name="ec_name" id="ec_name">
								</div>
						  	</div>
							<div class="two fields">
							  	<div class="field">
									<div class="ui left action input mini fluid">
										<div class="ui animated button basic mini" tabindex="-1">
											<div class="hidden content"><small>Relationship</small></div>
											<div class="visible content">
												&emsp;<i class="right id badge outline icon large"></i>&emsp;
											</div>
										</div>
										<input type="text" value="" placeholder="Relationship" name="ec_relationship" id="ec_relationship">
									</div>
							  	</div>	
							  	<div class="field">
									<div class="ui left action input mini fluid">
										<div class="ui animated button basic mini" tabindex="-1">
											<div class="hidden content"><small>Phone Number</small></div>
											<div class="visible content">
												&emsp;<i class="right mobile alternate icon large"></i></i>&emsp;
											</div>
										</div>
										<input type="tel" value="" placeholder="Contact's Phone Number" name="ec_phone_number" id="ec_phone_number" maxlength="11">
									</div>
							  	</div>
							</div>
							<h5 align="center">Contact's Complete Address</h5>
							<div class="field centered">
								&emsp;
						    	<div class="ui checkbox">
						      		<input type="checkbox" index="0" id="same_address_check">
						      		<label>Same as Employee's Complete Address</label>
						    	</div>
						  	</div>
							<div class="two fields">
								<div class="field">
									<div class="ui left action input mini fluid">
										<div class="ui animated button basic mini" tabindex="-1">
											<div class="hidden content"><small>Purok/Street</small></div>
											<div class="visible content">
												&emsp;<i class="right road icon large"></i>&emsp;
											</div>
										</div>
										<input type="text" value="" placeholder="Purok/Street" name="ec_purok_street" id="ec_purok_street">
									</div>
							  	</div>
							  	<div class="field">
							  		<div class="ui left action input mini fluid">
										<div class="ui animated button basic mini" tabindex="-1">
											<div class="hidden content"><small>Barangay</small></div>
											<div class="visible content">
												&emsp;<i class="right map signs icon large"></i>&emsp;
											</div>
										</div>
										<input type="text" value="" placeholder="Barangay" name="ec_barangay" id="ec_barangay">
									</div>
							  	</div>
							</div>
							<div class="two fields">
								<div class="field">
									<div class="ui left action input mini fluid">
										<div class="ui animated button basic mini" tabindex="-1">
											<div class="hidden content"><small>Complete Address</small></div>
											<div class="visible content">
												&emsp;<i class="right university icon large"></i>&emsp;
											</div>
										</div>
										<input type="text" value="" placeholder="City/Municipality" name="ec_city_municipality" id="ec_city_municipality">
									</div>
							  	</div>
							  	<div class="field">
									<div class="ui left action input mini fluid">
										<div class="ui animated button basic mini" tabindex="-1">
											<div class="hidden content"><small>Province</small></div>
											<div class="visible content">
												&emsp;<i class="right map outline icon large"></i>&emsp;
											</div>
										</div>
										<input type="text" value="" placeholder="Province" name="ec_province" id="ec_province">
									</div>
							  	</div>
							</div>
							<div class="two fields centered">
								<div class="eight field center aligned">
									<div class="ui left action input mini fluid">
										<div class="ui animated button basic mini" tabindex="-1">
											<div class="hidden content"><small>ZIP Code</small></div>
											<div class="visible content">
												&emsp;<i class="right icon large"><small><b>ZIP</b></small></i>&emsp;
											</div>
										</div>
										<input type="text" value="" placeholder="ZIP Code" name="ec_zip_code" id="ec_zip_code">
									</div>
							  	</div>	
							</div>
						</div>
						<div class="ui padded segment">
							<h3 align="center">Account Information</h3>
							<div class="two fields">
								<div class="field">
									<div class="ui left action input mini fluid">
										<div class="ui animated button basic mini" tabindex="-1">
											<div class="hidden content"><small>Email</small></div>
											<div class="visible content">
												&emsp;<i class="right envelope icon large"></i>&emsp;
											</div>
										</div>
										<input type="email" value="" placeholder="Email Address" name="email_address" id="email_address">
									</div>
							  	</div>
							  	<div class="field">
									<div class="ui left action input mini fluid">
										<div class="ui animated button basic mini" tabindex="-1">
											<div class="hidden content"><small>Verify Email</small></div>
											<div class="visible content">
												&emsp;<i class="right check circle outline icon large"></i>&emsp;
											</div>
										</div>
										<input type="email" value="" placeholder="Verify Email Address" name="verify_email_address" id="verify_email_address">
									</div>
							  	</div>	
							</div>
						  	<br>
						  	<div class="two fields">
						  		<div class="field">
									<div class="ui left action input mini fluid">
										<div class="ui animated button basic mini" tabindex="-1">
											<div class="hidden content"><small>Username</small></div>
											<div class="visible content">
												&emsp;<i class="right slack hash icon large"></i>&emsp;
											</div>
										</div>
										<input type="text" disabled value="" placeholder="Username" name="username" id="username">
									</div>
							  	</div>
							  	<div class="field">
									<div class="ui left action input mini fluid">
										<div class="ui animated button basic mini" tabindex="-1">
											<div class="hidden content"><small>Verify Username</small></div>
											<div class="visible content">
												&emsp;<i class="right check circle outline icon large"></i>&emsp;
											</div>
										</div>
										<input type="text" disabled value="" placeholder="Verify Username" name="verify_username" id="verify_username">
									</div>
							  	</div>	
						  	</div>
						  	<br>
						  	<div class="two fields">
						  		<div class="field">
									<div class="ui left action input mini fluid">
										<div class="ui animated button basic mini" tabindex="-1">
											<div class="hidden content"><small>Password</small></div>
											<div class="visible content">
												&emsp;<i class="right lock icon large"></i>&emsp;
											</div>
										</div>
										<input type="password" disabled value="" placeholder="Password" name="password" id="password">
									</div>
							  	</div>
							  	<div class="field">
									<div class="ui left action input mini fluid">
										<div class="ui animated button basic mini" tabindex="-1">
											<div class="hidden content"><small>Verify Password</small></div>
											<div class="visible content">
												&emsp;<i class="right check circle outline icon large"></i>&emsp;
											</div>
										</div>
										<input type="password" disabled value="" placeholder="Verify Password" name="verify_password" id="verify_password">
									</div>
							  	</div>
						  	</div>
						</div>
						<div class="ui padded segment">
							<h3 align="center">Profile Image</h3>
							<div class="field">
						  		<div class="ui left action input mini fluid">
									<div class="ui animated button basic mini" tabindex="-1">
										<div class="hidden content"><small>Profile Image</small></div>
										<div class="visible content">
											&emsp;<i class="image file outline icon large"></i>&emsp;
										</div>
									</div>
									<input type="text" value="" placeholder="Profile Image" name="image_file_name" id="image_file_name">
								</div>
							</div>
						  	<div class="field">
						  		<div class="ui basic segment center aligned">
						  			<div class="ui circular image medium center aligned">
										<div class="image_container">
											<img src="<?php echo base_url();?>photos/icons/male_default.jpg" class="center middle aligned flowing_image image bordered" id="profile_image_preview">
										</div>
									</div>	
						  		</div>
						  		
								<input type="file" class="invisible" accept="image/*" value="" name="profile_image" id="profile_image">
						  	</div>
						</div>
					</div>
					<div class="ui basic segment right aligned">
						<div class="field right">
					    	<div class="ui checkbox">
					      		<input type="checkbox"bindex="0" class="">
					      		<label>I agree to the <a target="_blank" href="https://app.websitepolicies.com/policies/view/jgisj052">Terms and Conditions</a></label>
					    	</div>
					  	</div>
				  		<button class="ui positive button large" type="submit" id="registration_submit">Submit</button>
					</div>
				</div>
			</div>
		</form>
	</main>
	<footer id="page_footer">
		<?php include 'esses/footer.php';?>
	</footer>
</body>	
<script type="text/javascript">
	$(document)
        .ready(function() {
           	$('.announcements_activator').remove();
           	$('.chat_activator').remove();
           	$('#page_logo').on('dblclick', function() {
            	window.location.replace('<?php echo base_url();?>i.php/sys_control/login');  
            });
        })
    ;
	$('#gender_drop')
	  	.dropdown()
	;
	$('#purok_street').on('input', function() {
		if ($('#same_address_check').is(':checked')) {
			$('#ec_purok_street').val($('#purok_street').val());
		}
	});
	$('#barangay').on('input', function() {
		if ($('#same_address_check').is(':checked')) {
			$('#ec_barangay').val($('#barangay').val());
		}
	});
	$('#city_municipality').on('input', function() {
		if ($('#same_address_check').is(':checked')) {
			$('#ec_city_municipality').val($('#city_municipality').val());
		}
	});
	$('#province').on('input', function() {
		if ($('#same_address_check').is(':checked')) {
			$('#ec_province').val($('#province').val());
		}
	});
	$('#zip_code').on('input', function() {
		if ($('#same_address_check').is(':checked')) {
			$('#ec_purok_street').val($('#zip_code').val());
		}
	});
	$('#same_address_check').on('change', function() {
		var copy_check = $(this).prop('checked');
		if (copy_check) {
			$('#ec_purok_street').val($('#purok_street').val());
			$('#ec_barangay').val($('#barangay').val());
			$('#ec_city_municipality').val($('#city_municipality').val());
			$('#ec_province').val($('#province').val());
			$('#ec_zip_code').val($('#zip_code').val());
			
			$('#ec_purok_street').attr('disabled', '');
			$('#ec_barangay').attr('disabled', '');
			$('#ec_city_municipality').attr('disabled', '');
			$('#ec_province').attr('disabled', '');
			$('#ec_zip_code').attr('disabled', '');
		}
		else {
			$('#ec_purok_street').removeAttr('disabled');
			$('#ec_barangay').removeAttr('disabled');
			$('#ec_city_municipality').removeAttr('disabled');
			$('#ec_province').removeAttr('disabled');
			$('#ec_zip_code').removeAttr('disabled');
		}
	})
	function temp_username_generator() {
		var first_name = $('#first_name').val().replace(/\s/g,'');
		var last_name = $('#last_name').val().replace(/\s/g,'');
		var birthdate = $('#birthdate').val().replace(/\s/g,'');
		var salt = parseInt(Math.random()*99);

		let first = first_name[0].toUpperCase();
		let second = last_name[0].toUpperCase()+last_name.substr(1,last_name.length);

		gen_username = first+'.'+second+salt;
    	$('#username').val(gen_username);
    	$('#verify_username').val(gen_username);
	}
	function temp_password_generator() {
	    let gen_password = '';
	    let length = 8;

		var first_name = $('#first_name').val().replace(/\s/g,'');
		var last_name = $('#last_name').val().replace(/\s/g,'');
		var birthdate = $('#birthdate').val().replace(/\s/g,'');
		var birthdate = birthdate.replaceAll('-','');
		var phone_number = $('#phone_number').val().replace(/\s/g,'');
		var pepper = "!@#$%";
		var salt = parseInt(Math.random()*99);

	    var characters = first_name+last_name+birthdate+phone_number+pepper+salt;
	    var characters = characters.replaceAll('0','7');
	    var characters = characters.replaceAll('o','p');
	    var characters = characters.replaceAll('O','H');

	    var charactersLength = characters.length;
	    let counter = 0;
	    while (counter < length) {
	      gen_password += characters.charAt(Math.floor(Math.random() * charactersLength));
	      counter += 1;
	    }

	    if (first_name != '' && last_name != '' && birthdate != '' && phone_number != '') {
	    	$('#password').val(gen_password);
			$('#verify_password').val(gen_password);	
	    }
	}
	$('#first_name')
		.on('input', function() {
			temp_username_generator();
			temp_password_generator();
		})
	;
	$('#last_name')
		.on('input', function() {
			temp_username_generator();
			temp_password_generator();
		})
	;
	$('#birthdate')
		.on('input', function() {
			temp_username_generator();
			temp_password_generator();
		})
	;
	$('#phone_number')
		.on('input', function() {
			temp_username_generator();
			temp_password_generator();
		})
	;

	// TIN DISPLAY HANDLER >>>>
 	function tin_hyphen_handler(tin_number) {
		tin_length = tin_number.length;

		const r = /(\D+)/g;
		let first = '';
		let second = '';
		let third = '';

		tin_number = tin_number.replace(r, '');
		first = tin_number.substr(0, 3);
		second = tin_number.substr(3, 3);
		third = tin_number.substr(6, 3);
		fourth = tin_number.substr(9, 5);

		tin_number = first+'-'+second+'-'+third+'-'+fourth;
		return tin_number;
	}
	$('#tin_number')
		.on('keydown', function(event) {
			if (event.keyCode != 8 && event.keyCode != 46) {
				var tin_number = $(this).val();
				if (tin_number.length == 14) {
					$(this).val(tin_hyphen_handler(tin_number));
				}
			}
		})
	;
	// <<<< TIN DISPLAY HANDLER 

	// LBP DISPLAY HANDLER >>>>
 	function lbp_hyphen_handler(lbp_account) {
		lbp_length = lbp_account.length;

		const r = /(\D+)/g;
		let first = '';
		let second = '';
		let third = '';

		lbp_account = lbp_account.replace(r, '');
		first = lbp_account.substr(0, 4);
		second = lbp_account.substr(4, 4);
		third = lbp_account.substr(8, 2);

		lbp_account = first+'-'+second+'-'+third;
		return lbp_account;
	}
	$('#lbp_account')
		.on('keydown', function(event) {
			if (event.keyCode != 8 && event.keyCode != 46) {
				var lbp_account = $(this).val();
				if (lbp_account.length == 10) {
					$(this).val(lbp_hyphen_handler(lbp_account));
				}
			}
		})
	;
	// <<<< LBP DISPLAY HANDLER 

	$('#image_file_name')
	  	.on('click', function() {
	  		$('#profile_image').trigger('click');
	  		$('#image_file_name').trigger('blur');
	  	})
	  	.on('focus', function() {
	  		$('#profile_image').trigger('click');
	  		$('#image_file_name').trigger('blur');
	  	})
	;

	$('#profile_image_preview')
	  	.transition('pulse')
	;
	$('#profile_image')
	  	.on('change', function() {
	  		var file = $('#profile_image')[0].files[0]; 
	  		// IF IMAGE INPUT IS NOT EMPTY
	  		if (file) {
	  			$('#image_file_name').val(file.name);
	  			$('#profile_image_preview')
			  		.attr('src', URL.createObjectURL(file))
  					.transition('pulse')
				;
	  		}
	  		else {
	  			$('#image_file_name').val(null);
		  		$('#profile_image_preview')
  					.transition('pulse')
  					.attr('src', '<?php echo base_url();?>photos/icons/male_default.jpg')
				;
	  		}
	  	})
	;

	// } IMAGE INPUT SECTION
	$('#registration_form')
	  	.form({
	  		on: 'change',
	  		inline: true,
	    	transition: 'swing down',
	        onSuccess: function(event) {
	        	event.preventDefault();
				if($('#registration_form').form('is valid')) {
					var ajax = $.ajax({
						method: 'POST',
						url   : '<?php echo base_url();?>i.php/sys_control/hr_new_registration',
						data  : new FormData(this),
						contentType: false,
						cache: false,
		    			processData: false
					});
					var jqxhr = ajax
						.done(function() {
							// alert(jqxhr.responseText);
						})
						.fail(function() {
							alert("error");
						})
						.always(function() {
							var obj = JSON.parse(jqxhr.responseText);
							console.log(obj);
							$.each(obj, function(key, value) {
								var response_status = value['status_type'];
								var response_message = value['message'];

								if (response_status == 'duplicate') {
									duplicates_list = '';
									plural_check = false;
									line_counter = 0;
									$.each(response_message, function(key_in, value_in) {
										line_counter++;
										element_id = value_in['element_id'];
										element_message = value_in['element_message'];
										
										if (line_counter != response_message.length) {
											if (duplicates_list == '') {
												duplicates_list += element_message; 
											}
											else {
												duplicates_list += ', '+element_message;	
												plural_check = true;
											}	
										}
										else {
											if (duplicates_list == '') {
												duplicates_list += element_message; 
											}
											else {
												duplicates_list += ', and '+element_message;	
												plural_check = true;
											}
										}
									});

									if (plural_check == true) {
										duplicates_message = 'The '+duplicates_list+' you entered have duplicates in the system.<br><x class="orange-text">INVALID REGISTRATION</x>';
									}
									else {
										duplicates_message = 'The '+duplicates_list+' you entered has a duplicate in the system.<br><x class="orange-text">INVALID REGISTRATION</x>';
									}
									$('#registration_form').form('reset')
									$('#profile_image_preview')
					  					.attr('src', '<?php echo base_url();?>photos/icons/male_default.jpg')
					  					.transition('pulse')
					  				;
									icon = 'window close red';
							  		header = 'Registration Failed!';
								  	message = duplicates_message;
								  	duration = 25000;
								  	load_notification(icon, header, message, duration);	
								}
								else if (response_status == 'error') {
									icon = 'close red';
							  		header = 'Registration Failed!';
								  	message = response_message.UCfirst();
								  	duration = 25000;
								  	load_notification(icon, header, message, duration);	
								}
								else if (response_status == 'success') {
									$('#registration_form').form('reset');
									$('#profile_image_preview')
					  					.attr('src', '<?php echo base_url();?>photos/icons/male_default.jpg')
					  					.transition('pulse')
					  				;
									icon = 'check green';
							  		header = 'Registration details saved! Status: Pending';
								  	message = '';
								  	duration = 25000;
								  	load_notification(icon, header, message, duration);	
								}
							});
						})
					;
				}
	        },
	    	fields: {
	      		first_name: {
			        identifier: 'first_name',
			        rules: [
			          	{
			            	type   : 'empty',
			            	prompt : 'Please enter employee\'s First Name.'
			          	}
			        ]
	      		},
	      		middle_name: {
			        identifier: 'middle_name',
			        rules: [
			          	{
			            	type   : 'empty',
			            	prompt : 'Please enter employee\'s Middle Name.'
			          	}
			        ]
	      		},
	      		last_name: {
			        identifier: 'last_name',
			        rules: [
			          	{
			            	type   : 'empty',
			            	prompt : 'Please enter employee\'s Last Name.'
			          	}
			        ]
	      		},
	      		gender: {
			        identifier: 'gender',
			        rules: [
			          	{
			            	type   : 'empty',
			            	prompt : 'Please select employee\'s Gender.'
			          	}
			        ]
	      		},
	      		position: {
			        identifier: 'position',
			        rules: [
			          	{
			            	type   : 'empty',
			            	prompt : 'Please enter employee\'s Position.'
			          	}
			        ]
	      		},
	      		phone_number: {
			        identifier: 'phone_number',
			        rules: [
			          	{
			            	type   : 'empty',
			            	prompt : 'Please enter employee\'s Phone Number.'
			          	},
			          	{
			          		type   : 'minLength[11]',
			            	prompt : 'Phone Number must be at least 11 characters long.'
			          	}
			        ]
	      		},
	      		purok_street: {
			        identifier: 'purok_street',
			        rules: [
			          	{
			            	type   : 'empty',
			            	prompt : 'Please enter employee\'s Purok/Street.'
			          	}
			        ]
	      		},
	      		barangay: {
			        identifier: 'barangay',
			        rules: [
			          	{
			            	type   : 'empty',
			            	prompt : 'Please enter employee\'s Barangay.'
			          	}
			        ]
	      		},
	      		city_municipality: {
			        identifier: 'city_municipality',
			        rules: [
			          	{
			            	type   : 'empty',
			            	prompt : 'Please enter employee\'s City/Municipality.'
			          	}
			        ]
	      		},
	      		province: {
			        identifier: 'province',
			        rules: [
			          	{
			            	type   : 'empty',
			            	prompt : 'Please enter employee\'s Province.'
			          	}
			        ]
	      		},
	      		zip_code: {
			        identifier: 'zip_code',
			        rules: [
			          	{
			            	type   : 'empty',
			            	prompt : 'Please enter employee\'s Zip Code.'
			          	}
			        ]
	      		},
	      		ec_name: {
			        identifier: 'ec_name',
			        rules: [
			          	{
			            	type   : 'empty',
			            	prompt : 'Please enter the Full Name of the employee\'s contact.'
			          	}
			        ]
	      		},
	      		ec_relationship: {
			        identifier: 'ec_relationship',
			        rules: [
			          	{
			            	type   : 'empty',
			            	prompt : 'Please enter the contact\'s relationship with the employee.'
			          	}
			        ]
	      		},
	      		ec_phone_number: {
			        identifier: 'ec_phone_number',
			        rules: [
			          	{
			            	type   : 'empty',
			            	prompt : 'Please enter the Phone Number of the employee\'s contact.'
			          	}
			        ]
	      		},
	      		ec_purok_street: {
			        identifier: 'ec_purok_street',
			        rules: [
			          	{
			            	type   : 'empty',
			            	prompt : 'Please enter the Purok/Street of the employee\'s contact.'
			          	}
			        ]
	      		},
	      		ec_barangay: {
			        identifier: 'ec_barangay',
			        rules: [
			          	{
			            	type   : 'empty',
			            	prompt : 'Please enter the Barangay of the employee\'s contact.'
			          	}
			        ]
	      		},
	      		ec_city_municipality: {
			        identifier: 'ec_city_municipality',
			        rules: [
			          	{
			            	type   : 'empty',
			            	prompt : 'Please enter the City/Municipality of the employee\'s contact.'
			          	}
			        ]
	      		},
	      		ec_province: {
			        identifier: 'ec_province',
			        rules: [
			          	{
			            	type   : 'empty',
			            	prompt : 'Please enter the Province of the employee\'s contact.'
			          	}
			        ]
	      		},
	      		ec_zip_code: {
			        identifier: 'ec_zip_code',
			        rules: [
			          	{
			            	type   : 'empty',
			            	prompt : 'Please enter the ZIP Code of the employee\'s contact.'
			          	}
			        ]
	      		},
	      		email_address: {
			        identifier: 'email_address',
			        rules: [
			          	{
			            	type   : 'empty',
			            	prompt : 'Please enter a valid Email Address.'
			            },
			            {
			            	type   : 'email',
			            	prompt : 'Input must be a valid email!',
			          	}
			        ]
	      		},
	      		verify_email_address: {
			        identifier: 'verify_email_address',
			        rules: [
			          	{
			            	type   : 'empty',
			            	prompt : 'Please verify the employee\'s Email Address'
			            },
			            {
			            	type   : 'match[email_address]',
			            	prompt : '{name} must match Email Address field'
			          	}
			        ]
	      		},
	      		username: {
			        identifier: 'username',
			        rules: [
			          	{
			            	type   : 'empty',
			            	prompt : 'Please enter a Username.'
			          	}
			        ]
	      		},
	      		verify_username: {
			        identifier: 'verify_username',
			        rules: [
			          	{
			            	type   : 'empty',
			            	prompt : 'Please verify your Username'
			            },
			            {
			            	type   : 'match[username]',
			            	prompt : '{name} must match Username field'
			          	}
			        ]
	      		},
	      		password: {
			        identifier: 'password',
			        rules: [
			          	{
			            	type   : 'empty',
			            	prompt : 'Please enter a Password.'
			            },
			            {
			            	type   : 'regExp[^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])]',
			            	prompt : 'Must contain: <br>&emsp;at least one(1) number [0-9], <br>&emsp;at least one(1) lowercase letter [a-z], <br>&emsp;at least one(1) uppercase letter [A-Z]'
			            },
			            {
			            	type   : 'minLength[8]',
			            	prompt : 'Must be at least 8 characters long.'
			          	}
			        ]
	      		},
	      		verify_password: {
			        identifier: 'verify_password',
			        rules: [
			          	{
			            	type   : 'empty',
			            	prompt : 'Please verify your Password'
			            },
			            {
			            	type   : 'match[password]',
			            	prompt : '{name} must match Password field'
			          	}
			        ]
	      		},
	      		image_file_name: {
			        identifier: 'image_file_name',
			        rules: [
			          	{
			            	type   : 'empty',
			            	prompt : 'Please select a valid Profile Image'
			            }
			        ]
	      		}
	      	}
	  	})
	;
	if($('#registration_form').form('is valid', 'email_address')) {
	  	alert('valid email');
	}
	if( $('.ui.form').form('is valid')) {
		// If all form input are valid
		// alert('working');
	}
</script>
</html>