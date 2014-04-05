<?php require_once('Connections/cboxConn.php'); ?>
<?php
session_start();
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_getUserBenchmarks = "-1";
if (isset($_SESSION['MM_UserID'])) {
  $colname_getUserBenchmarks = $_SESSION['MM_UserID'];
}
########
#REMOVE ME
########
if (!(isset($_SESSION['MM_UserID']))) {
  $colname_getUserBenchmarks = 1;
  $_SESSION['MM_Username']= "persinac";
}
mysql_select_db($database_cboxConn, $cboxConn);

###
# Defualt view is Crossfit->Foundamental benchmarks
###
$movement_id = "cft";
$query_getUserCFBenchmarks = "select bs.mvmnt_id, bs.weight, bs.date_achieved from benchmarks bs join (select user_id, mvmnt_id, max(weight) weight from benchmarks 
	group by user_id, mvmnt_id) bb on bs.mvmnt_id = bb.mvmnt_id AND bs.weight = bb.weight
WHERE bs.user_id = $colname_getUserBenchmarks AND bs.mvmnt_id LIKE '{$movement_id}%' 
ORDER BY bs.mvmnt_id ";
$getUserCFBenchmarks = mysql_query($query_getUserCFBenchmarks, $cboxConn) or die(mysql_error());
#$rows = mysql_fetch_assoc($getUserBenchmarks);
$totalRows_getUserBenchmarks = mysql_num_rows($getUserCFBenchmarks);


	if(!(isset($_SESSION['MM_Username'])))
	{
		header("Location: Error401UnauthorizedAccess.php");
	}
	
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Progress</title>
	<!-- Custom styles for this template -->
    <link href="dist/css/user_progress_page.css" rel="stylesheet">
</head>


<body>
<div id="container">
<div id="rect_one"></div>
<div id="rect_two"></div>
<div id="navbar_main">
  <ul id="navbar_main_ul"> 
	<li id="home" ><a href="#" >HOME</a></li> 
	<li id="compare"><a href="#" >COMPARE</a></li> 
	<li id="wod"><a href="#" >WOD</a></li> 
	<li id="progress" class="active"><a href="#" >PROGRESS</a></li> 
	<li id="account" ><a href="#" >ACCOUNT</a></li> 
  </ul> 
</div>

<div id="navbar_sub"> 
  <ul id="navbar_sub_ul"> 
	<li id="cft_lnk" ><a href="#" >CROSSFIT</a></li> 
	<li id="oly_lnk"><a href="#" >OLYMPIC</a></li> 
	<li id="pwr_lnk"><a href="#" >POWERLIFTING</a></li> 
	<li id="mis_lnk" ><a href="#" >MISC</a></li> 
  </ul> 
</div>

<div id="sidebar">
	<ul id="sidebar_ul">

    </ul>
</div>

<div id="image_div">
<img src="images/progress_page/PROGRESS_PAGE_CFAPP_template.jpg" width="1224" height="792" alt=""/>
</div>
<div id="data_container">
	

</div> <!-- END data_container -->
</div> <!-- END div_container -->

	<!-- JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
   
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script id="source" language="javascript" type="text/javascript">

	$(document).ready(function() {
		addDivSeparators();
			$("#navbar_sub_ul li").click(function() {
				event.preventDefault();
				var id = jQuery(this).attr("id");
				//empty the tables
				$('.sec1_body').empty();
				$('.sec2_body').empty();
				$('.sec3_body').empty();
				isActive(id);
				setSideBar(id);
				//getData(id);
			});	
		});
		
		$("#sidebar_ul").on("click", "li", function() {
			event.preventDefault();
			var id = jQuery(this).attr("id");
			//alert("SideBar click, ID: " + id);
			if(id == "wod")
			{
				remDivSeparators();	
			}
			else
			{
				addDivSeparators();
			}
			getData(id);
    	});	

function addDivSeparators()
{
	if($('#rect_one').hasClass('rect_divider_one') == true) {
		//do nothing
	}
	else if($('#rect_one').hasClass('rect_divider_one') == false) {
		//add separators
		$('#rect_one').addClass('rect_divider_one');
		$('#rect_two').addClass('rect_divider_two');
	}

}

