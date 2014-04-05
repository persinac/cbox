<?php
echo "<!doctype html>
<html>
<head>
<meta charset=\"utf-8\">
<title>Untitled Document</title>
</head>
<body>";

$t_movement = "";
$t_weight = "";
$t_reps = "";
$t_typeOfWOD = $_POST['type_of_wod'];
$t_date = $_POST['date'];

$t_string_builder = "";

echo "Date: " . $t_date . " ";
echo "Type of WOD: " . $t_typeOfWOD . " ";
echo "WOD: ";
foreach( $_POST['movement'] as $cnt => $mvmnt ) {
    if( is_array( $mvmnt ) ) {
        foreach( $mvmnt as $thing ) {
            echo "THING: " . $thing . " ";
        }
    } else {
		$t_movement = $_POST['movement'][$cnt];
		$t_weight = $_POST['weight'][$cnt];
		$t_reps = $_POST['reps'][$cnt];
		
		if(strlen($t_weight) > 0) {
		$t_string_builder .= $t_reps . " reps of " . $t_movement . " @ " . $t_weight . "lbs, " ;
		} else {
			$t_string_builder .= $t_reps . " reps of " . $t_movement . " @ bodweight, " ;
		}
    }
}
echo $t_string_builder;
echo "<body>
</body>
</html>";
?>