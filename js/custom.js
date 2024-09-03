/*function resize_main_pane() {
	alert(1);
  var offset = $('#div_sections').offset(),
  remaining_height = parseInt($(window).height() - offset.top - 50);
  $('#div_sections').height(remaining_height);
}
*/

$(document).ready(function () {
	
	///////////////
/*
  resize_main_pane();
  $(window).resize(resize_main_pane);
*/
	///////////////
	
	
	
	
	
  var trigger = $('.hamburger'),
      overlay = $('.overlay'),
     isClosed = false;

    trigger.click(function () {
      hamburger_cross();      
    });

    function hamburger_cross() {

      if (isClosed == true) {          
        overlay.hide();
        trigger.removeClass('is-open');
        trigger.addClass('is-closed');
        isClosed = false;
      } else {   
        overlay.show();
        trigger.removeClass('is-closed');
        trigger.addClass('is-open');
        isClosed = true;
      }
  }
  
  $('[data-toggle="offcanvas"]').click(function () {
        $('#wrapper').toggleClass('toggled');
  });  
});