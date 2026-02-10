<link href="https://fonts.cdnfonts.com/css/trajan-pro" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>semantic/semantic.min.css">
<script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>
<script src="<?php echo base_url();?>semantic/semantic.min.js"></script>
<link rel="icon" href="<?php echo base_url();?>photos/icons/logo.png">

<div class="ui mini modal" id="file_deletion">
	<div class="ui icon header">
		<i class="check circle outline icon orange"></i>
		<span id="file_deletion_header"></span>
	</div>
	<div class="content" align="center">
		<p class="ui text" id="file_deletion_message"></p>
	</div>
	<div class="actions centered-actions">
		<div class="ui red cancel inverted button" id="deletion_negative_action">
			<i class="remove icon"></i>
			<span id="deletion_negative_confirm"></span>
		</div>
		<div class="ui green ok inverted button" id="deletion_positive_action">
			<i class="checkmark icon"></i>
			<span id="deletion_positive_confirm"></span>
		</div>
	</div>
</div>
 
<div class="ui mini basic modal" id="approve_confirmation">
	<div class="ui icon header">
		<i class="check circle outline icon orange"></i>
		<span>Please Confirm Action</span>
	</div>
	<div class="content" align="center">
		<p class="ui text">Are you sure you want to <x class="green-text">APPROVE</x> this registration application?</p>
	</div>
	<div class="actions centered-actions">
		<div class="ui orange deny inverted button">
			<i class="remove icon"></i>
			No
		</div>
		<div class="ui green ok inverted button" id="approve_positive_action">
			<i class="checkmark icon"></i>
			Yes
		</div>
	</div>
</div>

<div class="ui mini basic modal" id="decline_confirmation">
	<div class="ui icon header">
		<i class="check circle outline icon orange"></i>
		<span>Please Confirm Action</span>
	</div>
	<div class="content" align="center">
		<p class="ui text">Are you sure you want to <x class="red-text">DECLINE</x> this registration application?</p>
	</div>
	<div class="actions centered-actions">
		<div class="ui orange deny inverted button">
			<i class="remove icon"></i>
			No
		</div>
		<div class="ui red ok inverted button" id="decline_positive_action">
			<i class="checkmark icon"></i>
			Yes
		</div>
	</div>
</div>

<div class="ui basic mini modal" id="loader">
	<div class="content">
		<div class="ui big text centered inline loader" id="loading_label"></div>
	</div>
</div>

<div class="ui tiny modal gray" id="notification">
	<div class="ui icon header medium">
		<i class="icon" id="notification_icon"></i>
		<span id="notification_header"></span>
	</div>
	<div class="content" align="center">
		<p class="ui text" id="notification_message"></p>
	</div>
	<div class="actions centered-actions">
		<div class="ui basic mini orange cancel button" id="notification_dismiss">
			<i class="remove icon"></i>
			<span>Dismiss</span>
		</div>
	</div>
</div>

<div class="ui tiny modal gray" id="c_notification">
	<div class="ui icon header medium">
		<i class="icon" id="c_notification_icon"></i>
		<span id="c_notification_header"></span>
	</div>
	<div class="content" align="center">
		<p class="ui text" id="c_notification_message"></p>
	</div>
</div>

<div class="ui tiny modal" id="credentials_check_modal">
	<i class="close icon yellow"></i>
	<div class="ui icon header medium">
		<a>Confirm Credentials</a>
	</div>
	<div class="content" align="center">
		<form class="ui form" enctype="multipart/form-data" id="credentials_check_form">
			<div class="ui center aligned basic segment">
				<div class="ui center aligned padded basic segment">
					<h1 class="ui header small center aligned" id="purpose_message">
						
					</h1>
					<div class="field">
						<div class="ui right action input">
							<input type="text" value="" placeholder="Username" name="confirmation_username" id="confirmation_username" autocomplete="off">
							<div class="ui animated button basic tiny" tabindex="-1">
								<div class="hidden content"><small>Username</small></div>
								<div class="visible content">
									&emsp;<i class="lock icon teal large"></i>&emsp;
								</div>
							</div>
						</div>
					</div>
					<div class="field">
						<div class="ui right action input">
							<input type="password" value="" placeholder="Password" name="confirmation_password" id="confirmation_password" autocomplete="off">
							<div class="ui animated button basic tiny" tabindex="-1">
								<div class="hidden content"><small>Password</small></div>
								<div class="visible content">
									&emsp;<i class="key icon teal large"></i>&emsp;
								</div>
							</div>
						</div>
						<input type="hidden" value="" id="action_holder">
					</div>
				</div>
			</div>
		</form>        
	</div>
	<div class="actions right-actions">
		<button class="ui green button" id="confirm_credentials" form="credentials_check_form">
			<i class="check icon"></i>
			<span>Confirm</span>
		</button>
	</div>
</div>

