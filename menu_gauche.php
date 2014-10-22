<?php
if ($_GET['pview'] != 1)
{
	$path = $_SERVER['PHP_SELF'];
	$file = basename ($path);
	if ( $file== 'month_all2.php')
		echo PHP_EOL.'<div id="menuGaucheMonthAll2">'.PHP_EOL;
	else
		echo PHP_EOL.'<div id="menuGauche">'.PHP_EOL;
	$pageActuel = str_replace(".php","",basename($_SERVER['PHP_SELF']));
	minicals($year, $month, $day, $area, $room, $pageActuel);
	$this_area_name = "";
	if (isset($_SESSION['default_list_type']) || (getSettingValue("authentification_obli") == 1))
		$area_list_format = $_SESSION['default_list_type'];
	else
		$area_list_format = getSettingValue("area_list_format");
	if ($area_list_format != "list")
	{
		if ($area_list_format == "select")
		{
			echo make_site_select_html('week_all.php', $id_site, $year, $month, $day, getUserName());
			echo make_area_select_html('week_all.php', $id_site, $area, $year, $month, $day, getUserName());
			echo make_room_select_html('week', $area, $room, $year, $month, $day);
		}
		else
		{
			echo make_site_item_html('week_all.php', $id_site, $year, $month, $day, getUserName());
			echo make_area_item_html('week_all.php',$id_site, $area, $year, $month, $day, getUserName());
			echo make_room_item_html('week', $area, $room, $year, $month, $day);
		}
	}
	else
	{
		echo make_site_list_html('week_all.php',$id_site,$year,$month,$day,getUserName());
		echo make_area_list_html('week_all.php',$id_site, $area, $year, $month, $day, getUserName());
		echo make_room_list_html('week.php', $area, $room, $year, $month, $day);

	}
	if (getSettingValue("legend") == '0')
		show_colour_key($area);
	echo '</div>'.PHP_EOL;
}
?>
