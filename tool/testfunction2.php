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
//$msisdn='918363366';
$msisdn='3434343434';

var_dump('mobile number input is : '.$msisdn);


$sql = 'BEGIN :v_Return := pkg_query.FUNC_QUERY_BLACKLIST(:P_MSISDN, :P_DATA_CURSOR, :P_OUT); END;';

$stmt = oci_parse($conn,$sql);
oci_bind_by_name($stmt,':P_MSISDN', $msisdn, 20);
$p_data_cursor = oci_new_cursor($conn);
oci_bind_by_name($stmt,':P_DATA_CURSOR', $p_data_cursor, -1, OCI_B_CURSOR);

oci_bind_by_name($stmt,':P_OUT', $description, 255);
oci_bind_by_name($stmt,':v_Return', $result, 5);
oci_execute($stmt);
oci_execute($p_data_cursor);
if ($entry = oci_fetch_array($p_data_cursor)) {
    $data = array(
        'title' => "Tra cứu Blacklist",
        'msisdn' => $msisdn,
        'ngaytao' => $entry['CREATE_DATE'],
        'lydo' => $entry['REASON_CODE'],
        'tenlydo' => $entry['REASON_NAME'],
        'trangthai' => $result,
        'description' => $description
    );
}else $data = array(
    'title' => "Tra cứu Blacklist",
    'trangthai' => $result,

    'description' => $description
);

echo "<pre>";

var_dump($entry);






// Close the Oracle connection
oci_close($conn);
die("done");