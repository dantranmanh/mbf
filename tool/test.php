<?php
error_reporting(E_ALL);
//phpinfo();
//die();
//putenv("ORACLE_HOME=/u01/app/oracle/product/12.2.0/dbhome_1");
//putenv("LD_LIBRARY_PATH=/opt/app/oracle/product/12.2.0/dbhome_1/lib:/lib:/usr/lib");

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
// Close the Oracle connection
oci_close($conn);
die("done");
/**
//phpinfo();

$conn = oci_connect('card_credit', 'mbfttq#2017','115.146.126.194');
if (!$conn) {
$e = oci_error();
//trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$stid = oci_parse($conn, 'SELECT * FROM BPM_PROCESS');
oci_execute($stid);
/**
echo "<table border='1'>\n";
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
echo "<tr>\n";
foreach ($row as $item) {
echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
}
echo "</tr>\n";
}
echo "</table>\n";
 */



//create table users (userid varchar2(10), password varchar2(20), constraint pk_users primary key (userid));
//insert into users values('kharis', 'pass123');

$nis = isset($_POST['nis']) == true ? $_POST['nis'] : '';
$password= isset($_POST['password']) == true ? $_POST['password'] : '';

if(empty($nis) or empty($password)){
    echo "UserID atau Password kosong";}
else
{
    $db = "(DESCRIPTION =
        (ADDRESS = (PROTOCOL = TCP)(HOST = patronus.ad-ins.com)(PORT = 1521))
        (CONNECT_DATA =
          (SERVER = DEDICATED)
          (SERVICE_NAME = XE)
        )
      )" ;
    $connect = oci_connect("HR", "hr", "XE");
    $query = "SELECT * from users WHERE userid='".$nis."' and password='".$password."'";
    $result = oci_parse($connect, $query);
    oci_execute($result);
    $tmpcount = oci_fetch($result);
    if ($tmpcount==1) {
        echo "Login Success";}
    else
    {
        echo "Login Failed";
    }
}