<link href="https://fonts.googleapis.com/css2?family=Chewy&display=swap" rel="stylesheet">
<style type="text/css">
     .chewy-text {
         font-family: 'Chewy', cursive !important;
         font-size: 5vh !important;
         line-height: 1.1;
     }

     /* General clay-like depth (soft inner shadow + slight stroke) */
     .kids span, .play, .zone span {
         font-weight: bold;
     }

     /* KIDS section */
     .kids .k {
         color: #324DFF;
         text-shadow: -3px -3px 0 #2639B8; /* darker blue shadow (left/up) */
     }
     .kids .i {
         color: #EAC734;
         text-shadow: -3px -3px 0 #B69727; /* darker yellow shadow */
     }
     .kids .d {
         color: #E64343;
         text-shadow: -3px -3px 0 #A12C2C; /* darker red shadow */
     }
     .kids .s {
         color: #2BB14A;
         text-shadow: -3px -3px 0 #1F7E35; /* darker green shadow */
     }

     /* PLAY section */
     .play {
         color: #EAC734;
         text-shadow: -3px -3px 0 #B69727; /* darker shade of yellow */
     }

     /* ZONE section */
     .zone .z {
         color: #2BB14A;
         text-shadow: -3px -3px 0 #1F7E35;
     }
     .zone .o {
         color: #E64343;
         text-shadow: -3px -3px 0 #A12C2C;
     }
     .zone .n {
         color: #EAC734;
         text-shadow: -3px -3px 0 #B69727;
     }
     .zone .e {
         color: #324DFF;
         text-shadow: -3px -3px 0 #2639B8;
     }

     .charcoal-background {
          background-color: #404A55;
     }
</style>

<div class="ui grid charcoal-background centered">
     <div class="fifteen wide column">
          <div class="ui unstackable items">
               <div class="item">
                    <div class="middle aligned content">
                         <br>
                         <h5 class="ui header big chewy-text sidebar_activator pointered">
                              <span class="kids">
                                   <span class="k">K</span>
                                   <span class="i">I</span>
                                   <span class="d">D</span>
                                   <span class="s">S</span>
                              </span>
                              <span class="play">play</span>
                              <span class="zone">
                                   <span class="z">Z</span>
                                   <span class="o">O</span>
                                   <span class="n">N</span>
                                   <span class="e">E</span>
                              </span>
                         </h5>
                    </div>
               </div>
          </div>
     </div>