<div class="ui small modal" id="personnel_files_upload_modal">
	<div class="ui header center aligned">
		<a id="active_file_title"></a>
	</div>
	<div class="ui content">
		<form class="ui form" enctype="multipart/form-data" id="personnel_files_upload_form">
			<div class="ui grid centered">
				<div class="ui row centered column">
					<div class="column fourteen wide center aligned field">
						<input type="file" class="file_input" name="personnel_files[]" id="personnel_files" multiple>
						<div class="ui basic segment left aligned" id="personnel_files_container">
							<div class="ui header medium center aligned">
								Selected Files
							</div>
						</div>
						<div class="ui small teal button" id="personnel_upload_activator">
							<i class="upload icon"></i>
							Select Files
						</div>
						<br>
						<input type="text" class="file_input" name="personnel_file_indicator" id="personnel_file_indicator">
						<input type="hidden" name="active_file_type_id" id="active_file_type_id">
						<input type="hidden" name="active_personnel_management_id" id="active_personnel_management_id">
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="actions">
		<button class="ui cancel grey left labeled icon button" id="personnel_files_upload_dismiss">
			Cancel
			<i class="close icon"></i>
		</button>
		<button type="submit" form="personnel_files_upload_form" class="ui green right labeled icon button">
			<i class="upload icon"></i>
			Upload
		</button>
	</div>