function remDivSeparators()
{
	if($('#rect_one').hasClass('rect_divider_one') == true) {
		$('#rect_one').removeClass('rect_divider_one');
		$('#rect_two').removeClass('rect_divider_two');
	}
	else if($('#rect_one').hasClass('rect_divider_one') == false) {
		//do nothing
	}

}

function isActive(anID) {
	var listItems = $("#navbar_sub_ul li");
	listItems.each(function(i, li)
	{
    	$(li).removeClass('active');
  	});
  setActive(anID);
  
}

function setActive(anID) {
	$('#'+anID).addClass('active');
	$('#'+anID+" a").addClass('a');
}

function changeTextColorOfTables() {
 $('tr:odd').addClass('alt');
}

  function getData(movement_id) 
  {
	  var html = "";
    //Send HTTP request and call file based on movement_id
	if(movement_id == "cft")
	{
		//create html here:
		html += "<div id=\"cft_foundamentals_sec1_div\">";
		html +=" <table class=\"cft_foundamentals_sec1\">";
		html +=" <tbody class=\"sec1_body\">"; 	
        html +=" </tbody>";
		html +=" </table></div><div id=\"cft_foundamentals_sec2_div\">";
		html +=" <table class=\"cft_foundamentals_sec2\">";
		html +=" <tbody class=\"sec2_body\"></tbody></table></div>";
		html +=" <div id=\"cft_foundamentals_sec3_div\">";
		html +=" <table class=\"cft_foundamentals_sec3\">";
		html +=" <tbody class=\"sec3_body\">";
		html +=" </tbody></table></div>";
    
		$('#data_container').html(html);
		
		$.ajax({ 
		  type:"POST",                                     
		  url: "php_json_test.php", //the script to call to get data          
		  data: { dataString: movement_id }, //you can insert url argumnets here to pass to api.php
		  dataType: "json",                //data format      
		  success: function(response) //on recieve of reply
		  {
			  //alert(movement_id);
			loadCFTData(response);
		  } 
		});
	}
	else if(movement_id =="wod")
	{
		$('.sec1_body').empty();
		$('.sec2_body').empty();
		$('.sec3_body').empty();
		
		
		html += "<div id=\"cft_wod_div\">";
		html += "<table class=\"cft_wods\">";
		html += "<tbody class=\"wods_table_body\">";
		html += "</tbody>";
		html += "</table>";
		html += "</div>";
	
		//alert("HTML: " + html )
		$('#data_container').html(html);
		
		//now load data into table
		$.ajax({ 
			  type:"POST",                                     
			  url: "getUserWODs.php", //the script to call to get data          
			  //data: { dataString: movement_id }, //you can insert url argumnets here to pass to api.php
			  dataType: "json",                //data format      
			  success: function(response) //on recieve of reply
			  {
				  //alert(movement_id);
				loadCFTWODData(response);
			  } 
			});
		
	}
  } 
  
  function loadCFTData(data)
  {
		var html_sec1 = "";
		var html_sec2 = "";
		var html_sec3 = "";
		var sec1_classID = "sec1_data"; 
		var sec2_classID = "sec2_data";
		var sec3_classID = "sec3_data";
		var w = "w_";             //get id
		var vname;           //get name
		for(var i = 0; i < data.length; i++) {
			vname = nameOfMovement(data[i].mvmnt_id);
			if(i <= 2) {
					html_sec1 += "<tr class="+sec1_classID+"><td>"+
						vname+"</td><td>"+data[i].weight+"</td></tr>";
			} else if (i > 2 && i <= 5) {
				html_sec2 += "<tr class="+sec2_classID+"><td>"+
						vname+"</td><td>"+data[i].weight+"</td></tr>";
			}
			else {
				html_sec3 += "<tr class="+sec3_classID+"><td>"+
						vname+"</td><td>"+data[i].weight+"</td></tr>";
			}
		}
		//Update html content
		$('.sec1_body').empty();
		$('.sec1_body').html(html_sec1);
		$('.sec2_body').empty();
		$('.sec2_body').html(html_sec2);
		$('.sec3_body').empty();
		$('.sec3_body').html(html_sec3);
		
		changeTextColorOfTables();
  }
  
  function loadCFTWODData(data)
  {
		var html_sec1 = "";
		var sec1_classID = "cftwod_sec1_data"; 
		var w = "w_";             //get id
		var dow = "";
		var wodname;
		var lvl_perf = "";
		var type_of_wod = "";
		var descrip = "";
		var time_completed = "";
		var rounds_completed = "";
		var strength = ""; //concat with str.movement and str.description
		var post_wod = ""; //concat with p.movement and p.description
		for(var i = 0; i < data.length; i++) {
			dow = data[i].date_of_wod;
			wodname = data[i].WOD_Name;
			lvl_perf = data[i].level_perf;
			type_of_wod = data[i].type_of_wod;
			descrip = data[i].Description;
			if(type_of_wod == "RFT") {
				rounds_completed = data[i].rounds_compl + " rounds";
			} else if (type_of_wod == "AMRAP" || type_of_wod == "ME" || type_of_wod == "TABATTA" ) {
				rounds_completed = data[i].rounds_compl + " reps";
			}
			time_completed = data[i].time_comp;
			if(data[i].str_mov != "") {
				strength = data[i].str_mov +" "+ data[i].str_des
			}
			
			html_sec1 += "<tr class="+sec1_classID+">";
			html_sec1 += "<td>"+dow+"</td>";
			html_sec1 +="<td>"+wodname+"</td>";
			html_sec1 +="<td>"+lvl_perf+"</td>";
			html_sec1 +="<td>"+type_of_wod+"</td>";
			html_sec1 +="<td class=\"cftwod_descrip\">"+descrip+"</td>";
			html_sec1 +="<td>"+time_completed+"</td>";
			html_sec1 +="<td>"+rounds_completed+"</td>";
			if(strength.length > 2) {
				html_sec1 +="<td>"+strength+"</td>";
			} else {
				html_sec1 +="<td>No Strength</td>";
			}
			
			html_sec1 += "</tr>";
		}
		//Update html content
		$('.wods_table_body').empty();
		$('.wods_table_body').html(html_sec1);
		
		//changeTextColorOfTables();
  }
  
  function setSideBar(id)
  {
	  var html = "";
	  //alert("setSideBar() - Line 1; ID: " + id);
	  $('#sidebar_ul').empty();
	   //alert("setSideBar() - Line 3");
	  if(id == "cft_lnk")
	  {	
	  	 //alert("setSideBar() - in IF");
	  	html += "<li id=\"wod\" ><a href=\"#\">WODS</a></li>";
		html += "<li id=\"cft\" ><a href=\"#\">FOUNDAMENTALS</a></li>";
		html += "<li id=\"grl\" ><a href=\"#\">THE GIRLS</a></li>";
		html += "<li id=\"hro\" ><a href=\"#\">HEROES</a></li>";
		//alert("HTML: " + html);
	  }
	  $('#sidebar_ul').html(html);
  }
  

function nameOfMovement(movement_id)
{ 
 	var value = "Unknown Movement"; 
	if (movement_id == "cft_01") { 
	  value = "Back Squat"; 
	} 
	else if (movement_id == "cft_02") { 
	  value = "Front Squat"; 
	} 
	else if (movement_id == "cft_03") { 
	  value = "Overhead Squat"; 
	}
	else if (movement_id == "cft_04") { 
	  value = "Deadlift"; 
	}
	else if (movement_id == "cft_05") { 
	  value = "SDLHP"; 
	}
	else if (movement_id == "cft_06") { 
	  value = "Power Clean"; 
	}
	else if (movement_id == "cft_07") { 
	  value = "Overhead Press"; 
	}
	else if (movement_id == "cft_08") { 
	  value = "Push Press"; 
	}
	else if (movement_id == "cft_09") { 
	  value = "Push Jerk"; 
	}
  return value; 
}


  </script>
    
</body>
</html>
<?php
mysql_free_result($getUserCFBenchmarks);
?>
