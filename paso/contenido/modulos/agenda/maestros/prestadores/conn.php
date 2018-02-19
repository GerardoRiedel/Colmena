<?php

$conn = @mysql_connect('localhost','cetepcl','rootsecurity626');
if (!$conn) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db('cetepcl_agenda', $conn);

?>