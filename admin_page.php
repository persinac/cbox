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
$_SESSION['MM_Username'] = "kellintc";
if(!(isset($_SESSION['MM_Username'])))
{
	header("Location: Error401UnauthorizedAccess.php");
}
mysql_select_db($database_cboxConn, $cboxConn);
$colname_getUserBox = "-1";
$userBoxID = "";
$_SESSION['MM_UserID'] = "2";
if (isset($_SESSION['MM_UserID'])) {
  $colname_getUserBox = $_SESSION['MM_UserID'];
  
  $LoginRS__query="select box.box_id from box JOIN athletes AS a ON box.box_id=a.box_id where user_id='{$colname_getUserBox}'"; 
   
  $LoginRS = mysql_query($LoginRS__query, $cboxConn) or die(mysql_error());
  $loginFoundBox = mysql_num_rows($LoginRS);
  if ($loginFoundBox) {
    $row = mysql_fetch_row($LoginRS);
	if (PHP_VERSION >= 5.1) {
		session_regenerate_id(true);
	} 
	else {
			session_regenerate_id();
	}
    //declare session variables and assign them
    $_SESSION['MM_BoxID'] = $row[0];   

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Administrator</title>

<!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="dist/css/admin_page.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="dist/css/jquery.datepick.css"> 
	<link href="dist/css/bootstrap-combined.min.css" rel="stylesheet">


</head>

<body>

<div id="div_container">

    <hr class="featurette-divider">
    <h1>Past WODs</h1>
    <div id="past_wods">
        <table id="tbl_past_wod" rules="cols">
        	<tbody class="tbl_body_past_wods">
			</tbody>
        </table>
    </div><!-- END OF past_wods -->
    
    <hr class="featurette-divider">
    <h1>Past Strength</h1>
    <div id="past_strength">
    	<table id="tbl_past_str" rules="cols">
        	<tbody class="tbl_body_past_str">
			</tbody>
        </table>
    </div><!-- END OF past_strength -->
    
    <hr class="featurette-divider">
    <h1>Past Post WODs</h1>
    <div id="past_post_wods">
    	<table id="tbl_past_pwod" rules="cols">
        	<tbody class="tbl_body_past_pwod">
			</tbody>
        </table>
    </div><!-- END OF past_post_wods -->
    
    <hr class="featurette-divider">
    <h1>New WOD</h1>
    <div id="new_wod_container">
    <form method="POST" id="new_wod_form" class="new_wod">
    	Date: <input type="text" name="date" class="datepicker" id="datepicker"/> 
        Type of WOD: <input type="text" name="type_of_wod" class="type_of_wod" /> 
        <p></p>
        <div id="new_wod_row">
            Movement: <input type="text" name="movement[]" class="movement" id="movement_0"/> 
            Weight (leave blank if bodyweight): <input type="text" name="weight[]" class="weight" id="weight_0"/> 
            Reps: <input type="text" name="reps[]" class="reps" id="reps_0"/>
            <p></p>
        </div> <!-- END OF new_wod -->
        <input onclick="addRow(this.form);" type="button" value="Add row" />
        <input onclick="submitWOD(this.form);" type="button" value="Submit WOD" />
     </form>
     <a href='#' onclick='overlay()'>Click here to show the overlay</a>
     
     </div> <!-- END OF new_wod_container -->
    
   
<h2>Example of creating Modals with Twitter Bootstrap</h2>
	<div id="example_modal" class="modal" style="display:none; ">
        <div class="modal-header">
          <a class="close" data-dismiss="modal">×</a>
          <h3>This is a Modal Heading</h3>
        </div>
        <div class="modal-body">
          <h4>Text in a modal</h4>
          <p>You can add some text here.</p>                
        </div>
        <div class="modal-footer">
          <button class="btn btn-success" id="submit">submit</button>
          <a href="#" class="btn" data-dismiss="modal">Close</a>
        </div>
    </div>
<p><a data-toggle="modal" href="#example_modal" class="btn btn-primary btn-large">Launch demo        modal</a></p>
   
    
    <hr class="featurette-divider">
    <div id="new_strength">
    	<p>NEW STRENGTH FORM HERE</p>
    </div><!-- END OF past_post_wods -->
    
    <hr class="featurette-divider">
    <div id="new_post_wod">
    	<p>NEW POST WOD FORM HERE</p>
    </div><!-- END OF past_post_wods -->
    
    <div id="overlay">
     <div>
          <p>Content you want the user to see goes here.</p>
          Click here to [<a href='#' onclick='overlay()'>close</a>]
     </div>
</div>

</div> <!-- END OF DIV_CONTAINER -->

<!-- JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="dist/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script type="text/javascript" src="dist/js/jquery.plugin.js"></script> 
<script type="text/javascript" src="dist/js/jquery.datepick.js"></script>

<script id="source" language="javascript" type="text/javascript">

$(document).ready(function() {
	event.preventDefault();
	//load past wods/str/pwods
	getPastWODS(<?php echo $_SESSION['MM_BoxID'] ?>);
	getPastStrength(<?php echo $_SESSION['MM_BoxID'] ?>);
	getPastPostWODS(<?php echo $_SESSION['MM_BoxID'] ?>);
});

$(function() {
	event.preventDefault();
    $("#datepicker").datepick({dateFormat: 'yyyy-mm-dd'});
  });
  
  $(function() {
//twitter bootstrap script
    $("button#submit").click(function(){
		alert("YOU CLICKED SUBMIT!!!");
		/*
               $.ajax({
                   type: "POST",
            url: "process.php",
            data: $('form.contact').serialize(),
                success: function(msg){
                         $("#thanks").html(msg)
                     $("#form-content").modal('hide');    
                 },
            error: function(){
                alert("failure");
                }
                  });
				  */
    });
});
  

function overlay() {
	event.preventDefault();
	var dimension = (document.body.scrollTop + document.documentElement.scrollTop + 100)+"px";
	el = document.getElementById("overlay");
	$(el).css({ top: dimension });
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
}

function getPastWODS(box_id)
{
	var boxID = box_id;
	
	//$('.tbl_past_wod').empty();
	var html = "";
	

	//alert("HTML: " + html )
	$('.tbl_past_wod').html(html);
	//now load data into table
	$.ajax(
	{ 
	  type:"POST",                                     
	  url:"getAdminWODs.php",         
	  data: { "dataString" : boxID }, //insert argumnets here to pass to getAdminWODs
	  dataType: "json",                //data format      
	  success: function(response_wods) //on recieve of reply
	  {
		  //alert("response_wods: " + response_wods);
		loadPastWODS(response_wods);
	  },
  	  error: function(){
    		alert('error loading wods!');
  		}
	});
	//alert("Past WODs FIN");
}

function getPastStrength(box_id)
{
	var boxID = box_id;
	
	//$('.tbl_past_wod').empty();
	var html = "";
	

	//alert("HTML: " + html )
	$('.tbl_past_str').html(html);
	//now load data into table
	$.ajax(
	{ 
	  type:"POST",                                     
	  url:"getAdminStrength.php",         
	  data: { "dataString" : boxID }, //insert argumnets here to pass to getAdminWODs
	  dataType: "json",                //data format      
	  success: function(response) //on recieve of reply
	  {
		loadPastStr(response);
	  },
  	  error: function(){
    		alert('error loading strength!');
  		}
	});
	//alert("Past WODs FIN");
}

function getPastPostWODS(box_id)
{
	var boxID = box_id;
	
	//$('.tbl_past_wod').empty();
	var html = "";
	

	//alert("HTML: " + html )
	$('.tbl_past_pwod').html(html);
	//now load data into table
	$.ajax(
	{ 
	  type:"POST",                                     
	  url:"getAdminPWODs.php",         
	  data: { "dataString" : boxID }, //insert argumnets here to pass to getAdminWODs
	  dataType: "json",                //data format      
	  success: function(response_wods) //on recieve of reply
	  {
		  //alert("response_wods: " + response_wods);
		loadPastPWODS(response_wods);
	  },
  	  error: function(){
    		alert('error loading wods!');
  		}
	});
}


function loadPastWODS(data_wods)
{
	var t_data = data_wods;
	
	var html_sec1 = "";
	var sec1_classID = "pastwod_sec1_data"; 
	var wod_id = "";
	var dow = "";
	var wodname;
	var type_of_wod = "";
	var descrip = "";
	//alert("loadPastWODS PRE-FOR LOOP");
	//alert("DATA: " + data_wods);
	//alert("t_DATA: " + t_data);
	for(var i = 0; i < data_wods.length; i++) {
		wod_id = data_wods[i].wod_id;
		dow = data_wods[i].date_of_wod;
		wodname = data_wods[i].name_of_wod;
		type_of_wod = data_wods[i].type_of_wod;
		descrip = data_wods[i].rx_descrip;
		
		html_sec1 += "<tr class="+sec1_classID+">";
		html_sec1 += "<td>"+wod_id+"</td>";
		html_sec1 += "<td>"+dow+"</td>";
		html_sec1 +="<td>"+wodname+"</td>";
		html_sec1 +="<td>"+type_of_wod+"</td>";
		html_sec1 +="<td class=\"pastwod_descrip\">"+descrip+"</td>";
		html_sec1 += "</tr>";
	}
	//Update html content
	//alert("HTML: " + html);
	$('.tbl_body_past_wods').empty();
	$('.tbl_body_past_wods').html(html_sec1);
	
}

function loadPastStr(data)
{
	var t_data = data;
	
	var html_sec1 = "";
	var sec1_classID = "str_sec1_data"; 
	var str_id = "";
	var dos = "";
	var movement = "";
	var descrip = "";

	for(var i = 0; i < data.length; i++) {
		str_id = data[i].str_id;
		dos = data[i].date_of_str;
		movement = data[i].movement;
		descrip = data[i].descrip;
		
		html_sec1 += "<tr class="+sec1_classID+">";
		html_sec1 += "<td>"+str_id+"</td>";
		html_sec1 += "<td>"+dos+"</td>";
		html_sec1 +="<td>"+movement+"</td>";
		html_sec1 +="<td class=\"paststr_descrip\">"+descrip+"</td>";
		html_sec1 += "</tr>";
	}
	//Update html content
	$('.tbl_body_past_str').empty();
	$('.tbl_body_past_str').html(html_sec1);
	
}

function loadPastPWODS(data)
{
	var t_data = data;
	
	var html_sec1 = "";
	var sec1_classID = "pwod_sec1_data"; 
	var pwod_id = "";
	var dop = "";
	var type_of_pwod = "";
	var descrip = "";

	for(var i = 0; i < data.length; i++) {
		pwod_id = data[i].pwod_id;
		dop = data[i].date_of_pwod;
		type_of_pwod = data[i].type_of_pwod;
		descrip = data[i].descrip;
		
		html_sec1 += "<tr class="+sec1_classID+">";
		html_sec1 += "<td>"+pwod_id+"</td>";
		html_sec1 += "<td>"+dop+"</td>";
		html_sec1 +="<td>"+type_of_pwod+"</td>";
		html_sec1 +="<td class=\"pastpwod_descrip\">"+descrip+"</td>";
		html_sec1 += "</tr>";
	}
	//Update html content
	$('.tbl_body_past_pwod').empty();
	$('.tbl_body_past_pwod').html(html_sec1);
}

var rowNum = 0;
function addRow(frm) {
	rowNum ++;
	var row = '<p id="rowNum'+rowNum+'">Movement: <input type="text" name="movement[]" class="movement" id="movement_'+rowNum+'"> Weight (leave blank if bodyweight): <input type="text" name="weight[]" class="weight" id="weight_'+rowNum+'"> Reps: <input type="text" name="reps[]" class="reps" id="reps_'+rowNum+'"> <input type="button" value="Remove" onclick="removeRow('+rowNum+');"></p>';
	$('#new_wod_row').append(row);
	frm.add_qty.value = '';
	frm.add_name.value = '';
}
function removeRow(rnum) {
	$('#rowNum'+rnum).remove();
}

function submitWOD() {
	var datastring = $("#new_wod_form").serializeArray();
	var sendRequest = false;
	
	//WORKING
	$('.movement').each(function(i, item) {
        var movement =  $('#movement_'+i+'').val();
		var characterReg = /^[a-zA-Z]*$/;
		if(!characterReg.test(movement)) {
			$('#movement_'+i+'').addClass("decoratedErrorField");
		}
        //alert(movement);
    });
	
	//alert("Post Movement check");
	
	$('.weight').each(function(i, item) {
		//alert("Inside weight check");
        var weight =  $('#weight_'+i+'').val();
		//var characterReg = /^\d+$/;
		var characterReg = /^[0-9]*$/;
		if(!characterReg.test(weight)) {
			$('#weight_'+i+'').addClass("decoratedErrorField");
		}
        //alert(weight);
    });
	
	//alert("Post weight check");
	
	$('.reps').each(function(i, item) {
		//alert("Inside reps check");
        var reps =  $('#reps_'+i+'').val();
		var characterReg = /^[0-9]*$/;
		if(!characterReg.test(reps)) {
			$('#reps_'+i+'').addClass("decoratedErrorField");
		}
        //alert(reps);
    });
	
	//alert("Post reps check");
	
        $.ajax({
            type: "POST",
            url: "php_form_test.php",
            data: $("#new_wod_form").serialize(),
            success: function(data) {
                 alert('Data send:' + data);
            }
        });
}



</script>

</body>
</html>