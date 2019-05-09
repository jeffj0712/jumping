// JavaScript Document

var cflag_uid = 0;  var cflag = 0;

$(document).ready(function() {
$(".close_mag").click(function(){ $.magnificPopup.close(); });
});


function myalert(messagez){
	//alert("jjjiii");
	
$.magnificPopup.close();

setTimeout(function(){
$.magnificPopup.open({
  items: {
    src: '<div style="width:100%; text-align:center" class="white-popup"><a style="color:#FFF" class="fa fa-times close_mag"></a><div style="width:auto; max-width:500px; display:inline-block; background-color:#EEE; text-align:left; padding:20px; color: #000">' + messagez + '</div></div>', // can be a HTML string, jQuery object, or CSS selector
    type: 'inline'
  }
}); }, 500);
	}
	

function dommie(vasz, str){ 
	if(vasz == "1"){
$.magnificPopup.open({
  items: {
    src: '<div style="width:100%; text-align:center" class="white-popup"><div style="width:auto; max-width:500px; display:inline-block; font-size:40px; background-color:transparent; color: #CCC"><i class="fa fa-spinner fa-spin"></i>  ' + str + '</div></div>', // can be a HTML string, jQuery object, or CSS selector
    type: 'inline'
  }
}); 	}

    else $.magnificPopup.close();
	}

	
function mytooltip(kz, message){
		
       var valuez = '<div id="tooltip_' + kz + '" style=" position:relative; border: thin dotted #FFC; width:auto; padding: 5px; border-radius: 4px;" role="tooltip"><div style="position:absolute;width:0;height:0;border-color:transparent;border-style:solid; top:0;left:50%; margin-bottom: 10px; margin-left:-5px;border-width:5px 5px 5px 5px;border-top-color:#F50"></div><div style="background-color: transparent; color:#F00; font-size:12px; font-family:\'Times New Roman\', Times, serif; text-align:left">' + message + '</div></div>';
       $("#" + kz).after(valuez);
		//$("#" + kz).tooltip('show');
     		$("#" + kz).focus(); 
			
					setTimeout(function(){$("#tooltip_" + kz).remove(); },10000);
		
		}





//////////////////////////////////////////////////////////////////////////////////


function view_course(nb){
	myalert($('#c_' + nb + ' .section_course_desc').html());
	}


function add_new_course(){
cflag = 0;
cflag_uid = 99999999999;
$("#course_btn").prop('disabled', false);
$("#reghead").html('<span class="fa fa-plus"> New Course Addition</span>');
$("#course_btn").html('Add Course');
$("#cform")[0].reset();

$.magnificPopup.open({

  items: {
    src: '#cursebox', // can be a HTML string, jQuery object, or CSS selector
    type: 'inline',
	 },
	fixedContentPos: true,
	closeOnBgClick : false,
});

}




function submit_form(event){
	
event.preventDefault();
			 
var cname = $("#cname").val().trim();
var price = $("#price").val();
var duration = $("#duration").val();	
var seat = $("#seat").val();
var desc = $("#desc").val();
if(desc.length < 20){mytooltip('desc', 'Please enter description'); return;}
if(cname.length < 5){mytooltip('cname', 'Please enter Courde Name'); return;}

var fdata = 'price=' + price + '&duration=' + duration + '&seat=' + seat + '&cname=' + encodeURIComponent(cname) + '&desc=' + encodeURIComponent(desc) + '&flag=' + cflag + '&uid=' + cflag_uid;
	 
	 $("#course_btn").html('<span class="fa fa-spin fa-spinner"></span>');
	 $("#course_btn").prop('disabled', true);
	 $.ajax({
	 type: "POST",
	 url:   "connect/course_add.php",
	 data: fdata,
	 success: function(data){
		      if(cflag == 0)
			  $("#course_btn").html('<span class="fa fa-plus"> Add Course</span>');
			  else
			  $("#course_btn").html('<span> Update Course</span>');
	          $("#course_btn").prop('disabled', false);
	 
		     if(data == 'PASS'){
				 if(cflag == 0)
		      myalert('Course has been successfully added and is currently active');
			     else
				 myalert('Course has been successfully updated');
			  location.reload();
			  }
			  else{
			   myalert(data); 
			  }
		    },
		  });	

}
		 

function open_cmenus(nb){
	if($('#c_' + nb + ' .section_course_menu_item').css('display') == 'none'){
	$('.section_course_menu_item').css('display', 'none');
	$('#c_' + nb + ' .section_course_menu_item').css('display', 'block');
	}
	else{
		$('.section_course_menu_item').css('display', 'none');
		}
}


