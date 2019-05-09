// JavaScript Document

var cflag_uid = 0;  var cflag = 0;
var ch_flag = '';  var headn_flag = '';
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


function add_new_content(headn, ch){
cflag = 0;
ch_flag = ch;
headn_flag = headn;
cflag_uid = 99999999999;
$("#course_btn").prop('disabled', false);
$("#reghead").html('<span class="fa fa-plus">  ADD New ' + headn + '</span>');
$("#course_btn").html('Add Content');
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



function edit_n(ch, nb, headn){
	
	cflag_uid = nb;
	ch_flag = ch;
    headn_flag = headn;
	cflag = 1
$("#course_btn").prop('disabled', false);

$("#reghead").html('<span class="fa fa-edit"> Edit ' + headn + '</span>');
$("#course_btn").html('Update Content');
$("#cform")[0].reset();

$("#cname").val($('#c_' + nb + ' td:eq(1)').html().trim());  

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
var ch = ch_flag;
var headn = headn_flag;			 
var cname = $("#cname").val().trim();
if(cname.length < 2){mytooltip('cname', 'Please enter a valid value'); return;}

var fdata = 'ch=' + ch + '&cname=' + encodeURIComponent(cname) + '&flag=' + cflag + '&uid=' + cflag_uid;
	 
	 $("#course_btn").html('<span class="fa fa-spin fa-spinner"></span>');
	 $("#course_btn").prop('disabled', true);
	 $.ajax({
	 type: "POST",
	 url:   "../connect/content_add.php",
	 data: fdata,
	 success: function(data){
		      if(cflag == 0)
			  $("#course_btn").html('<span class="fa fa-plus"> Add Content</span>');
			  else
			  $("#course_btn").html('<span> Update Content</span>');
	          $("#course_btn").prop('disabled', false);
	 
		     if(data.substr(0, 4) == 'PASS'){
				var rw_id =  data.substr(4);
				
				 if(cflag == 0){
			  $('table tr.headern').after('<tr style="background-color:#0F0" id="c_'+ rw_id + '">  <td>. new</td><td>' +  cname +  '</td>' +  '<td> <a class="edit_n" onClick="edit_n(\'' + ch + '\', ' + rw_id + ', \'' + headn + '\')">Edit</a> <a onClick="delete_n(\'' + ch + '\', ' + rw_id + ', \'' + headn + '\')" class="delete_n">Delete</a> </td></tr>');
		      myalert(headn + ' has been successfully added'); 
				 }else{
				 $('#c_' + rw_id + ' td:eq(1)').html(cname);
				 myalert(headn + ' has been successfully updated');
				 }
			  //location.reload();
			  }
			  else{
			   myalert(data); 
			  }
		    },
		  });	

}
		 



function delete_n(ch, nb, headn){
	
	var conf = confirm('Do you want to delete this ' + headn +'?');
	if(!conf)return;
	 dommie('1', '');
	 $.ajax({
	 type: "POST",
	 url:   "../connect/content_add.php",
	 data: "ch=" + ch + "&deletef=" + nb,
	 success: function(data){
		 dommie('2', '');
		      if(data == "PASS"){
				     $("#c_" + nb).remove();
					 myalert(headn + '  successfully deleted'); 
	                }
			  else{
				 myalert(data); 
			  }
		    },
		  });	
}


