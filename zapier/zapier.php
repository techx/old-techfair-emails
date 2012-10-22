<?php
$log = fopen('error.log', 'r+');
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  fwrite($log, "NOPE");
  fclose($log);
  return;
}
$mysql = mysql_connect('mysql.mit.edu', 'techfair', '02139techfair') or die(mysql_error());
mysql_select_db('techfair+emails');

$query = sprintf("INSERT into emails (%s,%s,%s,%s,%s,%s,%s) VALUES ('%s','%s','%s','%s','%s','%s','%s')",
  "from_name",
  "from_address",
  "to_name",
  "to_address",
  "thread_id",
  "subject",
  "message",
  mysql_real_escape_string($_POST['from_name']),
  mysql_real_escape_string($_POST['from_address']),
  mysql_real_escape_string($_POST['to_name']),
  mysql_real_escape_string($_POST['to_address']),
  mysql_real_escape_string($_POST['thread_id']),
  mysql_real_escape_string($_POST['subject']),
  mysql_real_escape_string($_POST['message'])
);
fwrite($log, $query);
$success = mysql_query($query) or die(mysql_error());
if (!$success) {
  $log = fopen('error.log', 'r+');
  fwrite($log, mysql_error());
}
fclose($log);
?>
