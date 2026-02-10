<style type="text/css">
    .floater-button{
        position: fixed !important;
        bottom: 30px !important;
        right: 30px !important;
        z-index: 1000 !important;
    }
</style>
<div class="ui circular icon dropdown button teal bottom right pointing actions_drop floater-button">
<!-- <div class="ui dropdown labeled icon top pointing right "> -->
    <i class="qrcode large icon loading"></i>
    <!-- <i class="ellipsis horizontal large icon"></i> -->
    <div class="menu">
        <div class="ui icon search input">
            <i class="search icon"></i>
            <input type="text" placeholder="Search actions...">
        </div>
        <div class="divider"></div>
        <div class="ui center aligned header">
            <i class="large cogs icon"></i>
            Actions
        </div>
        <div class="scrolling menu">
            <div class="item invisible" id="class_management_activator">
                <i class="blue book icon"></i>
                <small>Manage 201 File Categories</small>
            </div>
            <div class="item announcement_edit_activator" data-announcement_id="0" id="announcement_edit_activator">
                <i class="teal edit outline icon"></i>
                <small>New Announcement</small>
            </div>
            <div class="item add_item_activator" id="add_item_activator">
                <i class="blue dolly flatbed icon"></i>
                <small>Add New Item</small>
            </div>
            <div class="item invisible add_employee_activator" data-project_id="" id="add_employee_activator">
                <i class="green plus icon"></i>
                <small>Add Employee</small>
            </div>
        </div>
    </div>
</div>

<div class="ui tiny modal" id="file_class_management">
    <i class="close icon orange"></i>
    <div class="ui icon header medium">
        <a>File Categories</a>
    </div>
    <div class="scrolling content" align="center">
        <div class="ui grid centered">
            <div class="fourteen wide column centered">
                <form class="ui form" id="file_class_form">
                
                </form>
                <br>
                <form class="ui form" id="new_class_form">
                    <div class="field">
                        <div class="ui input">
                            <input type="text" required placeholder="Category Title" value="" name="" id="new_class_input">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="actions right-actions">
        <button class="ui green button" id="save_file_classes">
            <i class="save icon"></i>
            <span>Save</span>
        </button>
    </div>
