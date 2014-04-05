<?php session_start(); ?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
	<h1> <?php echo "ADMIN CODE: " . $_SESSION['MM_Admin']; ?> </h1> 
    <h2> <?php echo "VAL ONE: " . $_SESSION['testValOne']; ?> </h2>
    <h3> <?php echo "VAL TWO: " . $_SESSION['testValTwo']; ?> </h3>
    <h4> <?php echo "VAL THREE: " . $_SESSION['testValThree']; ?> </h4>
    <p><?php echo "Username: " . $_SESSION['MM_Username']; ?> </p>
    <p><?php echo "User ID: " . $_SESSION['MM_UserID']; ?> </p>
</body>
</html>