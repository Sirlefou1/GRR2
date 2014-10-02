<?php
/*-----MAJ Loïs THOMAS  -->Menu en bleu à gauche : Faire un include pour insérer ce menu-----*/
//Fichier nécessaire include/functions.inc.php et include/mincals.inc.php
// Si format imprimable ($_GET['pview'] = 1), on n'affiche pas cette partie
if ($_GET['pview'] != 1)
{
	/*-----MAJ Loïs THOMAS  -->Test pour savoir le style du menu gauche-----*/
	$path = $_SERVER['PHP_SELF'];
	$file = basename ($path);
	if ( $file== 'month_all2.php')
		echo "\n<div id=\"menuGaucheMonthAll2\">";
	else
		echo "\n<div id=\"menuGauche\">";
	//MAJ Hugo - Reparation du problème des liens vers les semaines du calendrier pour
	//21/05/2013
	//str_replace enleve le .php
	$pageActuel = str_replace(".php","",basename($_SERVER['PHP_SELF']));
	//Draw the three month calendar
	minicals($year, $month, $day, $area, $room, $pageActuel);
	//Table with areas, rooms, minicals.
	// echo "\n<table width=\"100%\" cellspacing=\"15\"><tr>\n";
	$this_area_name = "";
	if (isset($_SESSION['default_list_type']) || (getSettingValue("authentification_obli") == 1))
		$area_list_format = $_SESSION['default_list_type'];
	else
		$area_list_format = getSettingValue("area_list_format");
	//Sélection des sites, domaines et ressources
	if ($area_list_format != "list")
	{
		if ($area_list_format == "select")
		{
		//Sélection sous la forme de listes déroulantes
		//echo "<td>\n";
			echo make_site_select_html('week_all.php', $id_site, $year, $month, $day, getUserName());
			echo make_area_select_html('week_all.php', $id_site, $area, $year, $month, $day, getUserName());
			echo make_room_select_html('week', $area, $room, $year, $month, $day, getUserName());
		//echo "</td>\n";
		}
		else
		{
		//Sélection sous la forme d'items
		//echo "<td>\n";
			echo make_site_item_html('week_all.php', $id_site, $year, $month, $day, getUserName());
			echo make_area_item_html('week_all.php',$id_site, $area, $year, $month, $day, getUserName());
			echo make_room_item_html('week', $area, $room, $year, $month, $day, getUserName());
		//echo "</td>\n";
		}
	}
	else
	{
	//Sélection sous la forme de listes
	//echo "<td>\n";
		echo make_site_list_html('week_all.php',$id_site,$year,$month,$day,getUserName());
	//echo "</td> <td>";
		make_area_list_html('week_all.php',$id_site, $area, $year, $month, $day, getUserName());
	//echo "</td> <td>";
		make_room_list_html('week.php', $area, $room, $year, $month, $day,getUserName());
	//echo "</td>\n";
	}
	//Affichage de la légende
	if (getSettingValue("legend") == '0')
		show_colour_key($area);
	//Afficher Aide +Administreur
	//Fermeture id menuGauche
	echo "</div>\n";
}
?>
