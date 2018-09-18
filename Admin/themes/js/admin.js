$(function () {
    "use strict";

  //hide placeholder on focus
  var $place;
  $(':input').on('focus', function(){
      $place = $(this).attr("placeholder");
      $(this).attr("placeholder","");
  });

  //blur placeholder on focus
  $(':input').on('blur', function(){
      $(this).attr("placeholder",$place);
  });

  //Add asterix on required fields Function
  $('form.form-horizontal').find('input').each(function(){
     if($(this).prop('required')){
         $(this).after("<span class='asterix'>*</span>");
     }
 });

 // Show eye Icon when focus on field
 $(":input[type=password]").click(function(){
     $('.show-pass').show();
 })

 // Show Password when Hover on eye Icon
 var pass = $('.password');
 $('.show-pass').hover(function(){

     pass.attr('type','text');

 }, function(){

     pass.attr('type','password');
 });


 $('.confirm').on('click', function(){
    return confirm("Are you sure!");
 });

 // Ctegory View Option
 $('.cat h3').click(function(){
    $(this).next('.full-view').fadeToggle(200);
});


$('.option span').click(function(){

    $(this).addClass('active').siblings('span').removeClass('active');

    if($(this).data('view') == 'full'){

        $('.cat .full-view').fadeIn(200);

    } else {

        $('.cat .full-view').fadeOut(200);
    }
});

    // Calls the selectBoxIt method on your HTML select box
      $("select").selectBoxIt({
        //theme: "jqueryui"
        });

    //Start toggle-info part in dashoard
    $('.toggle-info').on('click', function(){
        $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);

        if ($(this).hasClass('selected')){

            $(this).html('<i class="fas fa-minus"></i>')

        } else {

            $(this).html('<i class="fas fa-plus"></i>')
        }
    });


    //Show delete button in child Categories
    $('.child-link').hover(function(){
      $(this).find('.show-delete').fadeIn(100);
    }, function(){
      $(this).find('.show-delete').fadeOut(100);
    });

});
