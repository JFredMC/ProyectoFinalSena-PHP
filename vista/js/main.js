$(document).ready(function(){
	$('#example').DataTable();
});

	/*  NAV LATERAL ACTION */
	
	const btn = document.querySelector('#menu-btn');
	const menu = document.querySelector('#sidemenu');
	btn.addEventListener('click', e =>{
		menu.classList.toggle("menu-expanded");
		menu.classList.toggle("menu-collapsed");

		document.querySelector('body').classList.toggle('body-expanded');
	});
	

	/*  Exit system buttom */
    

(function($){
    $(window).on("load",function(){
        $(".nav-lateral-content").mCustomScrollbar({
        	theme:"light-thin",
        	scrollbarPosition: "inside",
        	autoHideScrollbar: true,
        	scrollButtons: {enable: true}
        });
        $(".page-content").mCustomScrollbar({
        	theme:"dark-thin",
        	scrollbarPosition: "inside",
        	autoHideScrollbar: true,
        	scrollButtons: {enable: true}
        });
    });
})(jQuery);

$(function(){
  $('[data-toggle="popover"]').popover()
});