</div>
<script type="text/javascript">
	$('#personnel_upload_activator')
		.on('click', function() {
			$('#personnel_files').trigger('click');
		})
	;
	$('#personnel_files')
		.on('input', function() {
			var files_length = this.files.length;
			var files_array = [];
			var default_data = `
				<div class="ui header medium center aligned">
					Selected Files
				</div>
			`;
			$('#personnel_files_container').html(default_data);

			if (files_length > 10) {
				icon = 'close red';
				header = 'Too many files!';
				message = 'You have chosen '+files_length+' files. The maximum number of upload documents allowed is 10';
				duration = 25000;
				exit_action = `
					show_personnel_files_upload_modal()
				`;
				overlay = 'multiple';
				load_notification(icon, header, message, duration, exit_action, overlay);
				$('#personnel_file_indicator').val('false');
				$('#personnel_files').val('');
			}
			else {
				for (i = 0; i < files_length; i++) {
					files_array.push(this.files[i]);

					file_name = this.files[i].name;
					file_ext = file_name.substr(file_name.lastIndexOf('.') + 1);
					String(file_name.split('.')[1]).toLowerCase();

					if (file_ext == 'pdf') {
						file_type = 'pdf';
						file_color = 'red';
					}
					else if (file_ext == 'docx' || file_ext == 'doc') {
						file_type = 'word';
						file_color = 'blue';
					}
					else if (file_ext == 'xlsx' || file_ext == 'xlsm' || file_ext == 'xls' || file_ext == 'xml') {
						file_type = 'excel';
						file_color = 'green';
					}
					else if (file_ext == 'pptx' || file_ext == 'pptm' || file_ext == 'ppt') {
						file_type = 'powerpoint';
						file_color = 'orange';
					}
					else if (file_ext == 'jpg' || file_ext == 'jpeg' || file_ext == 'png') {
						file_type = 'image';
						file_color = 'brown';
					}
					else if (file_ext == 'mp4' || file_ext == 'mov' || file_ext == 'avi') {
						file_type = 'video';
						file_color = 'yellow';
					}
					else if (file_ext == 'zip' || file_ext == 'rar') {
						file_type = 'archive';
						file_color = 'grey';
					}

					file_item = `
						<a class="ui label small file_icon" id="personnel_file`+i+`">
							<i class="file outline `+file_type+` `+file_color+` icon big"></i>
							<span class="text truncate-text">`+file_name+`</span>
						</a>
					`;
					// <i class="delete icon deleter" id="deleter`+i+`" data-deletion_target="file`+i+`" data-array_index="`+i+`"></i>
					$('#personnel_files_container').append(file_item);
					$('#personnel_file_indicator').val('true');
					$('#personnel_files_upload_form').form('validate field', 'personnel_file_indicator');
				}   
				// $('.deleter')
				//  .on('click', function() {
				//      var index = $(this).data('array_index');
				//      files_array.splice(index, 1);

				//      $('#'+$(this).data('deletion_target')).remove();
				//  })
				// ;
			}
		})
	;
	function wordify_date(dateStr) {
    var date = new Date(dateStr);
    var options = { year: 'numeric', month: 'short', day: 'numeric' };
    return new Intl.DateTimeFormat('en-US', options).format(date);
  }
  function wordify_datetime(dateTimeStr) {
    const date = new Date(dateTimeStr);
    const today = new Date();
        
    const isToday = date.toDateString() === today.toDateString();
        
    const dateOptions = { month: 'short', day: 'numeric', year: 'numeric' };
    const timeOptions = { hour: 'numeric', minute: 'numeric', hour12: true };
        
    if (isToday) {
      return `Today - ${date.toLocaleTimeString('en-US', timeOptions)}`;
    } 
    else {
      return `${date.toLocaleDateString('en-US', dateOptions)} - ${date.toLocaleTimeString('en-US', timeOptions)}`;
    }
  }
  function wrap_links(string) {
    return string.replace(/(\b(?:https?:\/\/)?(?:www\.)?[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}(?:\/[^\s]*)?\b)/g, '<a href="$1" target="_blank" class="wrapped_link">$1</a>');
	}
	$('#personnel_files_upload_form')
		.form({
			on: 'change',
			inline: true,
			transition: 'swing down',
			onInvalid: function() {
				
			},
			onSuccess: function(event) {
				event.preventDefault();
				if($('#personnel_files_upload_form').form('is valid')) {
					var ajax = $.ajax({
						method: 'POST',
						url   : '<?php echo base_url();?>i.php/sys_control/upload_personnel_files',
						data  : new FormData(this),
						contentType: false,
						cache: false,
						processData: false
					});
					var jqxhr = ajax
						.done(function() {
							console.log(jqxhr.responseText);
						})
						.fail(function() {
							alert('error');
						})
						.always(function() {
							var obj = JSON.parse(jqxhr.responseText);
							console.log(jqxhr.responseText);

							error_count = 0;
							success_count = 0;
							error_message = '';
							success_message = '';
							$.each(obj, function(key, value) {
								$.each(value, function(inner_key, inner_value) {
									var response_status = inner_value['status_type'];
									if (response_status == 'success') {
										success_count++;
									}
									else if (response_status == 'error') {
										error_count++;
									}   
								})
							});

							error_condition = error_count;
							success_condition = success_count;

							$.each(obj, function(key, value) {
								$.each(value, function(inner_key, inner_value) {
									var response_status = inner_value['status_type'];
									var response_message = inner_value['message'];
									if (response_status == 'success') {
										success_condition--;
										if (success_count == 1) {
											success_message += '<x class="teal-text">"'+response_message+'"</x> was uploaded successfully!';
										}
										else {
											if (success_condition > 0) {
												success_message += '<x class="teal-text">"'+response_message+'"</x>, ';
											}
											else {
												success_message += 'and <x class="teal-text">"'+response_message+'"</x> were uploaded successfully!';
											}
										}
										$('#personnel_files_upload_dismiss').trigger('click');
									}
									else if (response_status == 'error') {
										error_condition--;
										if (error_condition > 0) {
											error_message += '<x class="teal-text">"'+response_message+'"</x>, ';
										}
										else {
											error_message += 'and <x class="teal-text">"'+response_message+'"</x> failed to upload!';
										}
									}
								})
							});
							if (error_message != '') {
								icon = 'warning orange';
								header = error_count+' item/s failed to upload! '+success_count+' files uploaded successfully!';
								message = error_message+' '+success_message;
								duration = 5000;
								exit_action = `
									show_user_management_modal()
								`;
								overlay = 'multiple';
								load_notification(icon, header, message, duration, exit_action, overlay);
							}
							else if (success_message != '') {
								$('#registration_form').form('reset');
								icon = 'check green';
								header = success_count+' file/s uploaded successfully!';
								message = success_message;
								duration = 5000;
								exit_action = `
									show_user_management_modal()
								`;
								overlay = 'multiple';
								load_notification(icon, header, message, duration, exit_action, overlay);
							}
							active_user_id = $('#active_personnel_management_id').val();
							$.when(load_document_types())
								.done(function() {
									setTimeout(function() {
										specific_personnel_files(active_user_id);
										show_user_management_modal();
									}, 500);
								})
							;
						})
					;
				}
				else if (project_description == null || project_description == '<p>Project Description</p>') {
					
				}
			},
			fields: {
				personnel_file_indicator: {
					identifier: 'personnel_file_indicator',
					rules: [
						{
							type   : 'isExactly[true]',
							prompt : 'Please select Files to upload.'
						}
					]
				}
			}
		})
	;
	$('#credentials_check_form')
		.form({
			on: 'change',
			inline: true,
			transition: 'swing down',
			onSuccess: function(event) {
				event.preventDefault();
				if($('#credentials_check_form').form('is valid')) {
					var ajax = $.ajax({
						method: 'POST',
						url   : '<?php echo base_url();?>i.php/sys_control/credentials_check',
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
							response = jqxhr.responseText;
							
							if (response == '300fr$') {
								icon = 'times red';
								header = 'Invalid Credentials: Authentication Failed';
								message = `
									Your login credentials are incorrect. Action request denied!
								`;
								duration = 25000;
								exit_action = '';
								overlay = 'multiple';
								load_notification(icon, header, message, duration, exit_action, overlay);
							}
							else if (response == '420t9i') {
								icon = 'check green';
								header = 'Credentials Authenticated';
								message = `
									<big>
										Your requested action shall be carried out shortly.
									</big>
									<br>
									Please wait while we take care of the details.
								`;
								duration = 25000;
								exit_action = '';
								overlay = 'multiple';
								load_notification(icon, header, message, duration, exit_action, overlay);
							}
								
						})
					;
				}
			},
			fields: {
				confirmation_username: {
					identifier: 'confirmation_username',
					rules: [
						{
							type   : 'empty',
							prompt : 'Username is required'
						},
						{
							type   : 'regExp[^[a-zA-Z0-9_@.-]+$]',
							prompt : 'Cannot contain special characters'
						}
					]
				},
				confirmation_password: {
					identifier: 'confirmation_password',
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
	$('#file_class_form')
		.on('submit', function(event) {
			event.preventDefault();
		})
	;
	
	async function load_document_types() {
		var ajax = $.ajax("<?php echo base_url();?>i.php/sys_control/load_document_types");
		var jqxhr = ajax
		.done(function() {

		})
		.fail(function()  {
			alert("error");
		})
		.always(function() {
			$('#personnel_documents_tab').html('');
			$('#file_class_form').html('');
			var response_data = JSON.parse(jqxhr.responseText);
			if (response_data != '') {
				$.each(response_data, function(key, value) {
					class_counter++;
					var document_type_id = value.document_type_id;
					var document_type_title = value.document_type_title;

					document_section = `
						<div class="title ui segment basic" id="files_segment`+document_type_id+`" data-active_type_id="`+document_type_id+`" data-active_title="`+document_type_title+`">
							<div class="teal-text header medium">
								`+document_type_title+`
							</div>
							<div class="small right ribbon ui label yellow" id="file_counter`+document_type_id+`" data-current_value="0">0</div>
						</div>
						<div class="content" id="personnel_files_segment`+document_type_id+`" data-active_type_id="`+document_type_id+`" data-active_title="`+document_type_title+`">
							<div class="ui basic segment">
								<div class="ui horizontal selection list" id="personnel_files_section`+document_type_id+`" data-active_type_id="`+document_type_id+`" data-active_title="`+document_type_title+`">
									<h4>Empty</h4>
								</div>
							</div>
						</div>
					`;
					types_modal_section = `
						<div class="field">
							<div class="ui transparent large input" tabindex="0">
								<input class="old_class" type="text" value="`+document_type_title+`" placeholder="`+document_type_title+` *for removal*" name="existing_class`+class_counter+`" id="existing_class`+class_counter+`" data-default_value="`+document_type_title+`" data-type_id="`+document_type_id+`">
							</div>
						</div>
					`;

					$('#personnel_documents_tab').append(document_section);
					$('#file_class_form').append(types_modal_section);
					
					$('#existing_class'+class_counter)
						.on('input', function() {
							if ($.trim($(this).val()) == '') {
								class_counter--;
							}
						})
					;
					$('#personnel_files_segment'+document_type_id)
						.on('contextmenu', function(event) {
							event.preventDefault();
							var active_id = $(this).data('active_type_id');
							var active_title = $(this).data('active_title');

							$('#active_file_title').html(active_title+' Upload');

							show_personnel_files_upload_modal();
							$('#active_file_type_id')
								.val(active_id)
							;
						})
					;
					$('#files_segment'+document_type_id)
						.on('contextmenu', function(event) {
							event.preventDefault();
							var active_id = $(this).data('active_type_id');
							var active_title = $(this).data('active_title');

							$('#active_file_title').html(active_title+' Upload');

							show_personnel_files_upload_modal();
							$('#active_file_type_id')
								.val(active_id)
							;
						})
					;
				})
				$('#personnel_documents_tab').accordion();

				$('#personnel_files_upload_dismiss')
					.on('click', function() {
						if ($('#user_management_modal').length) {
							$('#user_management_modal')
								.modal('setting', 'closable', false)
								.modal('setting', 'blurring', true)
								.modal('show')
							;    
						}
						else {
							$('#personnel_files_upload_modal')
								.modal('hide')
							;
						}
						
					})
				;
			}
			return true;
		})
	}
	async function load_personnel_files() {
		var ajax = $.ajax("<?php echo base_url();?>i.php/sys_control/load_personnel_files");
		var jqxhr = ajax
		.done(function() {

		})
		.fail(function()  {
			alert("error");
		})
		.always(function() {
			var response_data = JSON.parse(jqxhr.responseText);
			if (response_data != '') {
				
				$.each(response_data, function(key, value) {
					var file_id = value.file_id;
					var document_type_id = value.document_type_id;
					var file_name = value.file_name;
					var file_ext = value.file_extension;
					var upload_date = value.upload_date;

					if ($.trim($('#personnel_files_section'+document_type_id).html()) == '<h4>Empty</h4>') {
						$('#personnel_files_section'+document_type_id).html('<br>');
					}

					if (file_ext == 'pdf') {
						file_type = 'pdf';
						file_color = 'red';
					}
					else if (file_ext == 'docx' || file_ext == 'doc') {
						file_type = 'word';
						file_color = 'blue';
					}
					else if (file_ext == 'xlsx' || file_ext == 'xlsm' || file_ext == 'xls' || file_ext == 'xml') {
						file_type = 'excel';
						file_color = 'green';
					}
					else if (file_ext == 'pptx' || file_ext == 'pptm' || file_ext == 'ppt') {
						file_type = 'powerpoint';
						file_color = 'orange';
					}
					else if (file_ext == 'jpg' || file_ext == 'jpeg' || file_ext == 'png') {
						file_type = 'image';
						file_color = 'brown';
					}
					else if (file_ext == 'mp4' || file_ext == 'mov' || file_ext == 'avi') {
						file_type = 'video';
						file_color = 'yellow';
					}
					else if (file_ext == 'zip' || file_ext == 'rar') {
						file_type = 'archive';
						file_color = 'grey';
					}

					file = `
						<div class="item" id="file`+file_id+`">
							<div class="ui segment center aligned dropdown pointing left personnel_files_drop" data-content="`+file_name+`">
								<a class="ui top attached `+file_color+` label truncate-text small">`+file_name+`</a>
								<i class="file `+file_type+` `+file_color+` outline icon huge"></i> 
								<div class="menu">
									<div class="item">
										<i class="download blue icon"></i>
										Download
									</div>
									<div class="item personnel_file_deleter" data-file_id="`+file_id+`" data-document_type_id="`+document_type_id+`" data-file_name="`+file_name+`" id="delete_file`+file_id+`">
										<i class="trash red icon"></i>
										Delete
									</div>
								</div>
							</div>  
						</div>
					`;
					
					count = $('#file_counter'+document_type_id).data('current_value');
					count = parseInt(count)+1;
					$('#file_counter'+document_type_id).html(count);
					$('#file_counter'+document_type_id).data('current_value', count);
					if (count != 0) {
						$('#file_counter'+document_type_id).addClass('green');
						$('#file_counter'+document_type_id).removeClass('yellow');
					}
					else {
						$('#file_counter'+document_type_id).addClass('yellow');
						$('#file_counter'+document_type_id).removeClass('green');
					}

					$('#personnel_files_section'+document_type_id).append(file);
					
				})
				$('.personnel_files_drop')
					.popup({
			    	boundary: '#personnel_documents_container',
			  		variation: 'tiny'
			  	})
					.dropdown({
						on: 'click',
						transition : 'fade up',
						duration   : 400,
						delay : {
							hide   : 100,
							show   : 100,
							search : 50,
							touch  : 50
						}
					})
				;
				$('.personnel_file_deleter')
					.on('click', function() {
						delete_file_id = $(this).data('file_id');
						delete_type_id = $(this).data('document_type_id');
						delete_file_name = $(this).data('file_name');

						header = 'Please Confirm Action';
						message = 'Are you sure you want to <x class="red-text">DELETE</x> <x class="teal-text">"'+delete_file_name+'"</x>?';
						negative = 'No';
						positive = 'Yes';
						address = 'delete_personnel_file';
						file_id = delete_file_id;
						counter_id = delete_type_id;
						action = `
							$('#personnel_files_upload_dismiss')
								.on('click', function() {
									if ($('#user_management_modal').length) {
										$('#user_management_modal')
											.modal('setting', 'closable', false)
											.modal('setting', 'blurring', true)
											.modal('show')
										;    
									}
									else {
										$('#personnel_files_upload_modal')
											.modal('hide')
										;
									}
									
								})
							;
						`;
						personnel_file_deletion(header, message, negative, positive, address, file_id, counter_id);
					})
				;
			}
			return true;
		})
	}
	function show_personnel_files_upload_modal(action) {
		loading_stop();
		$('#personnel_files_upload_modal')
			.modal('setting', 'transition', 'fade down')
			.modal('setting', 'closable', false)
			.modal('setting', 'blurring', true)
			.modal('setting', 'allowMultiple', true)
			.modal('show')
		;
		var default_data = `
			<div class="ui header medium center aligned">
				Selected Files
			</div>
		`;
		$('#personnel_files_container').html(default_data);

		let exit_function = Function(action);
		$('#user_management_modal_exit')
			.on('click', function () {
				exit_function();        
				var default_data = `
					<div class="ui header medium center aligned">
						Selected Files
					</div>
				`;
				$('#personnel_files_container').html(default_data);
			})
		;
	}
	async function specific_personnel_files(active_user_id) {
		var ajax = $.ajax({
			method: 'POST',
			url   : '<?php echo base_url();?>i.php/sys_control/specific_personnel_files',
			data  : {
				active_user_id: active_user_id
			}
		});
		var jqxhr = ajax
		.done(function() {

		})
		.fail(function()  {
			alert("error");
		})
		.always(function() {
			var response_data = JSON.parse(jqxhr.responseText);
			if (response_data != '') {
				
				$.each(response_data, function(key, value) {
					var file_id = value.file_id;
					var document_type_id = value.document_type_id;
					var file_name = value.file_name;
					var file_ext = value.file_extension;
					var upload_date = value.upload_date;

					if ($.trim($('#personnel_files_section'+document_type_id).html()) == '<h4>Empty</h4>') {
						$('#personnel_files_section'+document_type_id).html('<br>');
					}

					preview_data = '';
					if (file_ext == 'pdf') {
						file_type = 'pdf';
						file_color = 'red';
						preview_data = `
							<div class="item personnel_file_preview_activator" data-type="`+file_type+`" data-file_name="`+file_name+`" data-reference="<?php echo base_url();?>personnel_files/`+active_user_id+`/`+document_type_id+`/`+file_name+`">
								<i class="expand teal icon"></i>
								View File
							</div>
						`;
					}
					else if (file_ext == 'docx' || file_ext == 'doc') {
						file_type = 'word';
						file_color = 'blue';
						// preview_data = `
						// 	<a class="item" target="_blank" href="C:/xampp/htdocs/SiRSys-devpersonnel_files/`+active_user_id+`/`+document_type_id+`/`+file_name+`">
						// 		<i class="expand teal icon"></i>
						// 		View File
						// 	</a>
						// `;
					}
					else if (file_ext == 'xlsx' || file_ext == 'xlsm' || file_ext == 'xls' || file_ext == 'xml') {
						file_type = 'excel';
						file_color = 'green';
						// preview_data = `
						// 	<a class="item" target="_blank" href="C:/xampp/htdocs/SiRSys-devpersonnel_files/`+active_user_id+`/`+document_type_id+`/`+file_name+`">
						// 		<i class="expand teal icon"></i>
						// 		View File
						// 	</a>
						// `;
					}
					else if (file_ext == 'pptx' || file_ext == 'pptm' || file_ext == 'ppt') {
						file_type = 'powerpoint';
						file_color = 'orange';
						// preview_data = `
						// 	<a class="item" target="_blank" href="C:/xampp/htdocs/SiRSys-devpersonnel_files/`+active_user_id+`/`+document_type_id+`/`+file_name+`">
						// 		<i class="expand teal icon"></i>
						// 		View File
						// 	</a>
						// `;
					}
					else if (file_ext == 'jpg' || file_ext == 'jpeg' || file_ext == 'png') {
						file_type = 'image';
						file_color = 'brown';
						preview_data = `
							<div class="item personnel_file_preview_activator" data-type="`+file_type+`" data-file_name="`+file_name+`" data-reference="<?php echo base_url();?>personnel_files/`+active_user_id+`/`+document_type_id+`/`+file_name+`">
								<i class="expand teal icon"></i>
								View Image
							</div>
						`;
					}
					else if (file_ext == 'mp4' || file_ext == 'mov' || file_ext == 'avi') {
						file_type = 'video';
						file_color = 'yellow';
						preview_data = `
							<div class="item personnel_file_preview_activator" data-type="`+file_type+`" data-file_name="`+file_name+`" data-reference="<?php echo base_url();?>personnel_files/`+active_user_id+`/`+document_type_id+`/`+file_name+`">
								<i class="expand teal icon"></i>
								View Media
							</div>
						`;
					}
					else if (file_ext == 'zip' || file_ext == 'rar') {
						file_type = 'archive';
						file_color = 'grey';
						// preview_data = `
						// 	<div class="item personnel_file_preview_activator" data-type="`+file_type+`" data-file_name="`+file_name+`" data-reference="<?php echo base_url();?>personnel_files/`+active_user_id+`/`+document_type_id+`/`+file_name+`">
						// 		<i class="expand teal icon"></i>
						// 		View File
						// 	</div>
						// `;
					}

					file = `
						<div class="item" id="personnel_file`+file_id+`">
							<div class="ui segment center aligned dropdown pointing left personnel_files_drop" data-content="`+file_name+`">
								<a class="ui top attached `+file_color+` label truncate-text small">`+file_name+`</a>
								<i class="file `+file_type+` `+file_color+` outline icon huge"></i> 
								<div class="menu">
									`+preview_data+`
									<a class="item" id="file_downloader`+file_id+`" href="<?php echo base_url();?>personnel_files/`+active_user_id+`/`+document_type_id+`/`+file_name+`" download>
										<i class="download blue icon"></i>
										Download
									</a>
									<div class="item personnel_file_deleter" data-file_id="`+file_id+`" data-document_type_id="`+document_type_id+`" data-file_name="`+file_name+`" id="delete_file`+file_id+`">
										<i class="trash red icon"></i>
										Delete
									</div>
								</div>
							</div>  
						</div>
					`;
					
					count = $('#file_counter'+document_type_id).data('current_value');
					count = parseInt(count)+1;
					$('#file_counter'+document_type_id).html(count);
					$('#file_counter'+document_type_id).data('current_value', count);
					if (count != 0) {
						$('#file_counter'+document_type_id).addClass('green');
						$('#file_counter'+document_type_id).removeClass('yellow');
					}
					$('#personnel_files_section'+document_type_id).append(file);
				})
				$('.personnel_files_drop')
					.popup({
			    	boundary: '#personnel_documents_container',
			  		variation: 'tiny'
			  	})
					.dropdown({
						on: 'click',
						transition : 'fade up',
						duration   : 400,
						delay : {
							hide   : 100,
							show   : 100,
							search : 50,
							touch  : 50
						}
					})
				;
				$('.document_opener')
					.on('click', function() {
						ref = $(this).data('reference');
        		Excel.Workbooks.Open(ref);
					})
				;
				$('.personnel_file_preview_activator')
					.on('click', function() {
						file_type = $(this).data('type');
						file_name = $(this).data('file_name');
						ref = $(this).data('reference');

						if (file_type == 'image') {
							file_preview_data = `
								<div class="image_container">
									<img src="`+ref+`" class="center middle aligned flowing_image image bordered">
								</div>
							`;
							$('#image_preview_title').attr('href', ref);
							$('#image_preview_title').attr('target', '_blank');
							$('#image_preview_title').html(file_name);
							$('#image_preview_container').html(file_preview_data);

							$('#image_preview_modal')
								.modal('setting', 'closable', false)
								.modal('setting', 'allowMultiple', true)
								.modal('setting', 'blurring', true)
								.modal('show')
							;
							$('#image_preview_closer')
								.on('click', function() {
									// $('#user_management_modal')
									// 	.modal('setting', 'closable', false)
									// 	.modal('setting', 'blurring', true)
									// 	.modal('show')
									// ;			
							});
						}
						else if (file_type == 'pdf' || file_type == 'video') {
							file_preview_data = `<object data="`+ref+`" width="100%" height="700"></object>`;
							$('#file_preview_title').attr('href', ref);
							$('#file_preview_title').attr('target', '_blank');
							$('#file_preview_title').html(file_name);
							$('#file_preview_container').html(file_preview_data);

							$('#file_preview_modal')
								.modal('setting', 'closable', false)
								.modal('setting', 'allowMultiple', true)
								.modal('setting', 'blurring', true)
								.modal('show')
							;
							$('#file_preview_closer')
								.on('click', function() {
									// $('#user_management_modal')
									// 	.modal('setting', 'closable', false)
									// 	.modal('setting', 'blurring', true)
									// 	.modal('show')
									// ;			
							});
						}
					})
				;
				$('.personnel_file_deleter')
					.on('click', function() {
						delete_file_id = $(this).data('file_id');
						delete_type_id = $(this).data('document_type_id');
						delete_file_name = $(this).data('file_name');

						header = 'Please Confirm Action';
						message = 'Are you sure you want to <x class="red-text">DELETE</x> <x class="teal-text">"'+delete_file_name+'"</x>?';
						negative = 'No';
						positive = 'Yes';
						file_id = delete_file_id;
						counter_id = delete_type_id;
						personnel_file_deletion(header, message, negative, positive, file_id, counter_id, active_user_id);
					})
				;
			}
			loading_stop();
			return true;
		})
	}
	function personnel_file_deletion(header, message, negative, positive, file_id, counter_id, user_id) {
		$('#deletion_positive_action').on('click', function() {
			var ajax = $.ajax({
				method: 'POST',
				url   : '<?php echo base_url();?>i.php/sys_control/delete_personnel_file',
				data  : {
					file_id: file_id
				}
			});
			var jqxhr = ajax
			.fail(function() {
				alert("Connection Error");
			})
			.always(function() {
				count = $('#file_counter'+counter_id).data('current_value');
				count = parseInt(count)-1;
				$('#file_counter'+counter_id).html(count);
				$('#file_counter'+counter_id).data('current_value', count);
				if (count != 0) {
					$('#file_counter'+counter_id).addClass('green');
					$('#file_counter'+counter_id).removeClass('yellow');
				}
				else {
					empty_string = '<h4>Empty</h4>'
					container_id = $('#personnel_file'+file_id).parent('.list').attr('id');
					
					$('#'+container_id).append(empty_string);
					$('#file_counter'+counter_id).addClass('yellow');
					$('#file_counter'+counter_id).removeClass('green');
				}
				$('#personnel_file'+file_id).remove();
				setTimeout(function() {
					$('#user_management_modal')
						.modal('setting', 'closable', false)
						.modal('setting', 'allowMultiple', true)
						.modal('setting', 'blurring', false)
						.modal('show')
					;    
				},200);
			})
			$('#deletion_positive_action').prop("onclick", null).off("click");
		});
		$('#deletion_negative_action').on('click', function() {
			$('#user_management_modal')
				.modal('setting', 'closable', false)
				.modal('setting', 'blurring', false)
				.modal('show')
			;    
		});
		
		$('#file_deletion_header').html(header);
		$('#file_deletion_message').html(message);
		$('#deletion_negative_confirm').html(negative);
		$('#deletion_positive_confirm').html(positive);
		$('#file_deletion')
			.modal('setting', 'closable', false)
			.modal('setting', 'allowMultiple', true)
			.modal('setting', 'blurring', false)
			.modal('show')
		;
	}
	function file_deletion_close() {
		$('#file_deletion')
			.modal('setting', 'closable', false)
			.modal('setting', 'allowMultiple', true)
			.modal('setting', 'blurring', true)
			.modal('hide')
		;
	}
	function close_notification() {
		$('#confirmation')
			.modal('setting', 'closable', false)
			.modal('setting', 'allowMultiple', true)
			.modal('setting', 'blurring', true)
			.modal('hide')
		;
	}
	function load_notification(icon, header, message, duration, action, overlay, variation) {
		if (variation == 'basic') {
			$('#notification').addClass('basic');
		}
		else {
			$('#notification').removeClass('basic');
		}
		if (overlay == 'multiple') {
			$('#notification')
				.modal('setting', 'allowMultiple', true)
				.modal('setting', 'closable', false)
				.modal('setting', 'blurring', true)
				.modal('show')
			;	
		}
		else {
			$('#notification')
				.modal('setting', 'allowMultiple', false)
				.modal('setting', 'closable', false)
				.modal('setting', 'blurring', true)
				.modal('show')
			;
		}
		
		$('#notification_icon').attr('class', icon+' icon');
		$('#notification_header').html(header);
		$('#notification_message').html(message);
		let exit_function = Function(action);
		setTimeout(function(){
			$('#notification').modal('hide');
			exit_function();        
		}, duration);
		$('#notification_dismiss')
			.on('click', function () {
				exit_function();        
				$(this).prop("onclick", null).off("click");
			})
		;
	}
	function load_c_notification(icon, header, message, overlay, variation) {
		if (variation == 'basic') {
			$('#c_notification').addClass('basic');
		}
		else {
			$('#c_notification').removeClass('basic');
		}
		if (overlay == 'multiple') {
			$('#c_notification')
				.modal('setting', 'allowMultiple', true)
				.modal('setting', 'closable', false)
				.modal('setting', 'blurring', true)
				.modal('show')
			;	
		}
		else {
			$('#c_notification')
				.modal('setting', 'allowMultiple', false)
				.modal('setting', 'closable', false)
				.modal('setting', 'blurring', true)
				.modal('show')
			;
		}
		$('#c_notification_icon').attr('class', icon+' icon');
		$('#c_notification_header').html(header);
		$('#c_notification_message').html(message);
	}
	function close_notification() {
		$('#notification')
			.modal('hide')
		;
	}
	function loading_start(label) {
		$('#loader')
			.modal('setting', 'allowMultiple', false)
			.modal('setting', 'closable', false)
			.modal('setting', 'blurring', true)
			// .modal('setting', 'useFlex', false)
			.modal('show')
		;
		$('#loading_label').html(label);
	}
	function loading_stop(instant) {
		if (instant) {
			$('#loader').modal('hide');
		}
		else {
			setTimeout(function(){
				$('#loader').modal('hide');
			}, 650);
		}
	}
	$.fn.onEnter = function (fnc) {
	   return this.each(function () {
        	$(this).keypress(function (ev) {
	         var keycode = (ev.keyCode ? ev.keyCode : ev.which);
	         if (keycode == '13') {
	            fnc.call(this, ev);
	         }
	      })
	   })
	}
</script>
<style type="text/css">
	body::-webkit-scrollbar{
		display: none !important;
	}
	/*.scrolling .content {
		max-height: 90% !important;
	}*/
	.squared_search{
		border-radius: 0 !important;
	}
	.truncate-text {
		white-space: nowrap;
		word-wrap: normal;
		overflow: hidden;
		text-overflow: ellipsis;
	}
	.break-text {
		word-wrap: break-word;
		word-break: break-word;
		white-space: normal;
		overflow-wrap: break-word;
	}
	#page_header {
		border-top-left-radius: 0px !important;
		border-top-right-radius: 0px !important;
	}
	.psa-blue {
		background-color: rgb(0, 115, 194) !important;
	}
	.yellow_bg {
		background-color: yellow !important;
	}
	.psa-grey-darker {
		background-color: rgba(51, 51, 51, 0.75) !important;

	}
	.psa-grey {
		background-color: rgb(117, 117, 117) !important;
	}
	.white-text {
		color: white !important;
	}
	.gray-text {
		color: lightgray !important;
	}
	.blue-text {
		color: lightblue !important;    
	}
	.teal-text {
		color: lightseagreen; !important;    
	}
	.green-text {
		color: lightgreen !important;    
	}
	.orange-text {
		color: orange !important;
	}
	.red-text {
		color: red !important;
	}
	.trajan {
		font-family: 'Trajan Pro', sans-serif !important;
	}
	.file_input {
		width: 0.1px !important;
		height: 0.1px !important;
		opacity: 0 !important;
		overflow: hidden !important;
		position: absolute !important;
		z-index: -1 !important;
	}
	.image_container {
		width: 100%;
		aspect-ratio: 1/1;
		overflow:hidden;
		position:relative;
		display: flex;
		background-color: lightgray;
	}
	.image_container img {
		width: 100%;
		height: 100%;
		object-fit:cover;
		object-position:top;
	}
	.post_image {
		object-fit:cover;
		object-position:center;
	}
	.circular_border {
		border: lightgray solid 0.5px;
	}
	.post_image_container {
		width: 100%;
		aspect-ratio: 5/3;
		overflow:hidden;
		position:relative;
		display: flex;
		background-color: darkgray;
	}
	.post_image_container img {
		width: 100%;
		height: 100%;																												
		object-fit:cover;
		object-position:center;
/*		aspect-ratio: 5/3.5;*/
	}
	.post_image_avatar {
		margin-right: .25rem;
		display: inline-block;
		width: 3em;
		height: 2em;
		border-radius: .25rem;
	}
	.bottom_attached {
		bottom: 0;
	}
	.flowing_image {
	/*	max-height: 100%;
		max-width: 100%;
		height: auto;
		width: auto;
		margin: auto;*/
	}
	.force-circular {
		border-radius: 500rem !important;
	}
	.scrolling::-webkit-scrollbar{
		display: none !important;
	}
	.break-word {
		word-wrap: break-word !important;
	}
	.pointered {
		cursor: pointer !important;
		user-select: none !important;
	}
	.centered-actions {
		text-align: center !important;
	}
	.hidden_input {
		width: 0.1px !important;
		height: 0.1px !important;
		opacity: 0 !important;
		overflow: hidden !important;
	}
	#project_description::-webkit-scrollbar {
		display: none !important;
	}
	#project_description{
		top: 10px !important;
	}
	.project_description_segment {
		border-radius: 8px !important;
		height: 600px !important;
		max-height: 600px !important;
	}
	.project_description_segment::-webkit-scrollbar{
		display: none !important;
	}
</style>