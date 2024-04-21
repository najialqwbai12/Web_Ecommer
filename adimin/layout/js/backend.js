$(function(){
 'use strict';
    $('[placeholder]').focus(function (){
      $(this).attr('data-text', $(this).attr('placeholder'));
      $(this).attr('placeholder','');
 }).blur(function(){
    $(this).attr('placeholder',$(this).attr('data-text'));
 });
  
  $('.toggle-info').click(function(){
    $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);
      if($(this).hasClass('selected')){
        $(this).html('<i class="fa fa-minus fa-lg"></i>');
      } else{
         $(this).html('<i class="fa fa-plus fa-lg"></i>');
      }
  });


 $('input').each(function(){
   if($(this).attr('required') === ('required')){
      $(this).after('<span class="asterisk">*</span>');
   }
 });
  
     var passFiled=$('.password');
   
 $('.show-pass').hover(function(){
  passFiled.attr('type','text');
 }, function(){
  passFiled.attr('type','password');
 });

    $('.confirm').click(function(){
      return confirm('Ate You Sure?');
    });
    $('.cat h3').click(function(){
      $(this).next('.full-view').fadeToggle(200);
    });

    
    $('.option span').click(function(){
      $(this).addClass('active').sibling('span').removeClass('active');
      if($(this).data('view')==='full'){
         $('.cat .full-view').fadeIn(200);
      }else{
       $('.cat .full-view').fadeOut(200);
      }
    })
});