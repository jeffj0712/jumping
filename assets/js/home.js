// JavaScript Document

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



function load_img(){
	 
	 var ext = $("#mfile").val().split('.').pop().toLowerCase()
	     if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1){
			 
			 mytooltip("mfile", "invalide Image type. accepted type are jpg, jpeg, png, gif");
			 return false;
			 } 
			 
			 
		var imaz = document.getElementById("mfile");  
        var vv = imaz.files[0];
        if(imaz.files != undefined){ 
	if(vv.size/1024 > (4000 )){
		mytooltip("mfile", "Maximum file size is 2000kb.  Current size is  " + (vv.size/(4024)).toFixed(3) + "kb");
	  return false;
			 }
		var sss = new FileReader();
        sss.onload = function() {
        $("#photo").prop("src", sss.result);
		 };
        sss.readAsDataURL(vv);

		}
	
	}











function submit_reg_form(event){
	
event.preventDefault();
			 
var fname = $("#fname").val().trim();
var phone = $("#phone").val();
var email = $("#email").val();	
var pwd = $("#pwd").val();
var pwd2 = $("#pwd2").val()
var courses = '';
var ic = 0;
 
if(pwd != pwd2 || pwd.length < 6){mytooltip('pwd', 'Please enter an appropriate login password'); return;}
if(fname.length < 4){mytooltip('fname', 'Please enter your Full Name'); return;}


event.preventDefault();
var fdata = new FormData($("#cform")[0]);
 
 
 var sbutton = $("#sbutton").html(); //grab the initial content
 $("#errmsg").html('');
 $("#sbutton").html('<span class="fa fa-spin fa-spinner fa-2x"></span> processing...');
 
 
	  	var opts = {
	 type: "POST",
	 url:   "connect/registration.php",
	 data: fdata,
	 cache: false,
	 contentType: false,
	 processData: false,
	 success: function(data){ //alert(data);
		 dommie("2", "");
		 if(data == "PASS"){   
		           
				 $("#sbutton").html('<span class="fa fa-sign-up fa-2x text-success">You have successfully registered. Click the login button to continue.</span><br><br><button type="button" style="min-width:150px" onClick="login_click()" class="btn btn-primary"><span></span> Log in</button>');
                 $("form").trigger('reset');
				  myalert('Registration  successfull. You can now login');
			          return;
		 }
		 else{
	           	$("#sbutton").html(sbutton)
               $("#errmsg").html(data['message']);
	
		myalert(data);
		return;
		 }
		    }
       };	
	
	if(fdata.fake){
		
		opts.xhr = function(){var xhr = $.ajaxSettings.xhr(); xhr.send = xhr.sendAsBinary; return xhr;}
		opts.contentType = "multipart/form-data; boundary="+fdata.boundary;
		opts.data = fdata.toString();
		
		}
	$.ajax(opts);

}
	
	


function submit_contact_form(event){

event.preventDefault();

var email_n  =  $("#email_n").val();
var name_n   =  $("#name_n").val();
var subject_n   =  $("#subject_n").val();
var message_n   =  $("#message_n").val();


if(name_n.length < 3 || name_n.length > 100){ mytooltip("name_n", "Please input a valid name"); return;}
if(subject_n.length < 4 || subject_n.length > 255){ mytooltip("subject_n", "Please input a valid subject"); return;}
if(message_n.length < 5 || message_n.length > 16380){ mytooltip("message_n", "Please input a valid message"); return;}


if(!(/^[^\s()<>@,;:\/]+@\w[\w\.-]+\.[a-z]{2,}$/.test(email_n))){
			   mytooltip("email_n", "Not a valid email address"); return;
  }

     var fdata = $("#form_n").serialize();			   
	 
	 dommie('1', '');
	 $.ajax({
	 type: "POST",
	 url:   "connect/contact_me.php",
	 data: fdata,
	 success: function(data){
	 dommie('2', '');
		 if(data == "good"){  
		   $("#message_report").html('<span style="color:#0C0; font-size:16px;">Your message has been received. </span>');
		   $("#form_n").trigger('reset');
		   var elmnt = document.getElementById("message_report");
           elmnt.scrollIntoView(); 
		   return;
		 }else{
			$("#message_report").html('<span style="color:#C00">' + data + '</span>');
			var elmnt = document.getElementById("message_report");
           elmnt.scrollIntoView();
			return;
		 }
		    },
		error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
       });	
			   

}




