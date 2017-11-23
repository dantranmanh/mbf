<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Create connection to Oracle
$tns2 = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 115.146.126.194)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SID = orcl)))";
$conn = oci_connect("card_credit", "mbfttq#2017", $tns2);
if (!$conn) {
    $m = oci_error();
    echo $m['message'], "\n";
    exit;
}
else {
    print "Connected to Oracle!";
}
//set value for php Input variable
$mobile='918363366';
$fDate=mktime(0,0,0,1,1,2015);
$tDate=mktime(0,0,0,1,1,2016);


$fDate='01-Nov-17';
$tDate='19-Nov-17';
var_dump('mobile number input is : '.$mobile);
/**
 * Make sql string
 * function is inside the pair: begin....end;
 * function come with package name : pkg_query
 * oracle variable come with :  eg: :v_Return, :P_MSISDN, :P_SATISFY_CARD_AMOUNT, :P_OUT
 *
 */

$sql = 'BEGIN :v_Return := pkg_query.FUNC_QUERY_CREDIT_TRANS(:P_MSISDN, :F_DATE, :T_DATE, :P_DATA_CURSOR, :P_OUT); END;';
/**
 * assign oracle stuff to php variables
 */
$curs = oci_new_cursor($conn);
$stmt = oci_parse($conn,$sql);

oci_bind_by_name($stmt,':P_MSISDN',$mobile,20);
oci_bind_by_name($stmt,':F_DATE',$fDate,100);
oci_bind_by_name($stmt,':T_DATE',$tDate,100);
oci_bind_by_name($stmt,':P_DATA_CURSOR', $curs, -1, OCI_B_CURSOR);
oci_bind_by_name($stmt,':P_OUT',$description,500);
oci_bind_by_name($stmt,':v_Return',$result,5);

oci_execute($stmt);
oci_execute($curs);
$strategy = null;
if ($entry = oci_fetch_array($curs)) {

}
echo "<pre>";

var_dump($entry);
var_dump(array('return value: '=>$result,'custor : ' => $curs,'description' =>$description));





// Close the Oracle connection
oci_close($conn);
die("done");