</div>
<script type="text/javascript">
    class_counter = 0;
    $('.announcement_edit_activator')
        .on('click', function() {
            var update_announcement_id = $(this).data('announcement_id');
            var ajax = $.ajax({
                method: 'POST',
                url   : '<?php echo base_url();?>i.php/sys_control/set_updating_announcement_id',
                data  : {
                    update_announcement_id: update_announcement_id
                }
            });
            var jqxhr = ajax
            .done(function() {

            })
            .fail(function()  {
                alert("error");
            })
            .always(function() {
                var response_data = jqxhr.responseText;
                window.open('<?php echo base_url();?>i.php/sys_control/announcement_editor');  
            })
        });
    ;
    $('.project_edit_activator')
        .on('click', function() {
            var update_project_id = $(this).data('project_id');
            var ajax = $.ajax({
                method: 'POST',
                url   : '<?php echo base_url();?>i.php/sys_control/set_updating_project_id',
                data  : {
                    update_project_id: update_project_id
                }
            });
            var jqxhr = ajax
            .done(function() {

            })
            .fail(function()  {
                alert("error");
            })
            .always(function() {
                var response_data = jqxhr.responseText;
                window.open('<?php echo base_url();?>i.php/sys_control/project_editor');  
            })
        });
    ;
    $('.add_employee_activator')
        .on('click', function() {
            window.open('<?php echo base_url();?>i.php/sys_control/hr_user_registration');  
        });
    ;
    $('#new_class_form')
        .on('submit', function(event) {
            event.preventDefault();
            class_title = $('#new_class_input').val();
            if ($.trim(class_title) == '') {
                $('#new_class_input').val('');
                $('#new_class_input').trigger('focus');
            }
            else {
                class_counter++;
                field_data = `
                    <div class="field" id="new_class_field`+class_counter+`">
                        <div class="ui transparent large input" tabindex="0">
                            <input class="new_class" type="text" value="`+$.trim(class_title)+`" name="new_class`+class_counter+`" id="new_class`+class_counter+`">
                        </div>
                    </div>
                `;           
                $('#file_class_form').append(field_data);
                $('#new_class_input').val('');
                $('#new_class_input').trigger('focus');

                $('#new_class'+class_counter).on('input', function() {
                    if ($.trim($(this).val()) == '') {
                        $('#new_class_field'+class_counter).remove();
                        class_counter--;
                    }
                });
            }
        })
    ;
    $('#save_file_classes')
        .on('click', function(event) {
            var old_class_array = [];
            var deletion_array = [];
            $.each($('#file_class_form').find('.old_class'), function(key, value) {
                if ($(value).val() != $(value).data('default_value') && $.trim($(value).val()) != '') {
                    inner_val_array = [$(value).data('type_id'),$(value).val()] 
                    old_class_array.push(inner_val_array);
                }
                else if ($.trim($(value).val()) == '') {
                    deletion_array.push($(value).data('type_id'));
                }
            })
            var new_class_array = [];
            $.each($('#file_class_form').find('.new_class'), function(key, value) {
                new_class_array.push($(value).val())
            })
            reload_request = 0;
            if (deletion_array.length != 0) {
                file_class_action(
                    'delete_file_classes',
                    deletion_array
                );
            }
            if (old_class_array.length != 0) {
                file_class_action(
                    'update_file_classes',
                    old_class_array
                );
            }
            if (new_class_array.length != 0) {
                file_class_action(
                    'save_file_classes',
                    new_class_array
                );
            }
            if (reload_request != 0) {
                load_document_types();
            }
        })
        
        function file_class_action(address, items_array) {
            if (address == 'delete_file_classes') {
                 $('#credentials_check_modal')
                    .modal('setting', 'closable', false)
                    .modal({blurring: true})
                    .modal('show')
                ;
                message = `
                    <span>Are you sure you want to remove those File Categories?</span>
                    <br><br>
                    <span>Proceeding will result to <x class="red-text">LOSS OF ALL FILES ASSOCIATED with the selected File Categories!</x></span>
                    <br><br>
                    <span class="orange-text">Please proceed with caution.</span 
                `;
                $('#purpose_message').html(message);    

                var action_str = `
                    var ajax = $.ajax({
                        method: 'POST',
                        url   : '<?php echo base_url();?>i.php/sys_control/`+address+`',
                        data  : {var_array : '`+items_array.toString()+`'}
                    });
                    var jqxhr = ajax
                    .done(function() {

                    })
                    .fail(function()  {
                        alert("error");
                    })
                    .always(function() {
                        load_document_types();
                    })  
                `;
                $('#action_holder').val(action_str);
            }
            else {
                inner_class_action();
            }
            function inner_class_action() {
                var ajax = $.ajax({
                    method: 'POST',
                    url   : '<?php echo base_url();?>i.php/sys_control/'+address,
                    data  : {var_array : items_array}
                });
                var jqxhr = ajax
                .done(function() {

                })
                .fail(function()  {
                    alert("error");
                })
                .always(function() {
                    load_document_types();
                })  
            }
           
        }
        function save_file_classes() {
            var ajax = $.ajax({
                method: 'POST',
                url   : '<?php echo base_url();?>i.php/sys_control/save_file_classes',
                data  : {save_class_array : new_class_array}
            });
            var jqxhr = ajax
            .done(function() {

            })
            .fail(function()  {
                alert("error");
            })
            .always(function() {  
                reload_request++;
            })    
        }
    ;
    $('.floater-button')
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
    $('#class_management_activator')
        .on('click', function() {
            $('#file_class_management')
                .modal('setting', 'closable', false)
                .modal({blurring: true})
                .modal('show')
            ;  
        })
        .on('focus', function(event) {
            $(this).on('keydown', function(event) {
                var key = event.which;
                if (key == 13) {
                    $('#file_class_management')
                        .modal('setting', 'closable', false)
                        .modal({blurring: true})
                        .modal('show')
                    ;  
                }
            })
        })
    ;
    $('#add_item_activator').on('click', function() {
        $('#add_item_modal')
            .modal('setting', 'closable', false)
            .modal({blurring: true})
            .modal('show')
        ;    
    });
    $('#project_creation_activator').on('click', function() {
        window.open('<?php echo base_url();?>i.php/sys_control/project_editor');
    });
</script>