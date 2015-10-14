(function($){
  var lastPos;

	$(document).ready(function(){

  // Handle clicking
  $('.atoz-clickable').click(function(){
    lastPos = $(window).scrollTop();
    $('.atoz-clickable').removeClass('atozmenu-on').addClass('atozmenu-off');
    $(this).removeClass('atozmenu-off').addClass('atozmenu-on');
    var alpha = $(this).data('alpha');
    location.hash = alpha;

    $('.glossary-atoz').removeClass('atozitems-on').addClass('atozitems-off');
    $('.glossary-atoz-' + alpha).removeClass('atozitems-off').addClass('atozitems-on');
  });

  // Manual hash change - trigger click
  $(window).bind('hashchange',function(event){
    var alpha = location.hash.replace('#','');
    $(window).scrollTop(lastPos);
    location.hash = alpha;
    $('.atoz-clickable').filter(function(i){return $(this).data('alpha') == alpha;}).click();
		$('.wpg2-please-select').hide();
  });

  // Page load hash management:
  //  - Look for first available if none specified
  //  - Trigger click if exists
  var myLocation = document.location.toString();
  var myAlpha    = '';
  if( myLocation.match('#') )
    myAlpha = myLocation.split('#')[1];
  if( ! myAlpha.length ){
    //myAlpha = $('.atoz-clickable:eq(0)').data('alpha');
		$('.atoz-clickable').removeClass('atozmenu-on').addClass('atozmenu-off');
		$('.glossary-atoz').removeClass('atozitems-on').addClass('atozitems-off');
		$('.wpg2-please-select').show();
	}
  if( myAlpha.length ){
		$('.wpg2-please-select').hide();
    $('.atoz-clickable').filter(function(i){return $(this).data('alpha') == myAlpha;}).click();
	}

	});
})(jQuery);
