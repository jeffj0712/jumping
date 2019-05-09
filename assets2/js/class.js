// JavaScript Document


//////////////////////////////////////////////////////////////////////////////////

var glob_edit_id = 0;

function add_class(event){
	
event.preventDefault();
			 
var cname = $("#cname").val().trim();
var begin_date = $("#date").val().trim();
var begin_time = $("#begin_time").val().trim();
var limit = $("#limit").val().trim();
// var cost = $("#cost").val().trim();
var cost=1;


var fdata = JSON.stringify({'ch' : 'add_class', 'data' : {'cname' : cname,  'begin_date' : begin_date, 'begin_time' : begin_time, 'limit' : limit, 'cost' : cost}}) ;

var sbutton = $("#sbutton").html(); //grab the initial content
$("#errmsg").html('');

$("#sbutton").html('<span class="fa fa-spin fa-spinner"></span> processing...');
   
   $.ajax({
	 type: "POST",
	 url:   "../connect/class.php",
	 data: fdata,
	 dataType: "json",
	 contentType: "application/json",
	 success: function(data){ console.log(data);
		     //dommie('2', '');
		     if(data['status'] == 'success'){
				 $("#sbutton").html('<span class="fa fa-sign-up text-success"> Class added successfully.  Redirecting....</span>');
                 $("form").trigger('reset');
				 window.location.replace("class.php");
			  }
			  else{
				$("#sbutton").html(sbutton);
                $("#errmsg").html(data['message']);
				//$("#errmsg")[0].scrollIntoView();
				
			  }
		    },
		  });	

}







function update_class(event){
	
		
event.preventDefault();
			 
var cname = $("#cname").val().trim();
var begin_date = $("#date").val().trim();
var begin_time = $("#begin_time").val().trim();
var limit = $("#limit").val().trim();
// var cost = $("#cost").val().trim();
var cost=1;

var fdata = JSON.stringify({'ch' : 'update_class', 'data' : {'id' : class_id, 'cname' : cname,  'begin_date' : begin_date, 'begin_time' : begin_time, 'limit' : limit, 'cost' : cost}}) ;
	
var sbutton = $("#sbutton").html(); //grab the initial content
$("#errmsg").html('');

$("#sbutton").html('<span class="fa fa-spin fa-spinner"></span> processing...');
   
   $.ajax({
	 type: "POST",
	 url:   "../connect/class.php",
	 data: fdata,
	 dataType: "json",
	 contentType: "application/json",
	 success: function(data){ console.log(data);
		     //dommie('2', '');
		     if(data['status'] == 'success'){
				 $("#sbutton").html('<span class="fa fa-sign-up text-success"> Class Updated successfully.  Redirecting....</span>');
                 $("form").trigger('reset');
				 window.location.replace("class.php");
			  }
			  else{
				$("#sbutton").html(sbutton);
                $("#errmsg").html(data['message']);
				//$("#errmsg")[0].scrollIntoView();
				
			  }
		    },
		  });	



}



	


function get_admin(pid){
	
 var fdata = JSON.stringify({'uid' : 'web', 'user' : 'username', 'ch' : 'get_admin', 'data' : {'admin_id' : pid}}) ;
dommie('1', 'please wait...');	
   $.ajax({
	 type: "POST",
	 url:   "./connect/admin_ad.php",
	 data: fdata,
	 dataType: "json",
	 contentType: "application/json",
	 success: function(data){ //console.log(data);
		     dommie('2', '');
		     if(data['status'] == 'success'){
			 glob_edit_id = data['data']['id'];
			 $("#admin_name").val(data['data']['admin_name']);
              $("#password").val(data['data']['password']);
			  }
			  else{
				window.location.replace("admin.php");
			  }
		    },
		  });	

}

 function delete_class(pid){
	 
	 var conf = confirm('Do you want to delete this Class?');
	 if(!conf) return;	 
  	
 var fdata = JSON.stringify({'ch' : 'delete_class', 'data' : {'cid' : pid}}) ;
dommie('1', 'please wait...');	
   $.ajax({
	 type: "POST",
	 url:   "../connect/class.php",
	 data: fdata,
	 dataType: "json",
	 contentType: "application/json",
	 success: function(data){ //console.log(data);
		     dommie('2', '');
		     if(data['status'] == 'success'){
			 $("#row_" + pid).remove();
			 myalert('Class Successfully deleted')
			 			   }
			  else{
				myalert('<span class="text-danger">' + data['message'] + '</span>');
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




