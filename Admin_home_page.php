<?php
	session_start();
	
	if(!(isset($_SESSION['MM_Username'])))
	{
		header("Location: Error401UnauthorizedAccess.php");
	}
	
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link href="dist/css/home_page_css.css" rel="stylesheet">
</head>

<body>
<div id="div_container">
	<ul id="admin_ul_main_menu">
    	<li id="progress"><a href="User_progress_page.php">PROGRESS</a></li>
        <li id="WOD"><a href="">WOD</a></li>
        <li id="COMPARE"><a href="">COMPARE</a></li>
        <li id="ADMIN"><a href="admin_page.php">ADMIN</a></li>
    </ul>
</div>
</body>
</html>