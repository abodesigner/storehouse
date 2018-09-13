$(function () {
    "use strict";

    // Hide placeholder on focus
       var $place;
       $(':input').on('focus', function(){
         $place = $(this).attr("placeholder");
         $(this).attr("placeholder","");
       });

    // Blur placeholder on focus
       $(':input').on('blur', function(){
         $(this).attr("placeholder",$place);
       });

    //Add asterix on required fields Function
       $('form').find('input').each(function(){
         if($(this).prop('required')){
            $(this).after("<span class='asterix'>*</span>");
          }
        });

        $('.confirm').on('click', function(){
          return confirm("Are you sure!");
        });

    // Calls the selectBoxIt method on your HTML select box
        $("select").selectBoxIt({
        // Uses the Twitter Bootstrap theme for the drop down
        // theme: "jqueryui"
          autoWidth: false
        });


        $('.login-page h1 span').click(function(){

          $(this).addClass('active').siblings().removeClass('active');
          $('.login-page form').hide();
          $('.' + $(this).data('class')).fadeIn(100);
        })


        //Live preview
        $('.live-name').keyup(function(){
          $('.live-preview .caption h3').text($(this).val());
        });

        $('.live-desc').keyup(function(){
          $('.live-preview .caption p').text($(this).val());
        });

        $('.live-price').keyup(function(){
          $('.live-preview .price-tag').text('$' + $(this).val());
        });

});
