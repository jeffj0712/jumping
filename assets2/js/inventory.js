// JavaScript Document


//////////////////////////////////////////////////////////////////////////////////

var glo_del = 0;

function add_hostname(event){
	
event.preventDefault();
	
var hostn = $("#host").val().trim();
var ipn = $("#ip").val().trim();	
var locationn = $("#location").val().trim();	
var scanner_md = $("#scanner_md").val().trim();	
var screen_md = $("#screen_md").val().trim();
var camera_md = $("#camera_md").val().trim();		
var pc_md = $("#pc_md").val().trim();	
var scanner_sn = $("#scanner_sn").val().trim();	
var screen_sn = $("#screen_sn").val().trim();
var camera_sn = $("#camera_sn").val().trim();		
var pc_sn = $("#pc_sn").val().trim();
var cabinet_sn = $("#cabinet_sn").val().trim();	
var b_cvl_fm = $("#b_cvl_fm").val().trim();	
var b_cvl_to = $("#b_cvl_to").val().trim();	
var b_cr_fm = $("#b_cr_fm").val().trim();	
var b_cr_to = $("#b_cr_to").val().trim();	
var b_mil_fm = $("#b_mil_fm").val().trim();	
var b_mil_to = $("#b_mil_to").val().trim();	
var b_emp_fm = $("#b_emp_fm").val().trim();	
var b_emp_to = $("#b_emp_to").val().trim();	
var b_qa_fm = $("#b_qa_fm").val().trim();	
var b_qa_to = $("#b_qa_to").val().trim();	


if(parseInt(b_cvl_fm, 10) >  parseInt(b_cvl_to, 10)){mytooltip('b_cvl_fm', 'Entry not appropriate'); return;};
if(parseInt(b_cr_fm, 10) >  parseInt(b_cr_to, 10)){mytooltip('b_cr_fm', 'Entry not appropriate'); return;};
if(parseInt(b_mil_fm, 10) >  parseInt(b_mil_to, 10)){mytooltip('b_mil_fm', 'Entry not appropriate'); return;};
if(parseInt(b_emp_fm, 10) >  parseInt(b_emp_to, 10)){mytooltip('b_emp_fm', 'Entry not appropriate'); return;};
if(parseInt(b_qa_fm, 10) >  parseInt(b_qa_to, 10)){mytooltip('b_qa_fm', 'Entry not appropriate'); return;};



var fdata = JSON.stringify({'ch' : 'add_hostname', 'data' : {'hostname' : hostn, 'ip' : ipn, 'location' : locationn, 'scanner_md' : scanner_md, 'screen_md' : screen_md, 'camera_md' : camera_md, 'pc_md' : pc_md, 'scanner_sn' : scanner_sn, 'screen_sn' : screen_sn, 'camera_sn' : camera_sn, 'pc_sn' : pc_sn, 'cabinet_sn' : cabinet_sn, 'b_cvl_fm' : b_cvl_fm, 'b_cvl_to' : b_cvl_to, 'b_cr_fm' : b_cr_fm, 'b_cr_to' : b_cr_to, 'b_mil_fm' : b_mil_fm, 'b_mil_to' : b_mil_to, 'b_emp_fm' : b_emp_fm, 'b_emp_to' : b_emp_to, 'b_qa_fm' : b_qa_fm, 'b_qa_to' : b_qa_to}}) ;
	
var sbutton = $("#sbutton").html(); //grab the initial content
$("#errmsg").html('');

$("#sbutton").html('<span class="fa fa-spin fa-spinner fa-2x"></span> please wait...');
//$('.card-footer').hide();
   
   $.ajax({
	 type: "POST",
	 url:   "connect/hostname.php",
	 data: fdata,
	 //dataType: "json",
	 contentType: "application/json",
	 success: function(data){ console.log(data);
		     //dommie('2', '');
		     if(data == 'PASS'){
				 $("#sbutton").html('<span class="fa fa-check text-success"> New Machine added successfully .....</span><br><br>' + sbutton);
                  $("form").trigger('reset');
				 //window.location.replace("recent_inventory.php");
			  }
			  else{
				$("#sbutton").html(sbutton);
                $("#errmsg").html(data);
				
			  }
		    },
		  });	

}




