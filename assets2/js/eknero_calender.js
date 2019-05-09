// JavaScript Document
//Events Calender  function by OSASA EMMANUEL  <<eknero>>

//var data_a = [2018, 09, [[1541617393, 'yes oooo.  It is happening', 1], [1541617363, 'yes oooo.  It is happening', 2]] ];   //sample test data


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

	




function get_calender_datas(month_n, year_n){
			 
 
  dommie("1", "");
   $.ajax({
	 type: "POST",
	 url:   "",
	 data: "usid=" + sid_ek + "&month_n=" + month_n + "&year_n=" + year_n,
	 dataType: "json",
	 success: function(data_a){   
		 dommie("2", "");   console.log(data_a);
var  dataz = data_a[2];
var  month = data_a[1];
var  year = data_a[0];


     var eventz = {};

	for(var izv = 0; izv < dataz.length; izv++){
		
	var	timestamp  = dataz[izv]['time'];
	var	sdata  = dataz[izv];
	
	
	var date_raw = new Date(timestamp * 1000);
	var daten =  date_raw.getDate();  // get the date
    
	var keyz =  year + "-" + month + "-" + daten;
	
    if(!(keyz in eventz)){
			eventz[keyz] = [];
			eventz[keyz].push([timestamp, sdata]);
			}
	 else
	 eventz[keyz].push([timestamp, sdata]);
	}

   $(".calender_container").html(draw_calender(month, year, eventz));

		  
		  
		  
		 }}
		
	);
}
		
		
function formatted_time(tm_stamp){
	var date = new Date(tm_stamp);
	var hour = date.getHours();
	var mins = date.getMinutes();
	var ampm = hour > 12 ? 'pm' : 'am';
	hour = hour % 12;
	hour = hour ? hour : 12;  //if hour is 0, it should be 12
	mins =  mins < 10 ? '0' + mins : mins;
	
	var fm_time = hour + " : " + mins + " " + ampm;
	
	return fm_time;
		}





function show_day(day_num){
	
   $.magnificPopup.open({
    items: {
    src: '#ls_day' + day_num,
    type: 'inline',
    },
   });
	}





function draw_calender(month, year, events){
	
	var days_m = [31, 28, 31, 30, 31, 30, 31, 31, 30 , 31, 30, 31];
	
	var month_m = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September' , 'Octomber', 'November', 'December'];
	
	/* draw parent div */
	var calender = '<div class="eknero_calender">';
	
	calender += '<div class="title_hd"><a class="a_prev" onClick="get_calender_datas(' + (month - 1) + ',' + year + ')" > << </a>' + month_m[month] + ',  ' + year +    '<a class="a_next" onClick="get_calender_datas(' + (month + 1) + ',' + year + ')" > >> </a></div>' ;
	
	var headings = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
	calender  +=  '<div class="calender_hd"><div>' + headings.join('</div><div>') + '</div></div>';
	
	//var running_day_tm = new Date(year, month, date, hour, mins, sec);
	var running_day_tm = new Date(year, month, 1, 0, 0, 0);
	
	running_day =   running_day_tm.getDay();  //the week day the month start 0 - 6
		
	var days_in_month = days_m[month];
	  if(year%4 == 0 && month == 1)  //if leap year
	  days_in_month = 29;
	
	var days_in_this_week = 1;
	
	var day_counter = 0;
	
	//var dates_array = array();
	
	//div for a week row
		calender += '<div class="calender_bd">';
	
	//We should print blank box till the first day of week 1
	for(var xb = 0; xb <  running_day; xb++){
		
		calender += '<div class="calender_blank">&nbsp;</div>';
		days_in_this_week++;
		}
	
	//now let us keep going with the days
		for(var list_day = 1; list_day <= days_in_month; list_day++){
		 
		 var eventday = year + "-" + month + "-" + list_day;
		 var event_present = false;
		 
		 if((eventday in events)){
			   //sort the day if posible
			   event_present = true
			  
			  var div_row = '<div id="ls_day' + list_day + '" class="white-popup mfp-hide eventday"><div class="pop_up_magc"><a class="close_magc fa fa-remove"></a><div class="day_heading">Day ' +list_day  + ',  ' +  month_m[month] + '  '  + year + '</div><div style="overflow-x: auto; width:100%"><table class="table table-responsive table-bordered table-striped table-hover" style="background-color:#FFF"><thead class="bg-light"><tr class="border-0"><th  class="border-0">Time</th><th class="border-0">Class Name</th><th  class="border-0">No. Available</th><th  class="border-0">No. Students</th><th  class="border-0">Cost  </th><th class="border-0"> Action </th></tr> </thead><tbody>';
			  var div_show = '';
			  
			  for(var izn = 0; izn < events[eventday].length; izn++){
				  var  event_n  =  events[eventday][izn];
				  
				  var timestamp_n = event_n[0];  var data_n = event_n[1];
				  var hour_n = formatted_time(timestamp_n*1000);  //time in millisecond
				  
				  div_row += '<tr id="row_' + data_n['id'] + '"><td>' + data_n['begin_time'] + '</td><td>' + data_n['cname'] + '</td><td>' + data_n['nlimit'] + '</td><td>' + data_n['cur_limit'] + ' (<a href="./class_members.php?id=' + data_n['id'] + '&ng=">View Members</a>)</td><td>' + data_n['cost'] + '</td><td>   <button onClick="delete_class(' + data_n['id'] + ')" style="float:right;" class="btn btn-danger">Delete</button><a target="_blank" style="float:right; margin-right:5px;" href="edit-class.php?pid=' + data_n['id'] + '&ref=" class="btn btn-info">Edit</a></td></tr>';
				  div_show += '<div class="div_show">' + data_n['cname']  + ' @ ' + data_n['cost']  + '</div>';
				    }
			     div_row += '</tbody></table></div></div></div>'; 
			  
			  calender += '<div class="calender_not_blank" style="background-color:#FFF; border: thin outset #0F0; cursor:pointer;" onClick="show_day(' + list_day + ')">&nbsp;<span class="number_day">' + list_day + '</span>'  + div_show + div_row + '</div>';		 
				 
				 }
	        
			
		if(event_present === false)
			   calender += '<div class="calender_not_not_blank">&nbsp;<span class="number_day">'+ list_day +  '<span></div>';
		   
	
	    if(running_day == 6){
				calender += '</div>'; //close the div for a week   
				if((day_counter + 1) != days_in_month)
				//div for a week row
		            calender += '<div class="calender_bd">'; 
				 
				 running_day = -1;
				 days_in_this_week = 0;
				}
			days_in_this_week++; running_day++;  day_counter++;
			
		   }//end of for loop .. list_day
	   
	   if(days_in_this_week < 8){
		   //We should print blank box till the last day of week 1
	for(var xb = 0; xb <=  (8 - days_in_this_week) ; xb++){
		
		calender += '<div class="calender_blank">&nbsp;</div>';
		
			}  
	   

	   }
	   
	   
	   calender += '</div>' ; //last div;
	      
	    return calender;
	
	}

