<?php
include "include/connect.inc.php";
include "include/mysql.inc.php";
include "include/misc.inc.php";
if (isset($_POST["link"]) && strlen($_POST["link"]) > 0)
{
	$file = $_POST["link"];
	$path = "uploadify/files/";
	if (unlink($path.$file))
	{
		$sql = "DELETE from ".TABLE_PREFIX."_files WHERE nom = '".$file."' ";
		grr_sql_command($sql);
		echo "deleted";
	}
}
?>