function login_click(){
	$('#rec_err').html('');
	$('#loghead').html(' Login');
	$('#rusername').hide();
	$('#lusername').show();
	$('#lpassword').show();
	$('#login_bxn').show();
	$('#recover_bxn').hide();
	$('#recover_link').show();	
	$.magnificPopup.open({
  items: {
    src: '#logbox', // can be a HTML string, jQuery object, or CSS selector
    type: 'inline',
	 },
});		
}


function recover_click(){
	$('#login_err').html('');
	$('#loghead').html(' Recover Password');
	$('#rusername').show();
	$('#lusername').hide();
	$('#lpassword').hide();
	$('#login_bxn').hide();
	$('#recover_link').hide();
	$('#recover_bxn').show();	
	$.magnificPopup.open({
  items: {
    src: '#logbox', // can be a HTML string, jQuery object, or CSS selector
    type: 'inline',
	 },
});		
}

function login_admin(){
	$.magnificPopup.open({
  items: {
    src: '#log_admin', // can be a HTML string, jQuery object, or CSS selector
    type: 'inline',
	 },
});		
}




function loginnow(){
	
	  var password = $('#lpassword').val();
	 var username = $('#lusername').val();
	 
	 if(password.length < 6){$('#login_err').html('incorrect password'); return;}
	 
	 if(!(/^[^\s()<>@,;:\/]+@\w[\w\.-]+\.[a-z]{2,}$/.test(username))){
		 $('#login_err').html('incorrect email address'); return;} 	
	
	 var fdata = 'login=yes&password=' + encodeURIComponent(password) + '&username=' + username;
	 dommie('1','');
	 $.ajax({
	 type: "POST",
	 url:   "./login.php",
	 data: fdata,
	 success: function(data){
		      dommie('2','');
		     if(data == 'PASS')
		      window.location.replace("./profile");
			  else{
			  $('#login_err').html(data); 
			  document.getElementById('loginlink').click();
			  }
		    },
		  });	
			   
}


function recovernow(){
	
	 var username = $('#rusername').val();
	 
	 if(username.length < 3){
		 $('#login_err').html('incorrect username or email'); return;} 	
	
	 var fdata = 'username=' + username;
	 dommie('1','');
	 $.ajax({
	 type: "POST",
	 url:   "connect/recover_password.php",
	 data: fdata,
	 success: function(data){
		      dommie('2','');
		     if(data == 'PASS')
		      myalert('We have sent a password recover link to your email address.<br>Kindly check your inbox.<br><br>Also check your spam folder if email is not in your inbox folder ');
			  else{
			  $('#rec_err').html(data); 
			  document.getElementById('recover_link').click();
			  }
		    },
		  });	
			   
}


function login_anow(){
	
	 var password = $('#apassword').val();
	 var username = $('#ausername').val();
	 
	 if(password.length < 6){$('#login_aerr').html('incorrect password'); return;}
	 
	
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
			  $('#login_aerr').html(data); 
			  document.getElementById('login_admin').click();
			  }
		    },
		  });	
			   
}





function password_change_form(event){
		
		event.preventDefault() //Prevent default form submission, we are using ajax to submit user details
	
	var token = $('#token').val();
	var pword1 = $('#pword1').val().trim();
	var pword2 = $('#pword2').val().trim();
	
	if(pwdmatch_2() == 0){  //check if password match with the pwdmatch() function
			 return;
			}
			
	
	var post_data = 'token=' + token + '&pword=' + pword1;
	
	dommie('1', '')//block screen
	
	//Ajax request to post registration details
	$.ajax({
	 type: "POST",
	 url:   "./password_recovery.php",
	 data: post_data,
	 success: function(data){ //console.log(data);
	      dommie('2', '')//unblock screen
		  if(data == 'PASS'){//registration was successful
			$('#recovery_report').html('<div style="padding:20px; background-color:#FFF; color:#0C0">Password changed successfully.  <a href="./" style="color:#090">Proceed to login</a> </div>'); 
			  }
		  else { //registration not successful
		     $('#recovery_report').html(data);
			  }
	 }
   });
		
}

function pwdmatch_2(){
   
   //function to check if password match or contain username

  var ptest = (document.getElementById("pword1").value).trim();
  var ptest2 = (document.getElementById("pword2").value).trim();
  var username = (document.getElementById("username").value).trim();
             if(ptest.length < 6){mytooltip("pword1", "Passsword is too short"); return 0; }
		   
		      if(ptest != ptest2 ){mytooltip("pword2", "Passsword not match");  return 0; }
			  if(ptest.indexOf(username) !== -1  || username.indexOf(ptest) !== -1){mytooltip("pword1", "password look unsecure. It should be different from your username"); return 0; }
       return 1;
	
	}
