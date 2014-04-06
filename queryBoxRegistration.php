<?php require_once('Connections/cboxConn.php'); ?>
<?php
#session_start();

$t_firstname = $_POST['firstname'];
$t_lastname = $_POST['lastname'];
$t_phoneNumber = $_POST['phoneNumber'];
$t_boxName = $_POST['boxName'];
$t_email = $_POST['email'];
$t_streetAddress = $_POST['streetAddress'];
$t_city = $_POST['city'];
$t_state= $_POST['state'];
$t_zipCode= $_POST['zipCode'];
$t_country= $_POST['country'];

#######
#
# MySql insert
#
# Need to get box ID based on user first
#
#######


mysql_select_db($database_cboxConn, $cboxConn);

$query_selectMax = "select max(box_id) from box";

$selectMax = mysql_query($query_selectMax, $cboxConn) or die(mysql_error());
$totalRows_getAdminWODs = mysql_num_rows($selectMax);
####echo $totalRows_getAdminWODs;
$row = mysql_fetch_array($selectMax);
$row= $row+1;
$t_box_id=$row;

$query_registerNewBox = "insert into box values ('{$t_box_id}', '{$t_box_name}', '{$t_streetAddress}', '{$t_city}', '{$t_state}', '{$t_Zip}', '{$t_Country}', '{$t_phoneNumber}', '{$t_firstName}', '{$t_lastName}')";

$retval = mysql_query( $query_insert_wod, $cboxConn );
if(! $retval )
{
 die('Could not enter data: ' . mysql_error());
}

mysql_close($cboxConn);

?>