function edit_cmenus(nb){
	
	cflag_uid = nb;
	
	cflag = 1
$("#course_btn").prop('disabled', false);

$("#reghead").html('<span class="fa fa-edit"> Edit Course</span>');
$("#course_btn").html('Update Course');
$("#cform")[0].reset();

$("#cname").val($('#c_' + nb + ' .section_course_hd').html().trim());  
$("#price").val($('#c_' + nb + ' .section_course_tb tr:eq(1) td:eq(2)').html().trim());
$("#duration").val($('#c_' + nb + ' .section_course_tb tr:eq(1) td:eq(0)').html().trim());	
$("#seat").val($('#c_' + nb + ' .section_course_tb tr:eq(1) td:eq(1)').html().trim());
var desc = $("#desc").val($('#c_' + nb + ' .section_course_desc > p').html().trim());

$.magnificPopup.open({

  items: {
    src: '#cursebox', // can be a HTML string, jQuery object, or CSS selector
    type: 'inline',
	 },
	fixedContentPos: true,
	closeOnBgClick : false,
});

}

function resume_pause(nb, flag){
	
	var adata = {0 : '', 1:''};
	
	var rpaus_0 = '<a onClick="resume_pause(' + nb + ', 0)" class="fa fa-pause"> Pause</a>';
	var rpaus_1 = '<a onClick="resume_pause(' + nb + ', 1)" class="fa fa-play"> Resume</a>';
	var rps_1  =  '<span class="text-danger"> Paused </span>';
	var rps_0  =  '<span class="text-success"> Active </span>';
	
	 $("#c_" + nb + " .section_course_pr").html('<span class="fa fa-spin fa-spinner"></span>');
	 $("#c_" + nb + " .section_course_menu_item > div:eq(1)").html('<span class="fa fa-spin fa-spinner"></span>');
	 
	 $.ajax({
	 type: "POST",
	 url:   "connect/course_add.php",
	 data: "dataf=" + flag + "&uid=" + nb,
	 success: function(data){
		      if(data == "PASS"){
				  if(flag == 0){
			         $("#c_" + nb + " .section_course_pr").html(rps_1);
	                 $("#c_" + nb + " .section_course_menu_item > div:eq(1)").html(rpaus_1);		  
					  }
				  else{
					  $("#c_" + nb + " .section_course_pr").html(rps_0);
	                 $("#c_" + nb + " .section_course_menu_item > div:eq(1)").html(rpaus_0);
					  }
				  
				  }
			  else{
				if(flag == 1){
			         $("#c_" + nb + " .section_course_pr").html(rps_1);
	                 $("#c_" + nb + " .section_course_menu_item > div:eq(1)").html(rpaus_1);		  
					  }
				  else{
					  $("#c_" + nb + " .section_course_pr").html(rps_0);
	                 $("#c_" + nb + " .section_course_menu_item > div:eq(1)").html(rpaus_0);
					  }
			   myalert(data); 
			  }
		    },
		  });	
}




function delete_course(nb){
	
	var conf = confirm('Do you want to delete this course?');
	if(!conf)return;
	 
	 $.ajax({
	 type: "POST",
	 url:   "connect/course_add.php",
	 data: "deletef=" + nb,
	 success: function(data){
		      if(data == "PASS"){
				     $("#c_" + nb).remove();
					 myalert('Course successfully deleted'); 
	                }
			  else{
				 myalert(data); 
			  }
		    },
		  });	
}


function register_click(){
	
	$.magnificPopup.open({
	items: {
    src: '#regbox', // can be a HTML string, jQuery object, or CSS selector
    type: 'inline',
	 },
	fixedContentPos: true,
	closeOnBgClick : false,
});
	}
	
	
	

function login_admin(){
	
	  var password = $('#lpassword').val();
	 var username = $('#lusername').val();
	 
	 if(password.length < 6){$('#login_err').html('incorrect password'); return;}
	 
	 
	 var fdata = 'login_admin=yes&password=' + encodeURIComponent(password) + '&username=' + username;
	 dommie('1','');
	 $.ajax({
	 type: "POST",
	 url:   "./login.php",
	 data: fdata,
	 success: function(data){
		      dommie('2','');
		     if(data == 'PASS')
		      window.location.replace("./admin.php");
			  else{
			  $('#login_err').html(data); 
			  }
		    },
		  });	
			   
}
