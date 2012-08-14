jQuery(document).ajaxStart(function(){
	$(".loader").show();
	
});
jQuery(document).ajaxStop(function(){
	$(".loader").hide();
});

$(document).ready(function() {
  $(".more").hide();
  //toggle the componenet with class msg_body
  $(".heading").click(function()
  {
    $(this).next(".more").slideToggle(500);
  });
  
  
  //Show writer info
     $("#showwriters").click(function () {
      $('.showwriter').each(function (i) {
		  	if($(this).hasClass('expanded')){
		  		$('#'+this.id+'').load('ajax.php?action=hidewriter');	
		  		$(this).removeClass('expanded');
		  	}
		  	else{
		  		$(this).addClass('expanded');
		  		$('#'+this.id+'').load('ajax.php?action=showwriter&id='+this.id);	
		  	}
      });
    });
    
    //Show comments
    $("#showcomments").click(function () {
      $('.showcomment').each(function (j) {
		  	if($(this).hasClass('expanded'))
		  	{
		  		$('#'+this.id+'').load('ajax.php?action=hidecomments');	
		  		$(this).removeClass('expanded');

		  	}
		  	else
		  	{
		  		$(this).addClass('expanded');
		  		$('#'+this.id+'').load('ajax.php?action=fetchcomments&id='+this.id);	
		  	}
      });
    });
    
    $("#comment_click").click(function () {
    $('#comment').attr('checked', true);
    $('#write_arrow').css('right','306px');
    });
    
    $("#write_click").click(function () {
    $('#write').attr('checked', true);
    $('#write_arrow').css('right','425px');
    });
    
    $("#block_click").click(function () {
    $('#block').attr('checked', true);
    $('#write_arrow').css('right','186px');
    });
    
    $("#changewriter_click").click(function () {
    $('#edit_writer').css('right','380px');
    });
    
    // TODO Use jQuery offset() to place the arrow correctly
    $("#do_new_char").click(function () {
	    $('#do_new_arrow').css('right','380px');
	    $('#do_new_stuff').load('ajax.php?action=newcharacter');
    });

    // TODO Use jQuery offset() to place the arrow correctly    
    $("#do_new_chronicle").click(function () {
	    $('#do_new_arrow').css('right','252px');
	    $('#do_new_stuff').load('ajax.php?action=newchronicle');
    });
    
   	$(".edit_a_post").click(function () {
	    $('#do_new_arrow').css('right','252px');
	    $('#do_new_stuff').load('ajax.php?action=editpost');
    });
	
	$("#filter").click(function () {
	    $('#filter_search').load('functions/filter_search_ajax.php?site='+$('#filter').attr('title'));
    });
    
	$('textarea').autoResize();
	
	$("#categories").autocomplete('functions/autocomplete.php', {
		multiple: true,
		mustMatch: false,
		autoFill: false
	});
	
	$(".toplogo").click(function () {
		 window.location.href = "http://skrivihop.net";
	});
	
	

});




