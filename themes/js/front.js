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

        });

        $('.login-page h1 span').click(function(){
          $(this).addClass('active').siblings().removeClass('active');
          $('.login-page form').hide();
          $('.' + $(this).data('class')).fadeIn(100);
        });



       // Ad live-preview for Name, Description & Price.
       // Custom-attibute function
       $('.live').keyup(function(){
         $($(this).data('class')).text($(this).val());
       });




});
