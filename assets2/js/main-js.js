// JavaScript Document


//////////////////////////////////////////////////////////////////////////////////

var glob_edit_id = 0;

 function reserve_class(pid){
	 
	 var conf = confirm('Do you want to make reservation now?');
	 if(!conf) return;	 
  	
 var fdata = JSON.stringify({'ch' : 'reserve_class', 'data' : {'cid' : pid}}) ;
dommie('1', 'please wait...');	

   $.ajax({
	 type: "POST",
	 url:   "../connect/main.php",
	 data: fdata,
	 dataType: "json",
	 contentType: "application/json",
	 success: function(data){ //console.log(data);
		     dommie('2', '');
		     if(data['status'] == 'success'){
			 $("#row_" + pid).remove();
			 myalert('Class Successfully Reserved')
			 			   }
			  else{
				myalert('<span class="text-danger">' + data['message'] + '</span>');
			  }
		    },
		  });	
	 
	 
	 
	 
	 }




function cancel_reservation(pid){
	 
	 var conf = confirm('Do you want to cancel this reservation?');
	 if(!conf) return;	 
  	
 var fdata = JSON.stringify({'ch' : 'cancel_reserve', 'data' : {'rid' : pid}}) ;
dommie('1', 'please wait...');	
   $.ajax({
	 type: "POST",
	 url:   "../connect/main.php",
	 data: fdata,
	 dataType: "json",
	 contentType: "application/json",
	 success: function(data){ //console.log(data);
		     dommie('2', '');
		     if(data['status'] == 'success'){
			 $("#row_" + pid).remove();
			 myalert('Reservation Successfully cancel')
			 			   }
			  else{
				myalert('<span class="text-danger">' + data['message'] + '</span>');
			  }
		    },
		  });	
	 
	 
	 
	 
	 }




 function change_password(event){
	 
event.preventDefault();

 var pwd = $("#password").val().trim();	 
 var pwd1 = $("#password1").val().trim();	 
 var pwd2 = $("#password2").val().trim();	 	
	
	 if(pwd1 != pwd2 || pwd1.length < 6){mytooltip('password1', 'Please enter an appropriate login password'); return;	} 
  	
 var fdata = JSON.stringify({'ch' : 'change_password', 'data' : {'pwd' : pwd, 'pwd1' : pwd1, 'pwd2' : pwd2}}) ;


var sbutton = $("#sbutton").html(); //grab the initial content
$("#errmsg").html('');

$("#sbutton").html('<span class="fa fa-spin fa-spinner"></span> processing...');
   
   $.ajax({
	 type: "POST",
	 url:   "../connect/main.php",
	 data: fdata,
	 dataType: "json",
	 contentType: "application/json",
	 success: function(data){ //console.log(data);
		     //dommie('2', '');
		     if(data['status'] == 'success'){
				 $("#sbutton").html('<span class="fa fa-sign-up text-success">password changed successfully.  Redirecting....</span>');
                $("form").trigger('reset');
				window.location.replace("./");
			  }
			  else{
				$("#sbutton").html(sbutton);
                $("#errmsg").html(data['message']);
				//$("#errmsg")[0].scrollIntoView();
				
			  }
		    },
		  });		 
	 
	 
	 
	 }






$(document).ready(function() {
$(".close_mag").click(function(){ $.magnificPopup.close(); });

	
	});





function myalert(messagez){
	//alert("jjjiii");
	
$.magnificPopup.close();

setTimeout(function(){
$.magnificPopup.open({
  items: {
    src: '<div style="width:100%; text-align:center" class="white-popup"><div style="width:auto; max-width:500px; display:inline-block; background-color:#EEE; text-align:left; padding:20px; color: #000">' + messagez + '</div></div>', // can be a HTML string, jQuery object, or CSS selector
    type: 'inline'
  },
}); }, 500);
	}
	

function dommie(vasz, str){ 
	if(vasz == "1"){
$.magnificPopup.open({
  items: {
    src: '<div style="width:100%; text-align:center" class="white-popup"><div style="width:auto; max-width:500px; display:inline-block; font-size:40px; background-color:transparent; color: #CCC"><i class="fa fa-spinner fa-spin"></i>  ' + str + '</div></div>', // can be a HTML string, jQuery object, or CSS selector
    type: 'inline'
  },
  fixedContentPos: true,
  closeOnBgClick : false,
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




