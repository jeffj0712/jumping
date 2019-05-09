// JavaScript Document
var g_rray = {};
var q_rray = {};
var m_rray = {};
var p_rray = [];

var glob_idn = 0;

function next_show(){
	
	if(glob_idn == 26){ //submit
	var mtxt = $("#ms_text").val().trim();
	if(mtxt.length > 2 && mtxt.length < 100) m_rray[12] = mtxt;
	if(m_rray.length == 0){myalert('???'); return;}
	
	var all_rray = [p_rray, m_rray, q_rray];
	submit_details(all_rray)
	return;
	}
	//first check if we are allow to proceed;
	if(checkmate(glob_idn)) return;
	
	
	if(glob_idn == 0){
		$("#base_button").hide();
		$("body").css('background-color', '#E6E6E6');
		}
	 else{
		$("#base_button").show();
		$("body").css('background-color', '#05F');
		}
	 if(glob_idn == 2){
		 
		 var aname = $("#aname").val().trim();
		 var bname = $("#bname").val().trim();
		 var email = $("#email").val().trim();
		 var altn = $("#altn").val().trim();
		 var phone = $("#phone").val().trim();
		 if(aname.length < 3 || aname.length > 100){ mytooltip('aname', '???'); return;}
		 if(bname.length < 3  || bname.length > 100){ mytooltip('bname', '???'); return;}
		 if(altn.length < 3 || altn.length > 100){ mytooltip('altn', '???'); return;}
		 if(email.length < 3 || email.length > 100){ mytooltip('email', '???'); return;}
		 if(!(/^[^\s()<>@,;:\/]+@\w[\w\.-]+\.[a-z]{2,}$/.test(email))) {mytooltip('email', '???'); return;}
		 
		 p_rray = [aname, bname, email, altn, phone];
		  
		 }
	
	//first check if we hv some things to coppo;
	
	$(".segment_b").hide();
	$(".segment_a").hide();
	$("#base_button").hide();
	
	
////sleakk	
 $.magnificPopup.open({
  items: {
    src: '<div style="width:100%; text-align:center" class="white-popup"><div style="width:auto; max-width:500px; display:inline-block; font-size:40px; background-color:transparent; color: #CCC"><i class="fa fa-spinner fa-spin"></i></div></div>', // can be a HTML string, jQuery object, or CSS selector
    type: 'inline'
  },
  fixedContentPos: true,
  closeOnBgClick : false,
});
	//glob_idn = 26; 
	glob_idn++; 
	
setTimeout(function(){
	$("#seg_" + glob_idn).css('display', 'inline-block');  //move to next show
	$("html, body").animate({scrollTop: 0}, "slow");
	if(glob_idn != 1)
	$("#base_button").show();
	if($("#seg_" + glob_idn).data('pr') != "0"){
		 $("#pgress").css('display', 'block');  //Show progress
         $("#pgress > div").css('width', $("#seg_" + glob_idn).data('pr'));
		 }
		 else{
			 $("#pgress").css('display', 'none');  //hide
			 }
$.magnificPopup.close();}, 500);		 
} 


$(document).ready(function(){
	  
	  $('input').val('');
	 $('.options_b input').prop('checked', false);
	 q_rray[24] = '0';  //set the default select
	 $("#single_sel").val('0');
	 
	
	$('.options_a').click(function(){
		
		var answr =  $(this).data('pos');
		var questn = $(this).parent().data('qn');
		$(this).parent().find('.options_a').css('background-color', '#FFF');
		q_rray[questn] = answr;
		$(this).css('background-color', '#0F0');
     
	 });
	 
	 $('.options_b').click(function(){
		
		var answr =  $(this).data('pos');
		var questn = $(this).parent().data('qn');
		$(this).parent().find('.options_b').css('background-color', '#CCC');
		$(this).parent().find('.options_b input').prop('checked', false);
		q_rray[questn] = answr;
		$(this).css('background-color', '#0F0');
		$(this).find('input').prop('checked', true);
     
	 });
	 
	 $('.options_c').click(function(){
		
		var answr =  $(this).data('pos');
		if(!(answr in m_rray)){ 
		m_rray[answr] = $(this).html();
		$(this).css('background-color', '#0F0');
		}
		else{
		 delete m_rray[answr];
		$(this).css('background-color', '#F0F0F0');	
			}
	 });
	 
});
 
 
  
 function set_sval(){
     q_rray[24] = $("#single_sel").val();	
}
 
 
 function checkmate(sid){
	 
    if($('#seg_' + sid + ' .question_a').length){
	   var	returnn = false;
       $('#seg_' + sid + ' .question_a').each(function(){ 
		var qn =  $(this).data('qn');
		if(!(qn in q_rray)){ myalert('???'); returnn = true;}
	 });
	   return returnn;
	   }
     
	 if($('#seg_' + sid + ' .question_b').length){
	   var	returnn = false;
       $('#seg_' + sid + ' .question_b').each(function(){
		var qn =  $(this).data('qn');
		if(!(qn in q_rray)){ myalert('???'); returnn = true;}
	 });
	   return returnn;
	   }

 }





function submit_details(z_rray){ 
    
	  var basic_d =  JSON.stringify(z_rray); 

dommie("1", "...");
	$.ajax({
	 type: "POST",
	 url:   "connect/details.php",
	 data: basic_d,
	 //dataType: "json",
	 contentType: "application/json",
	 success: function(data){ console.log(data); 
		 dommie("2", "");
	if(data == 'good'){
	$(".segment_b").hide();
	$(".segment_a").hide();
	$("#seg_27").css('display', 'inline-block');
	$("#base_button").hide();
	$("#pgress").css('display', 'none');  //hide 
	   }
	 else{
	 $(".segment_b").hide();
	$(".segment_a").hide();
	$("#seg_26").css('display', 'inline-block');
	$("#base_button").css('display', 'block');
	myalert('Error! Already taken');
		 
		 }
	   
		 }
}
	
	
	);
	  }









function myalert(messagez){
	//alert("jjjiii");
	
$.magnificPopup.close();

setTimeout(function(){
$.magnificPopup.open({
  items: {
    src: '<div style="width:100%; text-align:center" class="white-popup"><div style="width:auto; max-width:500px; display:inline-block; background-color:#EEE; padding:20px; color: #000; text-align:left">' + messagez + '</div></div>', // can be a HTML string, jQuery object, or CSS selector
    type: 'inline'
  }
}); }, 100);
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
			
					setTimeout(function(){$("#tooltip_" + kz).remove(); },5000);
		
		}