function update_hostname(event){
	
event.preventDefault();
	
var hostn = $("#host").val().trim();
var ipn = $("#ip").val().trim();	
var locationn = $("#location").val().trim();	
var scanner_md = $("#scanner_md").val().trim();	
var screen_md = $("#screen_md").val().trim();
var camera_md = $("#camera_md").val().trim();		
var pc_md = $("#pc_md").val().trim();	
var scanner_sn = $("#scanner_sn").val().trim();	
var screen_sn = $("#screen_sn").val().trim();
var camera_sn = $("#camera_sn").val().trim();		
var pc_sn = $("#pc_sn").val().trim();
var cabinet_sn = $("#cabinet_sn").val().trim();	
var b_cvl_fm = $("#b_cvl_fm").val().trim();	
var b_cvl_to = $("#b_cvl_to").val().trim();	
var b_cr_fm = $("#b_cr_fm").val().trim();	
var b_cr_to = $("#b_cr_to").val().trim();	
var b_mil_fm = $("#b_mil_fm").val().trim();	
var b_mil_to = $("#b_mil_to").val().trim();	
var b_emp_fm = $("#b_emp_fm").val().trim();	
var b_emp_to = $("#b_emp_to").val().trim();	
var b_qa_fm = $("#b_qa_fm").val().trim();	
var b_qa_to = $("#b_qa_to").val().trim();
var hid = $("#hid").val().trim();	


if(parseInt(b_cvl_fm, 10) >  parseInt(b_cvl_to, 10)){mytooltip('b_cvl_fm', 'Entry not appropriate'); return;};
if(parseInt(b_cr_fm, 10) >  parseInt(b_cr_to, 10)){mytooltip('b_cr_fm', 'Entry not appropriate'); return;};
if(parseInt(b_mil_fm, 10) >  parseInt(b_mil_to, 10)){mytooltip('b_mil_fm', 'Entry not appropriate'); return;};
if(parseInt(b_emp_fm, 10) >  parseInt(b_emp_to, 10)){mytooltip('b_emp_fm', 'Entry not appropriate'); return;};
if(parseInt(b_qa_fm, 10) >  parseInt(b_qa_to, 10)){mytooltip('b_qa_fm', 'Entry not appropriate'); return;};



var fdata = JSON.stringify({'ch' : 'update_hostname', 'id' : hid, 'data' : {'hostname' : hostn, 'ip' : ipn, 'location' : locationn, 'scanner_md' : scanner_md, 'screen_md' : screen_md, 'camera_md' : camera_md, 'pc_md' : pc_md, 'scanner_sn' : scanner_sn, 'screen_sn' : screen_sn, 'camera_sn' : camera_sn, 'pc_sn' : pc_sn, 'cabinet_sn' : cabinet_sn, 'b_cvl_fm' : b_cvl_fm, 'b_cvl_to' : b_cvl_to, 'b_cr_fm' : b_cr_fm, 'b_cr_to' : b_cr_to, 'b_mil_fm' : b_mil_fm, 'b_mil_to' : b_mil_to, 'b_emp_fm' : b_emp_fm, 'b_emp_to' : b_emp_to, 'b_qa_fm' : b_qa_fm, 'b_qa_to' : b_qa_to}}) ;
	
var sbutton = $("#sbutton").html(); //grab the initial content
$("#errmsg").html('');

$("#sbutton").html('<span class="fa fa-spin fa-spinner fa-2x"></span> please wait...');
//$('.card-footer').hide();
   
   $.ajax({
	 type: "POST",
	 url:   "connect/hostname.php",
	 data: fdata,
	 //dataType: "json",
	 contentType: "application/json",
	 success: function(data){ console.log(data);
		     //dommie('2', '');
		     if(data == 'PASS'){
				 $("#sbutton").html('<span class="fa fa-check text-success">  Machine has been updated</span><br><br>' + sbutton);
                  ///$("form").trigger('reset');
				 //window.location.replace("recent_inventory.php");
			  }
			  else{
				$("#sbutton").html(sbutton);
                $("#errmsg").html(data);
				
			  }
		    },
		  });	

}






function view_hostname(id){
	 glo_del = id;
	$("#ref_linker").prop('href', './update_machine.php?refid=' + id + '&gl=');
	for(var iz = 0; iz < 22; iz++){
		if(iz == 0)
$('#sing_c td:eq(' + iz + ')').html($('#c_' + id + ' td:eq(' + (iz + 1 )+ ')').data('host'));
    else
$('#sing_c td:eq(' + iz + ')').html($('#c_' + id + ' td:eq(' + (iz + 1 )+ ')').html());
	}

$.magnificPopup.open({

  items: {
    src: '#cursebox', // can be a HTML string, jQuery object, or CSS selector
    type: 'inline',
	 },
	fixedContentPos: true,
	closeOnBgClick : false,
});

}





 function delete_machine(){
	 
	 var conf = confirm('Do you want to delete this Machine ?');
	 if(!conf) return;	 
  	
 var fdata = JSON.stringify({'ch' : 'delete_machine', 'data' : {'machine_id' : glo_del}}) ;
dommie('1', 'please wait...');	
   $.ajax({
	 type: "POST",
	 url:   "./connect/hostname.php",
	 data: fdata,
	 dataType: "json",
	 contentType: "application/json",
	 success: function(data){ //console.log(data);
		     dommie('2', '');
		     if(data['status'] == 'success'){
			 $("#c_" + glo_del).remove();
			 myalert('machine Successfully deleted')
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