</div>
<br>
<script type="text/javascript">
     String.prototype.UCwords = function() {
          return this.replace(/[\wñÑáéíóúÁÉÍÓÚüÜ]+/g, function(a){ 
               return a.charAt(0).toUpperCase() + a.slice(1).toLowerCase()
          })
     }
     String.prototype.UCfirst = function() {
          return this.charAt(0).toUpperCase() + this.slice(1).toLowerCase()
     }
     String.prototype.isNumber = function() {
          return /^\d+$/.test(this);
     }
     String.prototype.dateWords = function() {
          words_date = new Date(this);
          long_date = words_date.toLocaleDateString('en-us', {year:"numeric", month:"long"})
          return long_date;
     }
     function stringify_date(input_date) {
          var date = new Date(input_date);
          var day = ('0' + date.getDate()).slice(-2);
          var month = ('0' + (parseInt(date.getMonth())+1)).slice(-2);
          var year = date.getFullYear();
          var format_date = year+'-'+month+'-'+day;
          var months_list = ["Jan.",    "Feb.", "Mar.", "Apr.", "May.", "Jun.", "Jul.", "Aug.", "Sep.",  "Oct.",   "Nov.",   "Dec."];

          input_date = months_list[parseInt(month)-1]+' '+day+', '+year;
          return input_date;
     }
     $('.ui.accordion#page_header')
          .accordion()
     ;
     // $('.sidebar_activator')
     //      .on('click', function() {
     //           $('#sidebar_menu')
     //                .sidebar('setting', 'transition', 'scale down')
     //                .sidebar('toggle')
     //           ;
     //      })
     // ;
     $('.pointing.dropdown')
          .dropdown({
               on: 'click',
               transition : 'fade down',
               duration   : 400,
               delay : {
                    hide   : 100,
                    show   : 100,
                    search : 50,
                    touch  : 50
               }
          })
     ;
     $('.announcements_activator').on('click', function(){
          $('#announcements_modal')
               .modal('setting', 'transition', 'fade down')
               .modal('setting', 'closable', false)
               .modal('setting', 'blurring', true)
               .modal('show')
          ;
     });
     $('.chat_activator').on('click', function(){
          alert("Gindodrawing pala :'D");
     });
     
     function load_active_announcements() {
           var ajax = $.ajax("<?php echo base_url();?>i.php/sys_control/load_active_announcements");
          var jqxhr = ajax
          .done(function() {
               var response_data = JSON.parse(jqxhr.responseText);
               if (response_data != '') {
                    $.each(response_data, function(key, value) {
                         var announcement_id = value.announcement_id;
                         var announcement_title = value.announcement_title;
                         var announcement_file = value.announcement_file;
                         var announcement_date = value.announcement_date;
                         
                         var user_id = value.user_id;
                         var image = value.image;
                         var first_name = value.first_name.UCwords();
                         var middle_name = value.middle_name.UCwords();
                         var last_name = value.last_name.UCwords();
                         var suffix = value.suffix.toUpperCase();
                         var position = value.position;

                         string_date = stringify_date(announcement_date);
                         full_name = first_name+' '+middle_name[0]+'. '+last_name;

                         if (suffix != '') {
                              full_name += ' '+suffix+'.';
                         }

                         file_ext = announcement_file.substr(announcement_file.lastIndexOf('.') + 1);
                         String(announcement_file.split('.')[1]).toLowerCase();

                         if (file_ext == 'pdf') {
                              file_object = `
                              <div class='image_container'>
                                   <object type='application/pdf' data='<?php echo base_url();?>/announcement_files/`+announcement_file+`' width='100%' height='100%'></object>
                              </div>
                              `;
                         }
                         else if (file_ext == 'jpg' || file_ext == 'jpeg' || file_ext == 'png') {
                              file_object = `
                              <div class='image_container'>
                                   <img src='<?php echo base_url();?>/announcement_files/`+announcement_file+`' class='center middle aligned flowing_image image bordered'></img>
                              </div>
                              `;   
                         }
                         

                         announcement_card = `
                              <div class="card">
                                   <div class="image_container">
                                        `+file_object+`
                                   </div>
                                   <div class="content">
                                        <a class="ui header announcement_modal_activator" data-file_object="`+file_object+`" data-announcement_title="`+announcement_title+`" data-announcement_date="`+string_date+`" data-full_name="`+full_name+`">
                                             `+announcement_title+`
                                             <div class="sub header">`+string_date+`</div>
                                        </a>
                                   </div>
                                   <div class="extra content">
                                        <a class="poster_popper" id="poster_popper`+announcement_id+`" data-id="`+announcement_id+`"data-image="`+image+`" data-full_name="`+full_name+`" data-position="`+position+`">
                                             <i class="large icons">
                                                  <i class="user icon"></i>
                                                  <i class="top right corner bullhorn icon large"></i>   
                                             </i>
                                             &nbsp;<span>`+full_name+`</span>
                                        </a>
                                   </div>
                              </div>
                         `;
                         
                         $('#announcements_container').append(announcement_card);
                         // $('.special.cards .image').dimmer({on: 'hover'});
                         // $('.dimmable-image').dimmer({on: 'hover'});
                    });
                    $('.poster_popper').on('hover', function() {
                         var announcement_id = $(this).data('id');
                         var image = $(this).data('image');
                         var full_name = $(this).data('full_name');
                         var position = $(this).data('position');
                         alert(position)
                         $('#poster_popper'+announcement_id).popup({
                              transition : 'drop',
                              position   : 'top left',
                              inline     : true,
                              title      : 'Person Name',
                              variation  : 'wide',
                              html       : `
                                   <div class="ui middle aligned list">
                                        <div class="item">
                                             <img src="<?php echo base_url();?>photos/profile_pictures/`+image+`" class="ui tiny image center middle aligned circular">
                                            <div class="content">
                                                  <a class="ui header small">`+full_name+`</a>
                                                  <div class="sub header">`+position+`</div>
                                            </div>
                                        </div>
                                   </div>
                              `
                         });
                    });


                    $('.announcement_modal_activator').on('click', function() {
                         var file_object = $(this).data('file_object');
                         var announcement_title = $(this).data('announcement_title');
                         var full_name = $(this).data('full_name');
                         var announcement_date = $(this).data('announcement_date');

                         // $('#announcement_viewer_modal').html(file_object);
                         $('#announcement_viewer_title').html(announcement_title);
                         $('#announcement_viewer_name').html(full_name);
                         $('#announcement_viewer_date').html(announcement_date);
                         $('#announcement_viewer_file').html(file_object);
                         $('#announcement_viewer_modal')
                              .modal('setting', 'blurring', true)
                              .modal('setting', 'transition', 'fade down')
                              .modal('setting', 'closable', false)
                              .modal('setting', 'allowMultiple', true)
                              .modal('show')
                         ;
                    })
               }
          })
          .fail(function()  {
               alert("error");
          })
          .always(function() {
          })
     }
     function console_user_warning() {
          const header_style = 'background-color: yellow; color: red; font-size: 3em;';
          const message_style = 'background-color: white; color: red; font-size: 2em;';
          console.log('%cWARNING! CLOSE THIS WINDOW IMMEDIATELY!', header_style);
          console.log("%cDO NOT COPY or SHARE ANYTHING FROM THIS WINDOW TO ANYONE, IT WILL COMPROMISE YOUR SYSTEM DATA SECURITY!", message_style);
     }
     $(document)
          .ready(function() {
               console_user_warning();
          })
     ;
</script>